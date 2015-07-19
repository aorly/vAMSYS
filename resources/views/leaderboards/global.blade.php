@extends('layouts.metronic')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">
                Leaderboards <small>who's the best?</small>
            </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-trophy"></i>Airline Leaderboards
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title="">
                                </a>
                                <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_top_points" data-toggle="tab">
                                        Top Points</a>
                                </li>
                                <li>
                                    <a href="#tab_top_hours" data-toggle="tab">
                                        Top Hours</a>
                                </li>
                                <li>
                                    <a href="#tab_top_flight_count" data-toggle="tab">
                                        Top Flight Count</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab_top_points">
                                    <table class="table table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Callsign
                                            </th>
                                            <th>
                                                Pilot Name
                                            </th>

                                            <th>
                                                Total Points
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->pirepPoints as $index => $pointsEntry)
                                        <tr>
                                            <td>
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                {{ $pointsEntry[0]->booking->pilot->username }}
                                            </td>
                                            <td>
                                                {{ $pointsEntry[0]->booking->pilot->user->first_name }} {{ $pointsEntry[0]->booking->pilot->user->last_name }}
                                            </td>

                                            <td>
                                                {{ $pointsEntry->totalPoints }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade out" id="tab_top_hours">
                                    <table class="table table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Pilot Name
                                            </th>
                                            <th>
                                                Callsign
                                            </th>
                                            <th>
                                                Total Hours
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->pirepHours as $index => $hoursEntry)
                                            <tr>
                                                <td>
                                                    {{ $index + 1 }}
                                                </td>
                                                <td>
                                                    {{ $hoursEntry[0]->booking->pilot->username }}
                                                </td>
                                                <td>
                                                    {{ $hoursEntry[0]->booking->pilot->user->first_name }} {{ $hoursEntry[0]->booking->pilot->user->last_name }}
                                                </td>

                                                <td>
                                                    {{ $hoursEntry->totalInterval->diffInHours() }} hours
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade out" id="tab_top_flight_count">
                                    <table class="table table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Pilot Name
                                            </th>
                                            <th>
                                                Callsign
                                            </th>
                                            <th>
                                                Total PIREPs
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->pirepCounts as $index => $countEntry)
                                            <tr>
                                                <td>
                                                    {{ $index + 1 }}
                                                </td>
                                                <td>
                                                    {{ $countEntry[0]->booking->pilot->username }}
                                                </td>
                                                <td>
                                                    {{ $countEntry[0]->booking->pilot->user->first_name }} {{ $countEntry[0]->booking->pilot->user->last_name }}
                                                </td>

                                                <td>
                                                    {{ count($countEntry) }}
                                                </td>
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