<?php

namespace vAMSYS\Repositories;

use Illuminate\Support\Facades\Config;
use Neoxygen\NeoClient\ClientBuilder;

class AirwaysRepository {
  private static function buildConnection()
  {
    return ClientBuilder::create()
      ->addConnection('default',Config::get('database.neo4j.profiles.default.scheme'),Config::get('database.neo4j.profiles.default.host'),Config::get('database.neo4j.profiles.default.port'))
      ->setAutoFormatResponse(true)
      ->build();
  }

  public static function getPoint($point)
  {
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
}