@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            PIREPs <small>your pilots have been busy!</small>
        </h3>
        <div class="row">
            <div class="col-md-8">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>PIREPs
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-hover table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Pilot
                                    </th>
                                    <th>
                                        From
                                    </th>
                                    <th>
                                        To
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Points
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pireps as $pirep)
                                    <tr>
                                        <td>{{ $pirep->id }}</td>
                                        <td>{{ $pirep->booking->pilot->user->first_name }} {{ $pirep->booking->pilot->user->last_name }} ({{ $pirep->booking->pilot->username }})</td>
                                        <td>{{ $pirep->booking->route->departureAirport->name }} ({{ $pirep->booking->route->departureAirport->icao }})</td>
                                        <td>{{ $pirep->booking->route->arrivalAirport->name }} ({{ $pirep->booking->route->arrivalAirport->icao }})</td>
                                        <td>{{ $pirep->status }}</td>
                                        <td>{{ $pirep->points }}</td>
                                        <td><a href="/staff/pireps/view/{{ $pirep->id }}">View</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Pilot Management
                        </div>
                    </div>
                    <div class="portlet-body">
                        <p>Here you can manage the Pilots in your airline!</p>
                    </div>
                </div>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>BETA - Quick Add Route
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form action="/staff/routes/add" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" name="from" placeholder="From ICAO" /><br />
                            <input type="text" name="to" placeholder="To ICAO" /><br />
                            <input type="text" name="route" placeholder="Route" /><br />
                            <button type="submit">Add Route</button>
                        </form>
                    </div>
                </div>
            </div>
                        
        </div>
    </div>
</div>
@stop
