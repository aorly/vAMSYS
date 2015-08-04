@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            {{ $thePilot->user->first_name }} {{ $thePilot->user->last_name }} <small>{{ $thePilot->username }}</small>
        </h3>
        <div class="row">
            <div class="col-md-4">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-info"></i>
                            <span class="caption-subject">About {{$thePilot->user->first_name}}</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul>
                            <li>Total Hours</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
