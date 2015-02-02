<?php namespace vAMSYS\Console\Commands;

use Illuminate\Console\Command;
use SplFileObject;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\File\File;
use vAMSYS\Country;
use vAMSYS\Region;

class ImportRegionsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vamsys:import:regions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import regions from provided OurAirports CSV';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
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
		$regionsFile = new File($this->argument('file'));
		$regionsFile = $regionsFile->openFile();
		$regionsFile->setFlags(SplFileObject::READ_CSV);

		$this->info('Beginning Import...');
		$i = 0;
		foreach($regionsFile as $region){
			$i++;
			if ($i % 10 == 0){
				$this->comment('Imported '.$i.'...');
			}
			if (isset($region[1]) && $i > 1) {
				$insertRegion            	= new Region();
				$insertRegion->code      	= $region[1];
				$insertRegion->name      	= $region[3];
				$insertRegion->country_id = Country::where('code', '=', $region[5])->first()->id;
				$insertRegion->save();
			}
		}
		$this->info('Import Complete! '.$i.' Regions Imported.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['file', InputArgument::REQUIRED, 'The OurAirports regions.csv file', null],
		];
	}

}
