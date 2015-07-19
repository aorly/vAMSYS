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
                                        @if(array_key_exists('jumpseat', $pirep->pirep_data) && $pirep->pirep_data['jumpseat'] === true)
                                            <tr style="height: 10px;">
                                                <td style="padding: 4px; padding-left: 20px;"><small><em>Jumpseat</em></small></td>
                                            <td style="padding: 4px;">
                                                <small>{{$pirep->created_at}}</small>
                                            </td>
                                            <td style="padding: 4px;">
                                                <small>{{$pirep->booking->route->departureAirport->icao}} - {{$pirep->booking->route->departureAirport->name}}</small>
                                            </td>
                                            <td style="padding: 4px;">
                                                <small>{{$pirep->booking->route->arrivalAirport->icao}} - {{$pirep->booking->route->arrivalAirport->name}}</small>
                                            </td>
                                            <td style="padding: 4px;"></td><td style="padding: 4px;"></td>
                                            </tr>
                                        @else
                                    <tr class="@if($pirep->status == 'complete' || $pirep->status == 'accepted') success @elseif($pirep->status == 'rejected' || $pirep->status == 'failed') danger @else info @endif ">
                                        <td>
                                            {{$airline->prefix}}-{{ str_pad($pirep->id, 6, 0, STR_PAD_LEFT) }}
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
                                            @if($pirep->status == 'complete' || $pirep->status == 'accepted' || $pirep->status == 'rejected')
                                                <a href="/pireps/{{$pirep->id}}" class="btn btn-sm blue">View</a>
                                            @elseif($pirep->status == 'failed')
                                                Awaiting PIREP Review
                                            @else
                                                {{ucfirst($pirep->status)}}
                                            @endif

                                        </td>
                                    </tr>
                                    @endif
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