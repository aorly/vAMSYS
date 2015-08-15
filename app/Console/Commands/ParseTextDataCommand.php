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
        date_default_timezone_set('UTC');
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
                // Try and find the waypoint
                $query = "MATCH (wp:Waypoint".$airacId.") WHERE wp.name = {name} AND wp.latitude = {latitude} AND wp.longitude = {longitude} RETURN id(wp);";
                $params = [
                    "name"	=> $dataLine[1],
                    "latitude"	=> (float)$latitude,
                    "longitude"	=> (float)$longitude
                ];
                /* var $response \Neoxygen\NeoClient\Request\Response */
                $response = $this->neo4j->sendCypherQuery($query, $params);

                if (count($response->getBody()['results'][0]['data']) == 0){
                    // Not found - create!
                    $query = "CREATE (wp:Waypoint".$airacId." {props}) RETURN id(wp);";
                    $params = [
                        "props" => [
                            "name"	=> $dataLine[1],
                            "latitude"	=> (float)$latitude,
                            "longitude"	=> (float)$longitude,
                        ]
                    ];

                    $response = $this->neo4j->sendCypherQuery($query, $params);
                }
                $thisNodeId = $response->getBody()['results'][0]['data'][0]['row'][0];

                // Does the next node exist?
                $latitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[5]);
                $longitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[6]);
                $query = "MATCH (wp:Waypoint".$airacId.") WHERE wp.name = {name} AND wp.latitude = {latitude} AND wp.longitude = {longitude} RETURN id(wp);";
                $params = [
                    "name"	=> $dataLine[4],
                    "latitude"	=> (float)$latitude,
                    "longitude"	=> (float)$longitude
                ];

                $response = $this->neo4j->sendCypherQuery($query, $params);

                if (count($response->getBody()['results'][0]['data']) == 0){
                    // Not found - create!
                    $query = "CREATE (wp:Waypoint".$airacId." {props}) RETURN id(wp);";
                    $params = [
                        "props" => [
                            "name"	=> $dataLine[4],
                            "latitude"	=> (float)$latitude,
                            "longitude"	=> (float)$longitude,
                        ]
                    ];

                    $response = $this->neo4j->sendCypherQuery($query, $params);
                }
                $nextNodeId = $response->getBody()['results'][0]['data'][0]['row'][0];

                // Link the two nodes!
                $query = "MATCH (wp1:Waypoint".$airacId."),(wp2:Waypoint".$airacId.") WHERE id(wp1) = {wp1} AND id(wp2) = {wp2} CREATE (wp1)-[r:".$currentAirway."]->(wp2) RETURN r;";
                $params = [
                    "wp1" => $thisNodeId,
                    "wp2" => $nextNodeId,
                ];
                $this->neo4j->sendCypherQuery($query, $params);
            }
        }
        $bar->finish();

    }

}
