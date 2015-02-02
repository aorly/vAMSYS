<?php
/*
 * TFDi Design smartCARS Web Interface

 * Version: w3+
 * Server requirements: PHP Data Objects (PDO)

 * This interface script is provided by TFDi Design for the purposes of creating a web-interface between the smartCARS Virtual Flight Tracking Software and virtual airline databases.
 * This interface script is originally property of TFDi Design.

 * This file is originally governed by the TFDi Design smartCARS Virtual Airline Operations License, http://tfdidesign.com/smartcars/vaol.php, and the TFDi Design General License, http://tfdidesign.com/license.php

 * This file may be edited and redistributed by third party developers, but TFDi Design assumes no responsibility for support or maintenance on any modified scripts.
 * All third party developers who modify and/or redistribute this file should add their copyright information as well, but are prohibited from removing the original disclaimers.
 * Any third party developers who modify and/or redistribute this file must modify the version number to indicate that this is not an official distribution of the file.

 * If you are unsure if you are using an original, unmodified copy of the smartCARS web interface, we recommend obtaining new copies of the files from the TFDi Design website.
 */

 /* Interface Information for phpVMS
  *
  * General Information
  * -------------------
  * This file can be modified at will to adapt and customize the function of smartCARS to fit your website. Additional information is below to assist in understanding and customizing this file.
  *
  * How Does This System Work?
  * --------------------------
  * The file "frame.php" is the file that the smartCARS client will request. That file should never be modified - it verifies data, cleans output to avoid parse errors, and handles housekeeping and database connectivity for you.
  * This file has been split into static functions that return a formatted set of data to the frame. The frame then handles outputting it properly for the smartCARS client.
  * To customize this file, simply modify the functions. Remember that for functions that return arrays of data, such as the airport list, remember to match the format array to the table column names.
  *
  * Database ID (DBID) and Pilot ID Information
  * -------------------------------------------
  * The dbid is sent with every request, instead of pilotid - this is to account for systems where the pilot ID is adjustable.
  * For phpVMS, the dbid and pilotid will always be the same, and the PILOTID_OFFSET does not need to be applied to it, as it is the database index.
  * The PILOTID_OFFSET is only accounted for when providing the user their pilot ID, as it is what is shown. The code uses dbid, as does the web system usually.
  *
  * Security/Authentication Information
  * -----------------------------------
  * Functions that require logins/security before they can be accessed have already been accounted for by the frame - no need to authenticate requests here.
  */

/*
 * Adapted for vAMSYS by Paul Williams
 * paul@skenmy.com
 */

use vAMSYS\Pilot;

require_once __DIR__.'/../vendor/autoload.php';

$config = parse_ini_file(__DIR__.'/../.env');

if (!isset($_GET['action']))
	$_GET['action'] = null;
if (!isset($_GET['airlineICAO']))
	$_GET['airlineICAO'] = '';
if (!isset($_GET['userid']))
	$_GET['userid'] = 0;

$_GET['userid'] = $_GET['airlineICAO'].str_pad($_GET['userid'], 4, 0, STR_PAD_LEFT);
error_log($_GET['userid']);

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
		'driver'    => 'mysql',
		'host'      => $config['DB_HOST'],
		'database'  => $config['DB_DATABASE'],
		'username'  => $config['DB_USERNAME'],
		'password'  => $config['DB_PASSWORD'],
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
		'strict'    => false,
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

define('skip_retired_check', false); //should 'retired' (inactive) pilots be able to log in?
define('include_pending_flights_in_stats', false); //should flights that haven't been accepted/rejected yet be used to compute pilot stats in the smartCARS client?
define('interface_version', 'phpvms-official-w3010-12/21/2014');

class smartCARS {

	static function getdbcredentials() {
		$config = parse_ini_file(__DIR__.'/../.env');
		$ret = array();
		$ret['user'] = $config['DB_USERNAME'];
		$ret['pass'] = $config['DB_PASSWORD'];
		$ret['name'] = $config['DB_DATABASE'];
		$ret['server'] = $config['DB_HOST'];
		return $ret;
	}

	static function manuallogin($userid, $password, $sessionid) {
		// Initially implemented 30/01/15 ~PW
		$ret = [];

		if (!filter_var($userid, FILTER_VALIDATE_EMAIL)){
			// It's not an email address - try and find the user from our Pilots!
			if ($pilot = Pilot::where('username', '=', $userid)->first()){
				if (password_verify($password, $pilot->user->password)){
					// Success!
					// todo check inactivity
					$ret = [
						'dbid' 				=> $pilot->id,
						'code' 				=> $pilot->airline->prefix,
						'pilotid' 		=> str_replace($pilot->airline->prefix, '', $pilot->username),
						'firstname' 	=> $pilot->user->first_name,
						'lastname' 		=> $pilot->user->last_name,
						'email' 			=> $pilot->user->email,
						'ranklevel' 	=> 1, // todo implement ranks
						'rankstring' 	=> 'Pilot', // todo implement ranks
						'result'			=> 'ok'
					];
					return $ret;
				}
			}
		}

		$ret['result'] = "failed";
		return $ret;
	}

	static function automaticlogin($dbid, $oldsessionid, $sessionid) {
		// Initially implemented 30/01/15 ~PW
		global $dbConnection;

		$ret = [];

		$stmt = $dbConnection->prepare("SELECT * FROM smartCARS_sessions WHERE dbid = ? AND sessionid = ?");
		$stmt->execute(array(
			$dbid,
			$oldsessionid
		));
		$res1 = $stmt->fetch();
		$stmt->closeCursor();

		if($res1['dbid'] != "") {
			$pilot = Pilot::find($res1['dbid']);
			if ($pilot) {
				$ret = [
					'dbid' 				=> $pilot->id,
					'code' 				=> $pilot->airline->prefix,
					'pilotid' 		=> str_replace($pilot->airline->prefix, '', $pilot->username),
					'firstname' 	=> $pilot->user->first_name,
					'lastname' 		=> $pilot->user->last_name,
					'email' 			=> $pilot->user->email,
					'ranklevel' 	=> 1, // todo implement ranks
					'rankstring' 	=> 'Pilot', // todo implement ranks
					'result'			=> 'ok'
				];
				return $ret;
			}
		}

		$ret['result'] = "failed";
		return $ret;
	}

	static function verifysession($dbid, $sessionid) {
		// Initially implemented 30/01/15 ~PW
		$ret = array();

		global $dbConnection;
		$stmt = $dbConnection->prepare("SELECT * FROM smartCARS_sessions WHERE dbid = ? AND sessionid = ?");
		$stmt->execute(array(
			$dbid,
			$sessionid
		));
		$res1 = $stmt->fetch();
		$stmt->closeCursor();
		if($res1['dbid'] != "") {
			$pilot = Pilot::find($res1['dbid']);
			if ($pilot) {
				$ret = [
					'firstname' => $pilot->user->first_name,
					'lastname'  => $pilot->user->last_name,
					'result'    => 'SUCCESS'
				];
				return $ret;
			}
		}

		$ret['result'] = "FAILED";
		return $ret;
	}

	static function getpilotcenterdata($dbid) {
		// todo implement pilot centre data
		global $dbConnection;
		$ret = array();
		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "pilots WHERE pilotid = ?");
		$stmt->execute(array($dbid));
		$res = $stmt->fetch();
		$stmt->closeCursor();
		$ret = array();
		if($res['pilotid'] != "") {
			$ret['totalhours'] = $res['totalhours'];
			$ret['totalflights'] = $res['totalflights'];
			if($res['totalflights'] > 0) {
				$stmt = $dbConnection->prepare("SELECT landingrate FROM " . TABLE_PREFIX . "pireps WHERE pilotid = ?" . (include_pending_flights_in_stats == false ? "AND accepted = 1" : "AND accepted != 2") . " ORDER BY submitdate");
				$stmt->execute(array($dbid));
				$pireps = $stmt->fetchAll();
				$stmt->closeCursor();
				$total_landing = 0;
				$sizeofpireps = sizeof($pireps);
				foreach($pireps as $pirep) {
					$total_landing += $pirep['landingrate'];
				}
				if($sizeofpireps > 0)
					$ret['averagelandingrate'] = round($total_landing / $sizeofpireps);
				else
					$ret['averagelandingrate'] = "0";
				$ret['totalpireps'] = $sizeofpireps;
			}
			else {
				$ret['averagelandingrate'] = "N/A";
				$ret['totalpireps'] = "0";
			}
		}
		return $ret;
	}

	static function getairports($dbid) {
		// Initially implemented 30/01/15 ~PW
		$pilot = Pilot::find($dbid);
		$airports = $pilot->airline->airports;
		$airportsList = [];
		foreach ($airports as $airport){
			$airportsList[] = [
				'id' => $airport->id,
				'icao' => $airport->icao,
				'name' => $airport->name,
				'latitude' => $airport->latitude,
				'longitude' => $airport->longitude,
				'country' => $airport->region->country->name,
			];
		}

		$ret['airports'] = $airportsList;
		$ret['format'] = array();
		$ret['format']['id'] = 'id';
		$ret['format']['icao'] = 'icao';
		$ret['format']['name'] = 'name';
		$ret['format']['latitude'] = 'latitude';
		$ret['format']['longitude'] = 'longitude';
		$ret['format']['country'] = 'country';
		return $ret;
	}

	static function getaircraft($dbid) {
		// Initially implemented 30/01/15 ~PW
		$pilot = Pilot::find($dbid);
		$aircraft = $pilot->airline->aircraft;
		$aircraftList = [];
		foreach ($aircraft as $singleAircraft){
			$aircraftList[] = [
				'id' => $singleAircraft->id,
				'fullname' => $singleAircraft->type.' '.$singleAircraft->registration,
				'icao' => $singleAircraft->type,
				'registration' => $singleAircraft->registration,
				'maxpassengers' => 300, // todo implement max passengers
				'maxcargo' => 10000, // todo implement max cargo
				'requiredranklevel' => 1, // todo implement required rank
			];
		}

		$res['aircraft'] = $aircraftList;
		$res['format'] = array();
		$res['format']['id'] = 'id';
		$res['format']['fullname'] = 'fullname';
		$res['format']['icao'] = 'icao';
		$res['format']['registration'] = 'registration';
		$res['format']['maxpassengers'] = 'maxpassengers';
		$res['format']['maxcargo'] = 'maxcargo';
		$res['format']['requiredranklevel'] = 'requiredranklevel';
		return $res;
	}

	static function getbidflights($dbid) {
		global $dbConnection;
		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "bids WHERE pilotid = ?");
		$stmt->execute(array($dbid));
		$bids = $stmt->fetchAll();
		$stmt->closeCursor();
		$ret = array();
		$ret['format'] = array();
		$ret['format']['bidid'] = 'bidid';
		$ret['format']['routeid'] = 'id';
		$ret['format']['code'] = 'code';
		$ret['format']['flightnumber'] = 'flightnum';
		$ret['format']['type'] = 'flighttype';
		$ret['format']['departureicao'] = 'depicao';
		$ret['format']['arrivalicao'] = 'arricao';
		$ret['format']['route'] = 'route';
		$ret['format']['cruisingaltitude'] = 'flightlevel';
		$ret['format']['aircraft'] = 'aircraft';
		$ret['format']['duration'] = 'flighttime';
		$ret['format']['departuretime'] = 'deptime';
		$ret['format']['arrivaltime'] = 'arrtime';
		$ret['format']['load'] = 'load';
		$ret['format']['type'] = 'flighttype';
		$ret['format']['daysofweek'] = 'daysofweek';
		$ret['schedules'] = array();
		foreach($bids as $bid) {
			$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "schedules WHERE id = ?");
			$stmt->execute(array($bid['routeid']));
			$schedule = $stmt->fetch();
			$stmt->closeCursor();

			if($schedule['id'] != "") {
				$schedule['bidid'] = $bid['bidid'];
				//How the 'load' value works:
				//You can give a number that will be used as the passenger or cargo number in the client and it will not be editable by the user.
				//You can specify LOAD_TYPE_RANDOM_LOCKED that will generate a random number on the client side but will not allow editing.
				//You can specify LOAD_TYPE_RANDOM_EDITABLE that will function like smartCARS 1.X - generate a random number and allow the user to change it.
				$continue = false;
				if($schedule['enabled'] != "0")
					$continue = true;
				else {
					$stmt = $dbConnection->prepare("SELECT * FROM smartCARS_charteredflights WHERE routeid = ? AND dbid = ?");
					$stmt->execute(array($bid['routeid'], $dbid));
					$cschedule = $stmt->fetch();
					$stmt->closeCursor();
					if($cschedule['routeid'] != "")
						$continue = true;
				}

				$schedule['load'] = LOAD_TYPE_RANDOM_EDITABLE;
				array_push($ret['schedules'],$schedule);
			}
		}
		return $ret;
	}

	static function bidonflight($dbid, $routeid) {
		global $dbConnection;
		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "schedules WHERE id = ? AND enabled != 0");
		$stmt->execute(array($routeid));
		$schedule = $stmt->fetch();
		$stmt->closeCursor();
		if($schedule['id'] != "") {
			if(DISABLE_BIDS_ON_BID == true) {
				$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "bids WHERE routeid = ?");
				$stmt->execute(array($routeid));
				$bid = $stmt->fetch();
				$stmt->closeCursor();
				if($bid['bidid'] != "")
					return 1;
			}
			$stmt = $dbConnection->prepare("INSERT INTO " . TABLE_PREFIX . "bids (pilotid, routeid, dateadded) VALUES (?, ?, NOW())");
			$stmt->execute(array($dbid, $routeid));
			$stmt->closeCursor();
			return 0;
		}
		return 2;
	}

	static function deletebidflight($dbid, $bidid) {
		global $dbConnection;
		$stmt = $dbConnection->prepare("DELETE FROM " . TABLE_PREFIX . "bids WHERE bidid = ? LIMIT 1");
		$stmt->execute(array($bidid));
		$stmt->closeCursor();

		$stmt = $dbConnection->prepare("SELECT * FROM smartCARS_charteredflights WHERE bidid = ? AND dbid = ?");
		$stmt->execute(array($bidid, $dbid));
		$crow = $stmt->fetch();
		$stmt->closeCursor();
		if($crow['routeid'] != "") {
			$stmt = $dbConnection->prepare("DELETE FROM smartCARS_charteredflights WHERE bidid = ? AND dbid = ?");
			$stmt->execute(array($bidid, $dbid));
			$stmt->closeCursor();

			$stmt = $dbConnection->prepare("DELETE FROM " . TABLE_PREFIX . "schedules WHERE id = ?");
			$stmt->execute(array($crow['routeid']));
			$stmt->closeCursor();
		}
	}

	static function _helper_reorder_date_to_mmddyyyy($source) {
		$source = substr($source, 0, 10);
		$yyyymmdd = explode("-", $source);
		$mmddyyyy = $yyyymmdd[1] . "/" . $yyyymmdd[2] . "/" . $yyyymmdd[0];
		return $mmddyyyy;
	}

	static function searchpireps($dbid, $departureicao, $arrivalicao, $startdate, $enddate, $aircraft, $status) {
		global $dbConnection;
		$param = "SELECT pirepid, code, submitdate, flightnum, depicao, arricao, aircraft FROM " . TABLE_PREFIX . "pireps WHERE pilotid = :pilotid";
		$arg = array();
		$arg[':pilotid'] = $dbid;
		if($departureicao != "" || $arrivalicao != "" || $startdate != "" || $enddate != "") {
			if ($departureicao != "" && $arrivalicao == "") {
                $param = $param . " AND depicao = :departure";
                $arg[':departure'] = $departureicao;
            }
            else if ($arrivalicao != "" && $departureicao == "") {
                $param = $param . " AND arricao = :arrival";
                $arg[':arrival'] = $arrivalicao;
            }
            else if ($arrivalicao != "" && $departureicao != "") {
                $arg[':departure'] = $departureicao;
                $arg[':arrival'] = $arrivalicao;
                $param = $param . " AND depicao = :departure AND arricao = :arrival";
            }

			if ($startdate != "") {
                $param = $param . " AND submitdate >= :date1";
                $arg[':date1'] = $startdate;
            }
            if ($enddate != "") {
                $param = $param . " AND submitdate <= :date2";
                $arg[':date2'] = $enddate;
            }
		}

		if($status != "" && ($status == "1" || $status == "2" || $status == "3")) {
			$param .= " AND accepted = :status";
			if($status == "1") //accepted
				$arg[':status'] = $status;
			else if($status == "2") //pending
				$arg[':status'] = "0";
			else if($status == "3") //rejected
				$arg[':status'] = "2";
		}

		$use_ac = false;
        $valid_aircraft = array();
        if($aircraft != "") {
            $stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "aircraft WHERE fullname = ?");
            $stmt->execute(array($aircraft));
			$acdatar = $stmt->fetchAll();
			$stmt->closeCursor();
			if(sizeof($acdatar) > 0) {
				$use_ac = true;
				foreach($acdatar as $row) {
					array_push($valid_aircraft, $row['id']);
	            }
			}
        }

		if($use_ac == true) {
			$first = true;
			$acc = 0;
			foreach($valid_aircraft as $ac) {
				if($first == true) {
					$param .= " AND aircraft = :ac" . $acc;
					$arg[':ac' . $acc] = $ac;
					$acc++;
				}
				else {
					$param .= " OR aircraft = :ac" . $acc;
					$arg[':ac' . $acc] = $ac;
					$acc++;
				}
				$first = false;
			}
		}

		$stmt = $dbConnection->prepare($param);
        $stmt->execute($arg);
        $pireps = $stmt->fetchAll();
        $stmt->closeCursor();

		$ret = array();
		$ret['format'] = array();
		$ret['pireps'] = array();
		$ret['format']['pirepid'] = "pirepid";
		$ret['format']['code'] = "code";
		$ret['format']['flightnumber'] = "flightnum";
		$ret['format']['departureicao'] = "depicao";
		$ret['format']['date'] = "submitdate";
		$ret['format']['arrivalicao'] = "arricao";
		$ret['format']['arrivalicao'] = "arricao";
		$ret['format']['aircraft'] = "aircraft";
		foreach($pireps as $key => $pirep) {
			$pireps[$key]['submitdate'] = smartCARS::_helper_reorder_date_to_mmddyyyy($pirep['submitdate']);
		}
		$ret['pireps'] = $pireps;
		return $ret;

	}

	static function getpirepdata($dbid, $pirepid) {
		global $dbConnection;
		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "pireps WHERE pirepid = ?");
		$stmt->execute(array($pirepid));
		$res = $stmt->fetch();
		$stmt->closeCursor();

		$ret = array();
		$ret['duration'] = $res['flighttime'];
		$ret['landingrate'] = $res['landingrate'];
		$ret['fuelused'] = $res['fuelused'];
		$status = "0";
		if($res['accepted'] == "1")
			$status = "1";
		else if($res['accepted'] == "2")
			$status = "2";
		$ret['status'] = $status;
		$ret['log'] = $res['log'];

		return $ret;
	}

	static function searchflights($dbid, $departureicao, $mintime, $maxtime, $arrivalicao, $aircraft) {
		global $dbConnection;
        if ($departureicao != "" || $arrivalicao != "" || $mintime != "" || $maxtime != "") {
            $param = "SELECT * FROM " . TABLE_PREFIX . "schedules";
            $arg = array();
            if ($departureicao != "" && $arrivalicao == "") {
                $param = $param . " WHERE depicao = :departure";
                $arg[':departure'] = $departureicao;
            }
            else if ($arrivalicao != "" && $departureicao == "") {
                $param = $param . " WHERE arricao = :arrival";
                $arg[':arrival'] = $arrivalicao;
            }
            else if ($arrivalicao != "" && $departureicao != "") {
                $arg[':departure'] = $departureicao;
                $arg[':arrival'] = $arrivalicao;
                $param = $param . " WHERE depicao = :departure AND arricao = :arrival";
            }
            else
                $param = $param . " WHERE";
            if ($mintime != "") {
                if ($departureicao != "" || $arrivalicao != "")
                    $param = $param . " AND";
                $param = $param . " flighttime >= :time1";
                $arg[':time1'] = $mintime;
            }
            if ($maxtime != "") {
                if ($mintime != "" || $departureicao != "" || $arrivalicao != "")
                    $param = $param . " AND";
                $param = $param . " flighttime >= :time2";
                $arg[':time2'] = $maxtime;
            }
			$param .= " AND enabled != 0";
        }
        else
            $param = "SELECT * FROM " . TABLE_PREFIX . "schedules WHERE enabled != 0";
		$use_ac = false;
        $valid_aircraft = array();
        if($aircraft != "") {
            $stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "aircraft WHERE fullname = ?");
            $stmt->execute(array($aircraft));
			$acdatar = $stmt->fetchAll();
			$stmt->closeCursor();
			if(sizeof($acdatar) > 0) {
				$use_ac = true;
				foreach($acdatar as $row) {
					array_push($valid_aircraft, $row['id']);
	            }
			}
        }

		if($use_ac == true) {
			$first = true;
			$acc = 0;
			foreach($valid_aircraft as $ac) {
				if($first == true) {
					$param .= " AND aircraft = :ac" . $acc;
					$arg[':ac' . $acc] = $ac;
					$acc++;
				}
				else {
					$param .= " OR aircraft = :ac" . $acc;
					$arg[':ac' . $acc] = $ac;
					$acc++;
				}
				$first = false;
			}
		}

		$param .= " ORDER BY code, flightnum LIMIT 1001";
        $stmt = $dbConnection->prepare($param);
        $stmt->execute($arg);
        $flights = $stmt->fetchAll();
        $stmt->closeCursor();

		$ret = array();
		$ret['format'] = array();
		$ret['format']['routeid'] = 'id';
		$ret['format']['code'] = 'code';
		$ret['format']['flightnumber'] = 'flightnum';
		$ret['format']['type'] = 'flighttype';
		$ret['format']['departureicao'] = 'depicao';
		$ret['format']['arrivalicao'] = 'arricao';
		$ret['format']['route'] = 'route';
		$ret['format']['cruisingaltitude'] = 'flightlevel';
		$ret['format']['aircraft'] = 'aircraft'; //make this more specific
		$ret['format']['flighttime'] = 'flighttime';
		$ret['format']['departuretime'] = 'deptime';
		$ret['format']['arrivaltime'] = 'arrtime';
		$ret['format']['daysofweek'] = 'daysofweek';
		$ret['schedules'] = $flights;
		return $ret;
	}

	static function createflight($dbid, $code, $flightnumber, $depicao, $arricao, $aircraft, $flighttype, $deptime, $arrtime, $flighttime, $route, $cruisealtitude, $distance) {
		global $dbConnection;

		$type = "P";
		if($flighttype == "1")
			$type = "C";

		$stmt = $dbConnection->prepare("INSERT INTO " . TABLE_PREFIX . "schedules (id, code, flightnum, depicao, arricao, route, aircraft, flightlevel, distance, deptime, arrtime, flighttime, flighttype, enabled) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
		$stmt->execute(array(
			$code,
			$flightnumber,
			$depicao,
			$arricao,
			$route,
			$aircraft,
			$cruisealtitude,
			$distance,
			$deptime,
			$arrtime,
			$flighttime,
			$type
		));
		$routeid = $dbConnection->lastInsertID();
		$stmt->closeCursor();

		$stmt = $dbConnection->prepare("INSERT INTO " . TABLE_PREFIX . "bids (bidid, pilotid, routeid, dateadded) VALUES (NULL, ?, ?, NOW())");
		$stmt->execute(array(
			$dbid,
			$routeid
		));
		$bidid = $dbConnection->lastInsertID();
		$stmt->closeCursor();

		$stmt = $dbConnection->prepare("INSERT INTO smartCARS_charteredflights (routeid, dbid, bidid) VALUES (?, ?, ?)");
		$stmt->execute(array(
			$routeid,
			$dbid,
			$bidid
		));
		$stmt->closeCursor();

		return true;
	}

	static function positionreport($dbid, $flightnumber, $latitude, $longitude, $magneticheading, $trueheading, $altitude, $groundspeed, $departureicao, $arrivalicao, $phase, $arrivaltime, $departuretime, $distanceremaining, $route, $timeremaining, $aircraft, $onlinenetwork) {
		global $dbConnection;
		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "airports WHERE icao = ?");
		$stmt->execute(array($departureicao));
		$depaptdet = $stmt->fetch();
		$stmt->closeCursor();

		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "airports WHERE icao = ?");
		$stmt->execute(array($arrivalicao));
		$arraptdet = $stmt->fetch();
		$stmt->closeCursor();

		$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "pilots WHERE pilotid = ?");
		$stmt->execute(array($dbid));
		$pilotdet = $stmt->fetch();
		$stmt->closeCursor();

		if($depaptdet['id'] != "" && $arraptdet != "" && $pilotdet['pilotid'] != "") {
            $latitude = str_replace("|", "-", $latitude);
			$latitude = str_replace(",", ".", $latitude);
            $longitude = str_replace("|", "-", $longitude);
			$longitude = str_replace(",", ".", $longitude);

			$phases = array(
				"Preflight",
				"Pushing Back",
				"Taxiing to Runway",
				"Taking Off",
				"Climbing",
				"Cruising",
				"Descending",
				"Approaching",
				"Final Approach",
				"Landing",
				"Taxiing to Gate",
				"Arrived"
			);

			$route = str_replace("?", " ", $route);
			$pseudo_sch_obj = new ArrayObject(array());
            $pseudo_sch_obj->deplat = $depaptdet['lat'];
            $pseudo_sch_obj->deplng = $depaptdet['lng'];
            $pseudo_sch_obj->route = $route;
            $route_details = serialize(NavData::parseRoute($pseudo_sch_obj));

			$stmt = $dbConnection->prepare("SELECT * FROM " . TABLE_PREFIX . "acarsdata WHERE pilotid = ?");
			$stmt->execute(array($dbid));
			$row = $stmt->fetch();
			$stmt->closeCursor();
			$id = ($row['id'] != "" ? $row['id'] : "NULL");

            $stmt = $dbConnection->prepare("REPLACE INTO " . TABLE_PREFIX . "acarsdata (id, pilotid, flightnum, pilotname, aircraft, lat, lng, heading, alt, gs, depicao, depapt, arricao, arrapt, deptime, timeremaining, arrtime, route, route_details, distremain, phasedetail, online, lastupdate, client) VALUES (" . $id . ", ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , CURRENT_TIMESTAMP , 'smartCARS')");
            $stmt->execute(array(
				$dbid,
				$flightnumber,
				$pilotdet['firstname'] . " " . $pilotdet['lastname'],
				$aircraft,
				$latitude,
				$longitude,
				$trueheading,
				$altitude,
				$groundspeed,
				$departureicao,
				$depaptdet['name'],
				$arrivalicao,
				$arraptdet['name'],
				$departuretime,
				$timeremaining,
				$arrivaltime,
				$route,
				$route_details,
				$distanceremaining,
				$phases[$phase],
				$onlinenetwork
			));
			$stmt->closeCursor();
			return true;
		}
		else
			return false;
	}
	static function filepirep($dbid, $code, $flightnumber, $routeid, $bidid, $departureicao, $arrivalicao, $route, $aircraft, $load, $flighttime, $landingrate, $comments, $fuelused, $log) {
		global $dbConnection;
		$log = str_replace('[', '*[', $log);
		$log = str_replace('\\r', '', $log);
		$log = str_replace('\\n', '', $log);
		$pirepdata = array(
            'pilotid' => $dbid,
            'code' => $code,
            'flightnum' => $flightnumber,
            'depicao' => $departureicao,
            'arricao' => $arrivalicao,
            'route' => $route,
            'aircraft' => $aircraft,
            'load' => $load,
            'flighttime' => $flighttime,
            'landingrate' => $landingrate,
            'submitdate' => date('Y-m-d H:i:s'),
            'comment' => $comments,
            'fuelused' => $fuelused,
            'source' => 'smartCARS',
            'log' => $log
        );

		$ret = PIREPData::FileReport($pirepdata);

		$stmt = $dbConnection->prepare("DELETE FROM " . TABLE_PREFIX . "acarsdata WHERE pilotid = ?");
		$stmt->execute(array($dbid));

        if(!$ret)
            return false;

		$stmt = $dbConnection->prepare("SELECT * FROM smartCARS_charteredflights WHERE bidid = ? AND dbid = ?");
		$stmt->execute(array($bidid, $dbid));
		$crow = $stmt->fetch();
		$stmt->closeCursor();
		if($crow['routeid'] != "") {
			$stmt = $dbConnection->prepare("DELETE FROM smartCARS_charteredflights WHERE bidid = ? AND dbid = ?");
			$stmt->execute(array($bidid, $dbid));
			$stmt->closeCursor();

			$stmt = $dbConnection->prepare("DELETE FROM " . TABLE_PREFIX . "schedules WHERE id = ?");
			$stmt->execute(array($crow['routeid']));
			$stmt->closeCursor();
		}

		$stmt = $dbConnection->prepare("UPDATE " . TABLE_PREFIX . "pilots SET retired = 0 WHERE pilotid = ?");
		$stmt->execute(array($dbid));

		$stmt = $dbConnection->prepare("DELETE FROM " . TABLE_PREFIX . "bids WHERE pilotid = ? AND bidid = ?");
		$stmt->execute(array($dbid, $bidid));
		return true;
	}
}
