@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Flights Centre <small>bookings, departure information, meal selection</small>
        </h3>
        <div class="row">
            <div class="col-md-6">
                <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-arrow"></i>Next Flight
                    </div>
                    <div class="actions">
                        <a onClick="javascript:doDelete({{$currentBooking->id}})" class="btn btn-sm btn-danger">
                            <i class="fa fa-times-circle"></i> Cancel Booking </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <h1 class="next-flight">{{ $currentBooking->callsign }} <small>using <strong>{{ $currentBooking->aircraft->registration }}</strong></small></h1>
                    <h3 class="next-flight"><strong>
                            {{ $currentBooking->route->departureAirport->name }}
                        </strong> to <strong>
                            {{ $currentBooking->route->arrivalAirport->name }}
                        </strong></h3>
                </div>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Route
                        </div>
                    </div>
                    <div class="portlet-body">
                        <pre>{{ $currentBooking->route->route }}</pre>
                    </div>

                </div>

                <div class="portlet box blue-chambray">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Flight Map
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="gmap_flight_path" class="gmaps">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-arrow"></i>Upcoming Bookings
                        </div>
                        <div class="actions">
                            <a href="/flights/book" class="btn btn-sm btn-success">
                                <i class="fa fa-caret-square-o-right"></i> New Booking </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        @if(count($upcomingBookings) > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Departure
                                </th>
                                <th>
                                    Arrival
                                </th>
                                <th>
                                    Callsign
                                </th>
                                <th>
                                    Aircraft
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($upcomingBookings as $booking)
                            <tr>
                                <td>
                                    {{ $booking->route->departureAirport->name }}
                                </td>
                                <td>
                                    {{ $booking->route->arrivalAirport->name }}
                                </td>
                                <td>
                                    {{ $booking->callsign }}
                                </td>
                                <td>
                                    {{ $booking->aircraft->registration }}
                                </td>
                                <td>
									Buttons
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-center">No Upcoming Bookings</p>
                        @endif
                    </div>
                </div>

            </div>
    </div>
</div>
@stop

@section('pagejs')
<script type="text/javascript">

    function doDelete(bookingId) {
        @if(count($upcomingBookings) > 0)
            var confirm = window.confirm('This will cancel all of your booked flights. Are you sure?');
            if (confirm){
                window.location = "/flights/cancel/" + bookingId;
            }
        @else
            window.location = "/flights/cancel/" + bookingId;
        @endif
    }

    var mapPolylines = function () {
        var map = new GMaps({
            div: '#gmap_flight_path',
            lat: 49.617828,
            lng: 3.7874943,
            zoom: 3,
            click: function (e) {
                console.log(e);
            }
        });

        console.log(map);

        var path = [
            @foreach($routePoints as $index => $point)
[{{$point->latitude}}, {{$point->longitude}}]@if ($index+1 != count($routePoints)),@endif

            @endforeach
        ];

        var departureLatlng = new google.maps.LatLng({{$routePoints[0]->latitude}},{{$routePoints[0]->longitude}});
        var departure = new google.maps.Marker({
            position: departureLatlng,
            animation: google.maps.Animation.DROP,
            title: '{{$currentBooking->route->departureAirport->name}} ({{$currentBooking->route->departureAirport->icao}})'
        });

        var arrivalLatlng = new google.maps.LatLng({{$routePoints[count($routePoints) - 1]->latitude}},{{$routePoints[count($routePoints) - 1]->longitude}});
        var arrival = new google.maps.Marker({
            position: arrivalLatlng,
            animation: google.maps.Animation.DROP,
            title: '{{$currentBooking->route->arrivalAirport->name}} ({{$currentBooking->route->arrivalAirport->icao}})'
        });

        map.addMarker(departure);
        map.addMarker(arrival);

        map.drawPolyline({
            path: path,
            strokeColor: '#131540',
            strokeOpacity: 0.6,
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
