<?php namespace vAMSYS\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Neoxygen\NeoClient\ClientBuilder;
use SplFileObject;
use Symfony\Component\HttpFoundation\File\File;

class ParseTextDataCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ats {airac : The AIRAC ID} {file : The location of the ATS file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import an X-FMC Native ATS file';

    protected $neo4j;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->neo4j = ClientBuilder::create()
        ->addConnection('default',
            Config::get('database.neo4j.profiles.default.scheme'),
            Config::get('database.neo4j.profiles.default.host'),
            (int)Config::get('database.neo4j.profiles.default.port'),
            true,
            Config::get('database.neo4j.profiles.default.username'),
            Config::get('database.neo4j.profiles.default.password'))
        ->setAutoFormatResponse(true)
        ->registerExtension('spatial', 'Neoxygen\NeoClientExtension\Spatial\SpatialExtension')
        ->build();
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $this->parseATS($this->argument('airac'), $this->argument('file'));

//		$notificationEmail = $this->notificationEmail;
//
//		Mail::queue('emails.parseTextData', ['outputs' => $outputs], function($message) use ($notificationEmail)
//		{
//			$message->to($notificationEmail)->subject('[vAMSYS] Task Complete: Parse Text Data');
//		});
    }

    private function parseATS($airacId, $path){
        // Actually do the parsing!
        set_time_limit(0);

        file_put_contents("/tmp/ats.txt", fopen($path, 'r'));

        $atsFile = new File("/tmp/ats.txt");
        $atsFile = $atsFile->openFile();
        $atsFile->setFlags(SplFileObject::READ_CSV);
        $atsFile->setCsvControl('|');

        $atsFile->seek($atsFile->getSize());
        $linesTotal = $atsFile->key();
        $atsFile->seek(0);

        $bar = $this->output->createProgressBar($linesTotal);
        $bar->setFormat('<info>Current Task: %message%</info>
<comment>%current%/%max% [%bar%] %percent:3s%%</comment>
<fg=cyan;bg=black>Time: %elapsed:6s%</>
<fg=magenta;bg=black>ETC: %estimated%</>
<error>Memory: %memory:6s%</error>');
        $bar->setRedrawFrequency(100);
        $bar->start();

        foreach($atsFile as $dataLine){
            // Store into Neo4J
            $bar->advance();

            $currentAirway = 'UNKNOWN';

            // Set the current airway
            if ($dataLine[0] == 'A'){
                $bar->setMessage('Airway: '.$dataLine[1]);
                $currentAirway = $dataLine[1];
                continue;
            }

            if ($dataLine[0] == 'S'){
                // New Waypoint
                $latitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[2]);
                $longitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[3]);
                $nlatitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[5]);
                $nlongitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[6]);

                $transaction = $this->neo4j->createTransaction();
                $transaction->pushQuery('MERGE (wp:Waypoint'.$airacId.' {name: {props}.id, latitude: {props}.latitude, longitude: {props}.longitude}) RETURN wp', ["props" => [
                        "name"	=> $dataLine[1],
                        "latitude"	=> (float)$latitude,
                        "longitude"	=> (float)$longitude,
                    ]]);
                $transaction->pushQuery('MERGE (wp:Waypoint'.$airacId.' {name: {props}.id, latitude: {props}.latitude, longitude: {props}.longitude}) RETURN wp', ["props" => [
                    "name"	=> $dataLine[4],
                    "latitude"	=> (float)$nlatitude,
                    "longitude"	=> (float)$nlongitude,
                ]]);
                $transaction->pushQuery('MATCH (wp1:Waypoint'.$airacId.' {name: {wp1props}.id, latitude: {wp1props}.latitude, longitude: {wp1props}.longitude}),(wp2:Waypoint'.$airacId.' {name: {wp2props}.id, latitude: {wp2props}.latitude, longitude: {wp2props}.longitude}) CREATE UNIQUE (wp1)-[r:'.$currentAirway.']->(wp2) RETURN r', [
                    "wp1props" => [
                        "name"	=> $dataLine[1],
                        "latitude"	=> (float)$latitude,
                        "longitude"	=> (float)$longitude,
                    ],
                    "wp2props" => [
                        "name"	=> $dataLine[4],
                        "latitude"	=> (float)$nlatitude,
                        "longitude"	=> (float)$nlongitude,
                ]]);
                $transaction->commit();
            }
        }
        $bar->finish();

    }

}
