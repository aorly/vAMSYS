@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Book Flight <small>look at all the places you could visit!</small>
        </h3>
        <div class="row">
            <div class="col-md-6">
                <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-arrow"></i>Available Destinations from {{$currentLocation->name}}
                    </div>
                </div>
                <div class="portlet-body">
                    @if($pilot->location->id != $currentLocation->id)
                        <div class="alert alert-info">
                            <div class="text-center"><strong>Important:</strong> You are booking a flight from your final planned destination, {{$currentLocation->name}}</div>
                        </div>
                    @endif
                        <div id="destinations_tree" class="tree-demo">
                            <ul>
                                @foreach ($sortedRoutes as $continentCode => $countries)
                                <li data-jstree='{ "icon" : "fa fa-globe" @if (count($sortedRoutes)==1), "opened": true @endif }'>{{$continentCode}}
                                    <ul>
                                        @foreach ($countries as $countryName => $regions)
                                        <li data-jstree='{ "icon" : "fa fa-cloud" @if (count($countries)==1), "opened": true @endif }'>{{$countryName}}
                                            <ul>
                                                @foreach ($regions as $regionName => $airports)
                                                <li data-jstree='{ "icon" : "fa fa-flag" @if (count($regions)==1), "opened": true @endif }'>{{$regionName}}
                                                    <ul>
                                                        @foreach ($airports as $airport)
                                                            <li data-jstree='{ "icon" : "fa fa-plane" }'><a href="javascript:showFlight('{{$airport->icao}}');">{{$airport->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet box blue-chambray">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Map
                        </div>
                    </div>
                    <div class="portlet-body text-center">
                        <div id="gmap_flight_path" class="gmaps">
                        </div>
                                <div><br /><a href="#" id="bookButton" class="btn btn-lg default disabled">
                                    Choose a Destination...</i>
                                </a></div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('pagejs')
<script type="text/javascript">
    var flightPaths = {};
    var airports = {};
    var map;

    var mapPolylines = function () {
        map = new GMaps({
            div: '#gmap_flight_path',
            lat: 49.617828,
            lng: 3.7874943,
            zoom: 3,
            click: function (e) {
                console.log(e);
            }
        });

        airports = {@foreach ($availableRoutes as $index => $route)"{{$route->arrivalAirport->icao}}":{
                "id": {{$route->arrivalAirport->id}},
                "routeId": {{$route->id}},
                "name": "{{$route->arrivalAirport->name}}",
                "latitude": {{$route->arrivalAirport->latitude}},
                "longitude": {{$route->arrivalAirport->longitude}}
            }@if ($index+1 != count($availableRoutes)),@endif
            @endforeach
        };

        var departureLatlng = new google.maps.LatLng({{$currentLocation->latitude}},{{$currentLocation->longitude}});
        var departure = new google.maps.Marker({
            position: departureLatlng,
            animation: google.maps.Animation.DROP,
            title: '{{$currentLocation->name}} ({{$currentLocation->icao}})'
        });
        map.addMarker(departure);

        var bounds = new google.maps.LatLngBounds();
        bounds.extend(departureLatlng);

        $.each(airports, function(icao, airport) {
            var airportLocation = new google.maps.LatLng(airport.latitude, airport.longitude);
            var airportMarker = new google.maps.Marker({
                position: airportLocation,
                animation: google.maps.Animation.DROP,
                title: airport.name + ' (' + icao + ')'
            });
            bounds.extend(airportLocation);
            map.addMarker(airportMarker);

            var flightPath = new google.maps.Polyline({
                path: [new google.maps.LatLng({{$currentLocation->latitude}},{{$currentLocation->longitude}}), new google.maps.LatLng(airport.latitude, airport.longitude)],
                strokeColor: "#0000FF",
                strokeOpacity: 0.5,
                strokeWeight: 7,
                geodesic: true
            });

            flightPaths[icao] = flightPath;
        });

        map.fitBounds(bounds);

    }

    google.maps.event.addDomListener(window, 'load', mapPolylines());

    $('#destinations_tree').jstree({
        "core" : {
            "themes" : {
                "responsive": true
            }
        },
        "types" : {
            "default" : {
                "icon" : "fa fa-folder icon-state-warning icon-lg"
            },
            "file" : {
                "icon" : "fa fa-file icon-state-warning icon-lg"
            }
        },
        "plugins": ["types", "search", "sort"]
    });

    // handle link clicks in tree nodes(support target="_blank" as well)
    $('#destinations_tree').on('select_node.jstree', function(e,data) {
        var link = $('#' + data.selected).find('a');
        if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
            if (link.attr("target") == "_blank") {
                link.attr("href").target = "_blank";
            }
            document.location.href = link.attr("href");
            return false;
        }
    });

    function showFlight(icao){
        $.each(flightPaths, function(icao, flightPath) {
            flightPaths[icao].setMap(null);
        });
        flightPaths[icao].setMap(map.map);
        // Update the Book Button
        $('#bookButton').text("Book Flight to " + airports[icao].name);
        $('#bookButton').switchClass('default disabled', 'green');
        $('#bookButton').attr("href", "/flights/book/"+airports[icao].routeId);
    }
</script>
@stop
