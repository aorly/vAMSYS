@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Airline Routes <small>at the junction, turn left</small>
        </h3>
        <div class="row">
            <div class="col-md-8">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Routes
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
                                        From
                                    </th>
                                    <th>
                                        To
                                    </th>
                                    <th>
                                        Route
                                    </th>
                                    <th>
                                        Callsign Rules
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($airline->routes as $route)
                                    <tr>
                                        <td>{{ $route->id }}</td>
                                        <td>{{ $route->departureAirport->name }} ({{ $route->departureAirport->icao }})</td>
                                        <td>{{ $route->arrivalAirport->name }} ({{ $route->arrivalAirport->icao }})</td>
                                        <td>{{ $route->route }}</td>
                                        <td>{{ $route->callsign_rules }}</td>
                                        <td></td>
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
                            <?php echo csrf_field(); ?>
                            <input type="text" name="from" placeholder="From ICAO" /><br />
                            <input type="text" name="to" placeholder="To ICAO" /><br />
                            <input type="text" name="route" placeholder="Route"" /><br />
                            <button type="submit" />
                        </form>
                    </div>
                </div>
            </div>
                        
        </div>
    </div>
</div>
@stop
