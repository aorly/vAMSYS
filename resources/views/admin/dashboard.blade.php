@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Admin Centre <small>such power</small>
        </h3>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            100
                        </div>
                        <div class="desc">
                            Airlines
                        </div>
                    </div>
                    <a class="more" href="#">
                        Airlines Administration <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            1,000
                        </div>
                        <div class="desc">
                            Users
                        </div>
                    </div>
                    <a class="more" href="#">
                        Users Administration <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            5,000
                        </div>
                        <div class="desc">
                            Pilots
                        </div>
                    </div>
                    <a class="more" href="#">
                        Pilots Administration <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-wisteria">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            10,000
                        </div>
                        <div class="desc">
                            PIREPs
                        </div>
                    </div>
                    <a class="more" href="#">
                        PIREPs Administration <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow-casablanca">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            100
                        </div>
                        <div class="desc">
                            Online Users
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat grey-cascade">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            500
                        </div>
                        <div class="desc">
                            Pilots Flying Now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Tools
                        </div>
                    </div>
                    <div class="portlet-body">
                        <dl>
                            <dt><a href="/admin/import">Import Text Data</a></dt>
                            <dd>Submit Text Data (AIRACs, Airport Lists, etc) for processing.</dd>
                        </dl>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
