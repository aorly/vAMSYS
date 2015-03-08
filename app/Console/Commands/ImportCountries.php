<?php namespace vAMSYS\Console\Commands;

use Illuminate\Console\Command;
use SplFileObject;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\File\File;
use vAMSYS\Country;

class ImportCountries extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vamsys:import:countries';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import countries from provided OurAirports CSV';

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
		$countriesFile = new File($this->argument('file'));
		$countriesFile = $countriesFile->openFile();
		$countriesFile->setFlags(SplFileObject::READ_CSV);

		$this->info('Beginning Import...');
		$i = 0;
		foreach($countriesFile as $country){
			$i++;
			if ($i % 10 == 0){
				$this->comment('Imported '.$i.'...');
			}
			if (isset($country[1]) && $i > 1) {
				$insertCountry            = new Country();
				$insertCountry->code      = $country[1];
				$insertCountry->name      = $country[2];
				$insertCountry->continent = $country[3];
				$insertCountry->save();
			}
		}
		$this->info('Import Complete! '.$i.' Countries Imported.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['file', InputArgument::REQUIRED, 'The OurAirports countries.csv file', null],
		];
	}

}
