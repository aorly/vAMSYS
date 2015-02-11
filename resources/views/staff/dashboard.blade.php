@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Staff Centre <small>manage your airline empire!</small>
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
                            Pilots
                        </div>
                    </div>
                    <a class="more" href="#">
                        Pilots Management <i class="m-icon-swapright m-icon-white"></i>
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
                            Airports
                        </div>
                    </div>
                    <a class="more" href="#">
                        Airports Management <i class="m-icon-swapright m-icon-white"></i>
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
                            Routes
                        </div>
                    </div>
                    <a class="more" href="#">
                        Routes Management <i class="m-icon-swapright m-icon-white"></i>
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
                        PIREPs Management <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-wallet"></i>Payments
                        </div>
                    </div>
                    <div class="portlet-body">
                        @if ($airline->subscribed())
                            You are subscribed to the {{ $airline->stripe_plan }} plan!
                        @else
                        <form action="/staff/postPayment" method="POST">
                            <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_test_X2RqYbzkhXlB8bj5sD5xpT8Q"
                                    data-name="vAMSYS Demo"
                                    data-description="250 Pilot Plan (£5.00 a month)"
                                    data-amount="500"
                                    data-label="250 Pilot Plan"
                                    data-email="{{ $pilot->user->email }}"
                                    data-panel-label="Subscribe -"
                                    data-currency="GBP">
                            </script>
                        </form>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
