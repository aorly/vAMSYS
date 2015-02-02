<?php namespace vAMSYS\Commands;

use GuzzleHttp\Message\Response;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Mail;
use Neoxygen\NeoClient\ClientBuilder;
use SplFileObject;
use Symfony\Component\HttpFoundation\File\File;

class ParseTextDataCommand extends Command implements SelfHandling, ShouldBeQueued {

	protected $path;
	/**
	 * @var
	 */
	private $notificationEmail;

	/**
	 * Create a new command instance.
	 *
	 * @param array $paths The paths to process
	 * @param string $notificationEmail The email address to notify on completion
	 */
	public function __construct($paths, $notificationEmail)
	{
		$this->paths = $paths;
		$this->notificationEmail = $notificationEmail;
		$this->neo4j = ClientBuilder::create()
			->addDefaultLocalConnection()
			->setAutoFormatResponse(true)
			->build();
	}

	/**
	 * Execute the command.
	 */
	public function handle()
	{
		$outputs = [];
		foreach ($this->paths as $type => $path) {
			switch ($type) {
				case "ATS":
					$outputs[$type] = json_encode($this->parseATS($path));
					break;
				case "Regions":
					$outputs[$type] = json_encode($this->parseATS($path));
					break;
			}
		}

//		$notificationEmail = $this->notificationEmail;
//
//		Mail::queue('emails.parseTextData', ['outputs' => $outputs], function($message) use ($notificationEmail)
//		{
//			$message->to($notificationEmail)->subject('[vAMSYS] Task Complete: Parse Text Data');
//		});
	}

	private function parseATS($path){
		// Actually do the parsing!
		set_time_limit(0);

		$airacId = 1501;
		$atsFile = new File($path);
		$atsFile = $atsFile->openFile();
		$atsFile->setFlags(SplFileObject::READ_CSV);
		$atsFile->setCsvControl('|');

		foreach($atsFile as $dataLine){
			// Store into Neo4J

			// Set the current airway
			if ($dataLine[0] == 'A'){
				echo 'New Airway Started: '.$dataLine[1].PHP_EOL;
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

				$response = $this->neo4j->singleQuery($query, $params);

				if (count(json_decode($response->getBody())->results[0]->data) == 0){
					// Not found - create!
					$query = "CREATE (wp:Waypoint".$airacId." {props}) RETURN id(wp);";
					$params = [
						"props" => [
							"name"	=> $dataLine[1],
							"latitude"	=> (float)$latitude,
							"longitude"	=> (float)$longitude,
						]
					];

					$response = $this->neo4j->singleQuery($query, $params);
				}
				$thisNodeId = json_decode($response->getBody())->results[0]->data[0]->row[0];

				// Does the next node exist?
				$latitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[5]);
				$longitude = preg_replace('/^(.*?)(.{6})$/', '$1.$2', $dataLine[6]);
				$query = "MATCH (wp:Waypoint".$airacId.") WHERE wp.name = {name} AND wp.latitude = {latitude} AND wp.longitude = {longitude} RETURN id(wp);";
				$params = [
					"name"	=> $dataLine[4],
					"latitude"	=> (float)$latitude,
					"longitude"	=> (float)$longitude
				];

				$response = $this->neo4j->singleQuery($query, $params);

				if (count(json_decode($response->getBody())->results[0]->data) == 0){
					// Not found - create!
					$query = "CREATE (wp:Waypoint".$airacId." {props}) RETURN id(wp);";
					$params = [
						"props" => [
							"name"	=> $dataLine[4],
							"latitude"	=> (float)$latitude,
							"longitude"	=> (float)$longitude,
						]
					];

					$response = $this->neo4j->singleQuery($query, $params);
				}
				$nextNodeId = json_decode($response->getBody())->results[0]->data[0]->row[0];

				// Link the two nodes!
				$this->neo4j->createRelationship($thisNodeId, $nextNodeId, $currentAirway);
			}

		}

		return Response::make("Complete");

	}

}
