@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Airline Pilots <small>minions! everywhere!</small>
        </h3>
        <div class="row">
            <div class="col-md-8">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Pilots
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
                                        Pilot ID
                                    </th>
                                    <th>
                                        First Name
                                    </th>
                                    <th>
                                        Last Name
                                    </th>
                                    <th>
                                        Rank
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($airline->pilots as $pilot)
                                    <tr>
                                        <td>{{ $pilot->id }}</td>
                                        <td>{{ $pilot->username }}</td>
                                        <td>{{ $pilot->user->first_name }}</td>
                                        <td>{{ $pilot->user->last_name }}</td>
                                        <td>{{ $pilot->rank->name }}</td>
                                        <td><a href="/staff/pilots/{{ $pilot->id }}/ban">Ban</a> - <a href="/staff/pilots/{{ $pilot->id }}/rank">Change Rank</a></td>
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
                            <i class="fa fa-cogs"></i>BETA - Quick Add Pilot
                        </div>
                    </div>
                    <div class="portlet-body">
                        <small>The user MUST be registered first!</small>
                        <form action="/staff/pilots/add" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" name="callsign" placeholder="Callsign" /><br />
                            <input type="text" name="email" placeholder="Email" /><br />
                            <button type="submit">Add Pilot</button>
                        </form>
                    </div>
                </div>
            </div>
                        
        </div>
    </div>
</div>
@stop
