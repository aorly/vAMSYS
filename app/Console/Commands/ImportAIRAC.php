<?php namespace vAMSYS\Console\Commands;

use Illuminate\Console\Command;
use SplFileObject;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\File\File;
use vAMSYS\Airport;
use vAMSYS\Country;
use vAMSYS\Region;

class ImportAIRAC extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vamsys:import:airac';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import AIRAC from provided file';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        dd('WIP');
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Parse the CSV file and insert rows
		$this->info('Loading CSV...');
		$airportsFile = new File($this->argument('file'));
		$airportsFile = $airportsFile->openFile();
		$airportsFile->setFlags(SplFileObject::READ_CSV);

		$this->info('Beginning Import...');
		$i = 0;
		foreach($airportsFile as $airport){
			$i++;
			if ($i % 10 == 0){
				$this->comment('Imported '.$i.'...');
			}
			if (isset($airport[1]) && $i > 1) {
				$insertAirport            = new Airport();
				$insertAirport->icao      = $airport[1];
				$insertAirport->iata      = $airport[13];
				$insertAirport->name 			= $airport[3];
				$insertAirport->latitude 	= $airport[4];
				$insertAirport->longitude = $airport[5];
				$insertAirport->region_id = Region::where('code', '=', $airport[9])->first()->id;
				$insertAirport->save();
			}
		}
		$this->info('Import Complete! '.$i.' Airports Imported.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['file', InputArgument::REQUIRED, 'The AIRAC file', null],
		];
	}

}
