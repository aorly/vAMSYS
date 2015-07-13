@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            PIREPs <small>your pilots have been busy!</small>
        </h3>
        <div class="row">
            <div class="col-md-12">
                @if(count($failedPireps) > 0)
                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Review Needed
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
                                        Failure Reason
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($failedPireps as $pirep)
                                    <tr>
                                        <td>{{ $pirep->id }}</td>
                                        <td>{{ $pirep->booking->pilot->user->first_name }} {{ $pirep->booking->pilot->user->last_name }} ({{ $pirep->booking->pilot->username }})</td>
                                        <td>{{ $pirep->booking->route->departureAirport->icao }}</td>
                                        <td>{{ $pirep->booking->route->arrivalAirport->icao }}</td>
                                        <td>
                                            @foreach($pirep->pirep_data['scores'] as $score)
                                                @if($score['failure'] === true)
                                                    {{$score['name']}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td><a href="/staff/pireps/view/{{ $pirep->id }}" class="btn btn-success btn-xs">View</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
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
                                        <td><a href="/staff/pireps/view/{{ $pirep->id }}" class="btn btn-success btn-xs">View</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
