@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Dashboard <small>information and statistics</small>
        </h3>
        <div class="row">
            <div class="col-md-6">{{ vAMSYS\Repositories\PilotRepository::countBookedFlights() }}</div>
            <div class="col-md-6">
                <!-- BEGIN MARKERS PORTLET-->
                <div class="portlet box blue-chambray">
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
                            <a href="javascript:;" class="remove" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="gmap_live_flights" class="gmaps">
                        </div>
                    </div>

                </div>
                <!-- END MARKERS PORTLET-->
            </div>
        </div>
    </div>
</div>
@stop

@section('pagejs')
    <script typ="text/javascript">
        // Map Definitions
        var liveFlights = function () {
            new GMaps({
                div: '#gmap_live_flights',
                lat: 49.617828,
                lng: 3.7874943
            });
        }

        liveFlights();
    </script>
@stop
