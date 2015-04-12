@extends('layouts.metronic')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">
                PIREP History <small>see your past flight history</small>
            </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-arrow"></i>Previous PIREPs
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if(count($pireps) > 0)
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Departure
                                        </th>
                                        <th>
                                            Arrival
                                        </th>
                                        <th>
                                            Points
                                        </th>
                                        <th>
                                            View
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pireps as $pirep)
                                    <tr>
                                        <td>
                                            {{$pirep->id}}
                                        </td>
                                        <td>
                                            {{$pirep->created_at}}
                                        </td>
                                        <td>
                                            {{$pirep->booking->route->departureAirport->icao}} - {{$pirep->booking->route->departureAirport->name}}<br />
                                            <small>{{$pirep->departure_time}}</small>
                                        </td>
                                        <td>
                                            {{$pirep->booking->route->arrivalAirport->icao}} - {{$pirep->booking->route->arrivalAirport->name}}
                                            <br />
                                            <small>{{$pirep->landing_time}}</small>
                                        </td>
                                        <td>
                                            {{$pirep->points}}
                                        </td>
                                        <td>
                                            <a href="/pireps/{{$pirep->id}}" class="btn btn-sm blue">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table></div>
                                @else
                                <center><h3>You haven't flown any flights yet!</h3></center>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop