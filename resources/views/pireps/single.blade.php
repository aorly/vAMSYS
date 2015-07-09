@extends('layouts.metronic')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">
                {{$pirep->booking->callsign}} <small>{{$pirep->booking->route->departureAirport->name}} to {{$pirep->booking->route->arrivalAirport->name}}</small>
            </h3>
            @if($staffBar)
                @if($pirep->status == 'failed')
                    <div class="alert alert-block alert-danger fade in">
                        <h4 class="alert-heading">PIREP Review</h4>
                        <p>This PIREP has failed automatic scoring, and requires a manual review by a staff member.</p>
                        <p><strong>Failure Reason(s): </strong>
                            @foreach($pirep->pirep_data['scores'] as $score)
                                @if($score['failure'] === true)
                                    {{$score['name']}}
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <a class="btn green" href="/staff/pireps/accept/{{$pirep->id}}">
                                Accept </a>
                            <a class="btn red" href="/staff/pireps/reject/{{$pirep->id}}">
                                Reject </a>
                        </p>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-plane"></i>Flight Details
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="list-unstyled">
                                <li><strong>Pilot: </strong>{{$pirep->booking->pilot->user->first_name}} {{$pirep->booking->pilot->user->last_name}} {{$pirep->booking->pilot->username}}</li>
                                <li><strong>Rank: </strong>{{$pirep->booking->pilot->rank->name}}</li>
                                <br />
                                <li><strong>Aircraft:</strong> {{$pirep->booking->aircraft->full_name}} {{$pirep->booking->aircraft->registration}}</li>
                                <li><strong>Booking Date:</strong> {{$pirep->booking->created_at}}</li>
                                <li><strong>PIREP Filed:</strong> {{$pirep->created_at}}</li>
                                <br />
                                <li><strong>Landing Rate:</strong> {{$pirep->landing_rate}}fpm</li>
                                <li><strong>Total Points:</strong> {{$pirep->points}}</li>
                                <li><strong>Network:</strong> {{$pirep->pirep_data['network']}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-compass"></i>Route
                            </div>
                        </div>
                        <div class="portlet-body">
                            <pre>{{$pirep->booking->route->route}}</pre>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Flight Map
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="gmap_pirep_path" class="gmaps">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-area-chart"></i>Flight Profile
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="profile_chart" class="chart" style="height: 400px; width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-clock-o"></i>Flight Times
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="list-unstyled">
                                <li><strong>Flight Started: </strong>{{$pirep->pirep_start_time}}</li>
                                <li><strong>Off Blocks: </strong>{{$pirep->off_blocks_time}}</li>
                                <li><strong>Takeoff: </strong>{{$pirep->departure_time}}</li>
                                <li><strong>Landing: </strong>{{$pirep->landing_time}}</li>
                                <li><strong>On Blocks: </strong>{{$pirep->on_blocks_time}}</li>
                                <li><strong>Flight Finished: </strong>{{$pirep->pirep_end_time}}</li><br/>

                                <li><strong>Airborne Time: </strong>{{$extras['airborneTime']->format('%H:%I:%S')}}</li>
                                <li><strong>Blocks Time: </strong>{{$extras['blocksTime']->format('%H:%I:%S')}}</li>
                                <li><strong>Start to Finish: </strong>{{$extras['totalTime']->format('%H:%I:%S')}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cubes"></i>Points Allocation
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="list-unstyled">
                                <li><strong>Starting Points: </strong>100</li>
                                @foreach($pirep->pirep_data['scores'] as $score)
                                    <li><strong>{{$score['name']}}: </strong><span style="color:@if($score['points'] < 0 || $score['failure']) #990000 @else #009900 @endif">{{$score['points']}}</span></li>
                                @endforeach
                                <br /><li><strong>Total Points: </strong> {{$pirep->points}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bars"></i>Text Log
                            </div>
                        </div>
                        <div class="portlet-body">
                            <pre style="overflow-y: scroll; height: 500px;">{{$extras['log']}}</pre>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Flight Events
                            </div>
                            <ul class="nav nav-tabs">
                                <li>
                                    <a href="#gear" data-toggle="tab">
                                        Gear</a>
                                </li>
                                <li>
                                    <a href="#flaps" data-toggle="tab">
                                        Flaps</a>
                                </li>
                                <li class="active">
                                    <a href="#engines" data-toggle="tab">
                                        Engines</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="engines">
                                    <ul class="list-unstyled">
                                        @foreach($pirep->pirep_data['engines'] as $event)
                                            <li><strong>{{$event['timestamp']}}</strong><br />Engine {{$event['engine']}}@if($event['status'] === 'on') Started @elseif($event['status'] === 'off') Shutdown @endif</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane" id="gear">
                                    <ul class="list-unstyled">
                                    @foreach($pirep->pirep_data['gear_changes'] as $event)
                                        <li><strong>{{$event['timestamp']}}</strong><br />Gear @if($event['status'] === 'raised') Raised @elseif($event['status'] === 'lowered') Lowered @endif at {{$event['altitude']}}ft, {{$event['speed']}} kts</li>
                                    @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane" id="flaps">
                                    <ul class="list-unstyled">
                                    @foreach($pirep->pirep_data['flap_changes'] as $event)
                                        <li><strong>{{$event['timestamp']}}</strong><br />Flaps set to position {{$event['to']}}@if(array_key_exists('altitude', $event)) at {{$event['altitude']}}ft, {{$event['speed']}} kts @else on the ground @endif</li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop

        @section('pagejs')
            <script type="text/javascript" src="/vendor/js/amcharts/amcharts.js"></script>
            <script type="text/javascript" src="/vendor/js/amcharts/serial.js"></script>
            <script type="text/javascript" src="/vendor/js/amcharts/themes/light.js"></script>
            <script type="text/javascript">
                var initProfileChart = function() {
                    var chart = AmCharts.makeChart("profile_chart", {
                        "type": "serial",
                        "theme": "light",

                        "fontFamily": 'Open Sans',
                        "color":    '#000000',

                        "legend": {
                            "equalWidths": false,
                            "useGraphSettings": true,
                            "valueAlign": "left",
                            "valueWidth": 120
                        },
                        "dataProvider": [
                            @foreach($pirep->positionReports as $index => $positionReport){
                                "dateTime": "{{$positionReport->created_at}}",
                                "altitude": {{$positionReport->altitude}},
                                "speed": {{$positionReport->groundspeed}},
                                "phase": {{$positionReport->phase}}
                            }@if ($index+1 != count($pirep->positionReports)),@endif
                            @endforeach
                        ],
                        "valueAxes": [{
                            "id": "altitudeAxis",
                            "axisAlpha": 0,
                            "gridAlpha": 0,
                            "position": "left",
                            "title": "altitude"
                        }, {
                            "id": "speedAxis",
                            "axisAlpha": 0,
                            "gridAlpha": 0,
                            "position": "right",
                            "title": "speed"
                        }],
                        "graphs": [{
                            "lineThickness": 5,
                            "balloonText": "[[value]]ft",
                            "legendPeriodValueText": "Max Altitude: [[value.high]]ft",
                            "legendValueText": "[[value]]ft",
                            "title": "Altitude",
                            "valueField": "altitude",
                            "valueAxis": "altitudeAxis"
                        },{
                            "lineThickness": 5,
                            "balloonText": "[[value]] kts",
                            "legendPeriodValueText": "Max Speed: [[value.high]] kts",
                            "legendValueText": "[[value]] kts",
                            "title": "Speed",
                            "valueField": "speed",
                            "valueAxis": "speedAxis"
                        }],
                        "chartCursor": {
                            "categoryBalloonDateFormat": "JJ:NN:SS",
                            "cursorAlpha": 0.5,
                            "cursorColor": "#000000",
                            "fullWidth": true,
                            "valueBalloonsEnabled": true,
                            "zoomable": true
                        },
                        "dataDateFormat": "YYYY-MM-DD JJ:NN:SS",
                        "categoryField": "dateTime",
                        "categoryAxis": {
                            "boldPeriodBeginning": false,
                            "parseDates": true,
                            "minPeriod": "ss"
                        }
                    });
                }

                AmCharts.ready(initProfileChart());
            </script>
            <script type="text/javascript">
                var mapPolylines = function () {
                    var map = new GMaps({
                        div: '#gmap_pirep_path',
                        lat: 49.617828,
                        lng: 3.7874943,
                        zoom: 3,
                        click: function (e) {
                            console.log(e);
                        }
                    });

                    var path = [
                        @foreach($pirep->positionReports as $index => $report)
                        [{{$report->latitude}}, {{$report->longitude}}]@if ($index+1 != count($pirep->positionReports)),@endif

            @endforeach
        ];

                    var route = [
                        @foreach($extras['routePoints'] as $index => $point)
                        [{{$point->latitude}}, {{$point->longitude}}]@if ($index+1 != count($extras['routePoints'])),@endif

            @endforeach
        ];

                    var departureLatlng = new google.maps.LatLng({{$pirep->positionReports[0]->latitude}},{{$pirep->positionReports[0]->longitude}});
                    var departure = new google.maps.Marker({
                        position: departureLatlng,
                        animation: google.maps.Animation.DROP,
                        title: '{{$pirep->booking->route->departureAirport->name}} ({{$pirep->booking->route->departureAirport->icao}})'
                    });

                    var arrivalLatlng = new google.maps.LatLng({{$pirep->positionReports[count($pirep->positionReports) - 1]->latitude}},{{$pirep->positionReports[count($pirep->positionReports) - 1]->longitude}});
                    var arrival = new google.maps.Marker({
                        position: arrivalLatlng,
                        animation: google.maps.Animation.DROP,
                        title: '{{$pirep->booking->route->arrivalAirport->name}} ({{$pirep->booking->route->arrivalAirport->icao}})'
                    });

                    map.addMarker(departure);
                    map.addMarker(arrival);

                    map.drawPolyline({
                        path: route,
                        strokeColor: '#13FF40',
                        strokeOpacity: 0.6,
                        strokeWeight: 10,
                        geodesic: true
                    });

                    map.drawPolyline({
                        path: path,
                        strokeColor: '#131540',
                        strokeOpacity: 0.8,
                        strokeWeight: 3
                    });

                    var bounds = new google.maps.LatLngBounds();

                    path.forEach(function(latLng) {
                        var thePoint = new google.maps.LatLng(latLng[0], latLng[1]);
                        bounds.extend(thePoint);
                    });

                    map.fitBounds(bounds);

                }

                google.maps.event.addDomListener(window, 'load', mapPolylines());
            </script>
@stop