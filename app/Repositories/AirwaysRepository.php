<?php

namespace vAMSYS\Repositories;

use Illuminate\Support\Facades\Config;
use Neoxygen\NeoClient\ClientBuilder;

class AirwaysRepository {
  public static $coordinateregex = '/((\d{1,3})(N|S))((\d{1,3})(E|W))/';

  private static function buildConnection()
  {
    return ClientBuilder::create()
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

  public static function getPoint($point)
  {
    // Is this a coordinate?
    if (preg_match(self::$coordinateregex, $point)){
      // Return a fake object!
      $return = self::convertDMStoLatLon($point);
      $return['name'] = $point;
      return (object)$return;
    }

    $client = self::buildConnection();
    $query = "MATCH (n:Waypoint1501 { name:{point} }) RETURN n";
    $parameters = [
      "point"    => $point,
    ];
    $response = $client->sendCypherQuery($query, $parameters);
    return (object)$response->getRows()['n'][0];
  }

  public static function getPoints($airway, $start, $finish)
  {
    $client = self::buildConnection();
    $query = "MATCH p=allShortestPaths((n:Waypoint1501 { name:{from} })-[*]->(n2:Waypoint1501 { name:{to} }))
              WHERE ALL (r IN rels(p) WHERE type(r)={airway})
              RETURN nodes(p) AS waypoints";

    $parameters = [
      "from"    => $start,
      "to"      => $finish,
      "airway"  => $airway,
      "airac"   => "Waypoint1501" // TODO: Change this for airline setting
    ];

    $response = $client->sendCypherQuery($query, $parameters);

    $waypoints = [];

    if (isset($response->getRows()['waypoints'])) {
      foreach ($response->getRows()['waypoints'][0] as $waypoint) {
        $waypoints[] = (object)[
          "name"      => $waypoint['name'],
          "latitude"  => $waypoint['latitude'],
          "longitude" => $waypoint['longitude'],
        ];
      }
    }

    return $waypoints;
  }

  public static function convertDMStoLatLon($dms)
  {
    preg_match(self::$coordinateregex, $dms, $matches);
    if ($matches[3] == 'N'){
      $latitude = $matches[2];
    } else {
      $latitude = $matches[2] * -1;
    }

    if ($matches[6] == 'E'){
      $longitude = $matches[5];
    } else {
      $longitude = $matches[5] * -1;
    }

    return ["latitude" => $latitude, "longitude" => $longitude];
  }
}