@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Airline Airports <small>such wonderful destinations!</small>
        </h3>
        <div class="row">
            <div class="col-md-8">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Airports
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
                                        ICAO
                                    </th>
                                    <th>
                                        IATA
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Location
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($airline->airports as $airport)
                                    <tr>
                                        <td>{{ $airport->id }}</td>
                                        <td>{{ $airport->icao }}</td>
                                        <td>{{ $airport->iata }}</td>
                                        <td>{{ $airport->name }}</td>
                                        <td>{{ $airport->region->name }}, {{ $airport->region->country->name }}</td>
                                        <td>Actions!</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Airports Management
                        </div>
                    </div>
                    <div class="portlet-body">
                        <p>Here you can manage the Airports in your airline!</p>
                        <p>You need to add Airports to your airline before you can use them in Routes</p>
                        </div></div></div>
        </div>
    </div>
</div>
@stop
