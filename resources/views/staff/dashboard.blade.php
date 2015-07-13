@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Staff Centre <small>manage your airline empire!</small>
        </h3>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airline->pilots->count() }}
                        </div>
                        <div class="desc">
                            Pilots
                        </div>
                    </div>
                    <a class="more" href="/staff/pilots">
                        Pilots Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-building-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airline->airports->count() }}
                        </div>
                        <div class="desc">
                            Airports
                        </div>
                    </div>
                    <a class="more" href="/staff/airports">
                        Airports Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airline->routes->count() }}
                        </div>
                        <div class="desc">
                            Routes
                        </div>
                    </div>
                    <a class="more" href="/staff/routes">
                        Routes Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="dashboard-stat purple-wisteria">
                    <div class="visual">
                        <i class="fa fa-clipboard"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airlinePirepsCount }}
                        </div>
                        <div class="desc">
                            PIREPs
                        </div>
                    </div>
                    <a class="more" href="/staff/pireps">
                        PIREPs Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
