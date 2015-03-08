@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Staff Centre <small>manage your airline empire!</small>
        </h3>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
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
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
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
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airline->routes->count() }}
                        </div>
                        <div class="desc">
                            Routes
                        </div>
                    </div>
                    <a class="more" href="#">
                        Routes Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-wisteria">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airlinePirepsCount }}
                        </div>
                        <div class="desc">
                            PIREPs
                        </div>
                    </div>
                    <a class="more" href="#">
                        PIREPs Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-wisteria">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            {{ $airline->aircraft->count() }}
                        </div>
                        <div class="desc">
                            PIREPs
                        </div>
                    </div>
                    <a class="more" href="#">
                        Aircraft Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-wisteria">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            XX
                        </div>
                        <div class="desc">
                            Something Else
                        </div>
                    </div>
                    <a class="more" href="#">
                        Some More Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2">
            <div class="tiles">
                <div class="tile bg-blue dashboard-nav">
                    <div class="corner">
                    </div>
                    <div class="check">
                    </div>
                    <div class="tile-body">
                        <i class="fa fa-cogs"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                            Airline Settings
                        </div>
                    </div>
                </div>
                <div class="tile bg-blue dashboard-nav">
                    <div class="tile-body">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                            Statistics
                        </div>
                        <div class="number">
                        </div>
                    </div>
                </div>
                <div class="tile bg-blue dashboard-nav">
                    <div class="tile-body">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                            Other Things
                        </div>
                    </div>
                </div>
                <div class="tile bg-blue dashboard-nav">
                    <div class="tile-body">
                        <i class="fa fa-plane"></i>
                    </div>
                    <div class="tile-object">
                        <div class="name">
                            More Things
                        </div>
                    </div>
                </div>
            </div>
                </div>
            <div class="col-lg-10 col-md-10">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Flights Map
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="">
                            </a>
                            <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
                            </a>
                            <a href="javascript:;" class="reload" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <p>
                            Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
                        </p>
                        <p>
                            Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
