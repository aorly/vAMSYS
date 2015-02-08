<?php namespace vAMSYS\Http\Controllers;

use Illuminate\Http\Request;
use League\Period\Period;
use vAMSYS\Contracts\SmartCARS;
use vAMSYS\Pilot;
use vAMSYS\SmartCARS_Session;

/**
 * Class smartCARSController
 * @package vAMSYS\Http\Controllers
 */
class smartCARSController extends Controller {
	/**
	 * @var SmartCARS
	 */
	private $smartCARSService;

	private $userid;

	/**
	 * @param SmartCARS $smartCARSService
	 */
	public function __construct(SmartCARS $smartCARSService)
	{
		$this->smartCARSService = $smartCARSService;
	}


	/**
	 * Handles the smartCARS 2 Client Requests
	 * @param Request $request
	 * @param $airlineICAO
	 */
	public function main(Request $request, $airlineICAO)
	{
		// The smartCARS Client basically sends a huge bunch of GET parameters (and occasionally POST).
		// These need to be interpreted to find out what it wants.

		// Format the sent username
		if ($request->has('userid'))
			$this->userid = $airlineICAO.str_pad($request->input('userid'), 4, 0, STR_PAD_LEFT);

		switch ($request->input('action')){
			case "manuallogin":
				echo $this->handleManualLogin($request);
				break;
			case "automaticlogin":
				echo $this->handleAutomaticLogin($request);
				break;
			case "verifysession":
				echo $this->handleVerifySession($request);
				break;
			case "getpilotcenterdata":
				echo $this->handlePilotCentreData($request);
				break;
			case "getairports":
				echo $this->handleAirports($request);
				break;
			case "getaircraft":
				echo $this->handleAircraft($request);
				break;
			case "getbidflights":
				echo $this->handleBidFlights($request);
				break;

			default:
				echo("Script OK, Frame Version: vAMSYS-080215, Interface Version: ".$airlineICAO."-080215");
		}

		// Prevent further output
		die();

	}

	private function handleManualLogin($request)
	{
		$this->smartCARSService->clearOldSessions();

		if (!filter_var($this->userid, FILTER_VALIDATE_EMAIL)){
			// It's not an email address - try and find the user from our Pilots!
			if ($pilot = Pilot::where('username', '=', $this->userid)->first()){
				if (password_verify($request->input('password'), $pilot->user->password)){
					// Success!
					// todo check inactivity
					$ret = [
						'dbid' 				=> $pilot->id,
						'code' 				=> $pilot->airline->prefix,
						'pilotid' 		=> str_replace($pilot->airline->prefix, '', $pilot->username),
						'firstname' 	=> $pilot->user->first_name,
						'lastname' 		=> $pilot->user->last_name,
						'email' 			=> $pilot->user->email,
						'ranklevel' 	=> $pilot->rank->level,
						'rankstring' 	=> $pilot->rank->name,
					];
					$this->smartCARSService->writeSessionId($pilot->id, $request->input('sessionid'));
					$result = $this->smartCARSService->sanitizeResult($ret);
					if ($request->input('new') == 'true') {
						return implode(",", [
							$result['dbid'],
							$result['code'],
							$result['pilotid'],
							$request->input('sessionid'),
							$result['firstname'],
							$result['lastname'],
							$result['email'],
							$result['ranklevel'],
							$result['rankstring'],
						]);
					}

					return implode(",", [
						$result['dbid'],
						$result['code'],
						$result['pilotid'],
						$request->input('sessionid'),
						$result['firstname'],
						$result['lastname'],
						$result['ranklevel'],
						$result['rankstring'],
					]);
				}
			}
		}
		return "AUTH_FAILED";
	}

	private function handleAutomaticLogin($request)
	{
		$this->smartCARSService->clearOldSessions();
		$session = SmartCARS_Session::where('pilot_id', '=', $request->input('dbid'))->where('sessionid', '=', $request->input('oldsessionid'))->first();
		if ($session){
			$pilot = Pilot::find($session->pilot_id);
			if ($pilot){
				$ret = [
					'dbid' 				=> $pilot->id,
					'code' 				=> $pilot->airline->prefix,
					'pilotid' 		=> str_replace($pilot->airline->prefix, '', $pilot->username),
					'firstname' 	=> $pilot->user->first_name,
					'lastname' 		=> $pilot->user->last_name,
					'email' 			=> $pilot->user->email,
					'ranklevel' 	=> $pilot->rank->level,
					'rankstring' 	=> $pilot->rank->name,
				];
				$this->smartCARSService->writeSessionId($pilot->id, $request->input('sessionid'));
				$result = $this->smartCARSService->sanitizeResult($ret);
				if ($request->input('new') == 'true') {
					return implode(",", [
						$result['dbid'],
						$result['code'],
						$result['pilotid'],
						$request->input('sessionid'),
						$result['firstname'],
						$result['lastname'],
						$result['email'],
						$result['ranklevel'],
						$result['rankstring'],
					]);
				}

				return implode(",", [
					$result['dbid'],
					$result['code'],
					$result['pilotid'],
					$request->input('sessionid'),
					$result['firstname'],
					$result['lastname'],
					$result['ranklevel'],
					$result['rankstring'],
				]);
			}
		}
		return "AUTH_FAILED";
	}

	private function handleVerifySession($request)
	{
		$session = SmartCARS_Session::where('pilot_id', '=', $request->input('dbid'))->where('sessionid', '=', $request->input('sessionid'))->first();
		if ($session) {
			$ret    = [
				'firstname' => $session->pilot->user->first_name,
				'lastname'  => $session->pilot->user->last_name,
			];
			$result = $this->smartCARSService->sanitizeResult($ret);
			return implode(",", [
				$request->input('sessionid'),
				$result['firstname'],
				$result['lastname'],
			]);
		}
		return "AUTH_FAILED";
	}

	private function handlePilotCentreData($request)
	{
		$pilot = Pilot::find($request->input('dbid'));
		$pireps = $pilot->pireps;

		$pirepCount = 0;
		$totalHours = 0;
		$landingRates = [];

		foreach ($pireps as $pirep){
			$pirepCount++;

			// Calculate Total Hours
			$flightTime = new Period($pirep->departure_time, $pirep->landing_time);
			$totalHours += $flightTime->getDuration(true);

			// Calculate Average Landing Rate
			$landingRates[] = $pirep->landing_rate;
		}

		$ret = [
			"totalhours" => round($totalHours / 3600, 2),
			"totalflights" => $pirepCount,
			"averagelandingrate" => (count($landingRates) > 0)? round(array_sum($landingRates) / count($landingRates)) : "N/A",
			"totalpireps" => $pirepCount,
		];
		$result = $this->smartCARSService->sanitizeResult($ret);
		return implode(",", [
			$result['totalhours'],
			$result['totalflights'],
			$result['averagelandingrate'],
			$result['totalpireps'],
		]);
	}

	private function handleAirports($request)
	{
		$pilot = Pilot::find($request->input('dbid'));
		$airports = $pilot->airline->airports;

		// This was quite complex, so the original code has been preserved somewhat.

		$format = [];
		$format['id'] = 'id';
		$format['icao'] = 'icao';
		$format['name'] = 'name';
		$format['latitude'] = 'latitude';
		$format['longitude'] = 'longitude';
		$format['country'] = 'country';

		$airportsList = [];
		foreach ($airports as $airport) {
			$airportsList[] = [
				'id'        => $airport->id,
				'icao'      => $airport->icao,
				'name'      => $airport->name,
				'latitude'  => $airport->latitude,
				'longitude' => $airport->longitude,
				'country'   => $airport->region->country->code,
			];
		}

		$return = '';
		$runcount = 0;
		foreach($airportsList as $apt) {
			if($runcount != 0)
				echo(";");
			$apt = str_replace(";","",$apt);
			$apt = str_replace("|","",$apt);
			$return .= ($apt[$format['id']] . "|" . strtoupper($apt[$format['icao']]) . "|" . $apt[$format['name']] . "|" . $apt[$format['latitude']] . "|" . $apt[$format['longitude']] . "|" . $apt[$format['country']]);
			$runcount++;
		}

		return $return;
	}

	private function handleAircraft($request)
	{
		$pilot = Pilot::find($request->input('dbid'));
		$aircraft = $pilot->airline->aircraft;

		// This was quite complex, so the original code has been preserved somewhat.

		$format = [];
		$format['id'] = 'id';
		$format['fullname'] = 'fullname';
		$format['icao'] = 'icao';
		$format['registration'] = 'registration';
		$format['maxpassengers'] = 'maxpassengers';
		$format['maxcargo'] = 'maxcargo';
		$format['requiredranklevel'] = 'requiredranklevel';

		$aircraftList = [];
		foreach ($aircraft as $singleAircraft) {
			$aircraftList[] = [
				'id' => $singleAircraft->id,
				'fullname' => $singleAircraft->type.' '.$singleAircraft->registration,
				'icao' => $singleAircraft->type,
				'registration' => $singleAircraft->registration,
				'maxpassengers' => $singleAircraft->passengers,
				'maxcargo' => $singleAircraft->cargo,
				'requiredranklevel' => $singleAircraft->rank->level,
			];
		}

		$return = '';
		$runcount = 0;
		foreach($aircraftList as $ac) {
			if ($runcount != 0)
				echo(";");
			$ac = str_replace(";", "", $ac);
			$ac = str_replace(",", "", $ac);
			$return .= ($ac[$format['id']] . "," . $ac[$format['fullname']] . "," . $ac[$format['icao']] . "," . $ac[$format['registration']] . "," . $ac[$format['maxpassengers']] . "," . $ac[$format['maxcargo']] . "," . $ac[$format['requiredranklevel']]);
			$runcount++;
		}

		return $return;
	}

	private function handleBidFlights($request)
	{
		$pilot = Pilot::find($request->input('dbid'));

		$format = [];
		$format['bidid'] = 'bidid';
		$format['routeid'] = 'routeid';
		$format['code'] = 'code';
		$format['flightnumber'] = 'flightnumber';
		$format['type'] = 'type';
		$format['departureicao'] = 'departureicao';
		$format['arrivalicao'] = 'arrivalicao';
		$format['route'] = 'route';
		$format['cruisingaltitude'] = 'cruisingaltitude';
		$format['aircraft'] = 'aircraft';
		$format['duration'] = 'duration';
		$format['departuretime'] = 'departuretime';
		$format['arrivaltime'] = 'arrivaltime';
		$format['load'] = 'load';
		$format['daysofweek'] = 'daysofweek';

		if (count($pilot->bookings) == 0)
			return "NONE";

		foreach($pilot->bookings as $booking){
			$bookedFlights[] = [
				"bidid" => $booking->id,
				"routeid" => $booking->route->id,
				"code" => "", // todo wtf is this
				"flightnumber" => "RYR001", // todo implement flight numbers
				"type" => "CHTR",
				"departureicao" => $booking->route->departureAirport->icao,
				"arrivalicao" => $booking->route->arrivalAirport->icao,
				"route" => $booking->route->route,
				"cruisingaltitude" => "", // todo implement cruising alt
				"aircraft" => $booking->aircraft->icao,
				"duration" => "", // todo wtf
				"departuretime" => "", // todo wtf
				"arrivaltime" => "", // todo wtf
				"load" => '',
				"daysofweek" => '',
			];
		}

		$return = '';
		$runcount = 0;
		foreach($bookedFlights as $schedule) {
			if ($runcount != 0)
				echo(";");
			$schedule = str_replace(";", "", $schedule);
			$schedule = str_replace(",", "", $schedule);
			$return .= ($schedule[$format['bidid']] . "|" . $schedule[$format['routeid']] . "|" . $schedule[$format['code']] . "|" . $schedule[$format['flightnumber']] . "|" . $schedule[$format['departureicao']] . "|" . $schedule[$format['arrivalicao']] . "|" . $schedule[$format['route']] . "|" . $schedule[$format['cruisingaltitude']] . "|" . $schedule[$format['aircraft']] . "|" . $schedule[$format['duration']] . "|" . $schedule[$format['departuretime']] . "|" . $schedule[$format['arrivaltime']] . "|" . $schedule[$format['load']] . "|" . $schedule[$format['type']] . "|" . $schedule[$format['daysofweek']]);
			$runcount++;
		}

		return $return;

	}
}
