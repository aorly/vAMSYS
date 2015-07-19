@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Dashboard <small>information and statistics</small>
        </h3>
        <div class="row">
            <div class="col-md-12"><center>
                <h1>Welcome to the vAMSYS Test Environment</h1>
                    <h3>Normally a lot more data would go here.</h3>
                    <h5>When things break - tell us! Contact your vRYR staff representative.</h5>
                    <h5><a href="https://tfdidesign.com/smartcars/app.php?action=download&airlineid=124&language=en-US">Click here to download smartCARS 2</a></h5>
                    </center><br />
                <div class="col-md-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-speech"></i>
                            <span class="caption-subject bold uppercase"> BETA Updates</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><div class="scroller" style="height: 200px; overflow: hidden; width: auto;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" data-initialized="1">
                                <h4>
                                    Update 2015-07-19
                                </h4>
                                <p>
                                    <ul>
                                        <li>Book Flight is now Searchable by Name, ICAO, and IATA</li>
                                        <li>Jumpseat flights are now available from the Book Flight screen. Jumpseats will appear in your PIREPs list</li>
                                        <li>Leaderboards are now visible!</li>
                                        <li>Password Reset now exists on the login page</li>
                                    </ul>
                                </p>

                            </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 136.986301369863px; background: rgb(161, 178, 189);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; display: none; background: yellow;"></div></div>
                    </div>
                </div>
                    </div>
                <div class="col-md-6">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-speech"></i>
                                <span class="caption-subject bold uppercase"> Known Issues</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><div class="scroller" style="height: 200px; overflow: hidden; width: auto;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" data-initialized="1">
                                    <p>
                                    <ul>
                                        <li>Changing time settings in smartCARS 2 can cause PIREP processing bugs</li>
                                    </ul>
                                    </p>

                                </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 136.986301369863px; background: rgb(161, 178, 189);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; display: none; background: yellow;"></div></div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@stop
