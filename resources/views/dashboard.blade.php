@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Dashboard <small>information and statistics</small>
        </h3>
        <div class="row">
            <div class="col-md-12"><center>
                <h1>Welcome to vAMSYS</h1>
                    <h3>vRYR Flight Tracking and PIREP Recording</h3>
                    <h5><a href="https://tfdidesign.com/smartcars/app.php?action=download&airlineid=124&language=en-US">Click here to download smartCARS 2</a></h5>
                    </center><br />
                <div class="col-md-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-speech"></i>
                            <span class="caption-subject bold uppercase">News and Updates</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                            <div class="scroller" style="height: 200px; overflow: hidden; width: auto;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" data-initialized="1">
                                <h4>
                                    We're Open! - 31/08/15 @ 1800z
                                </h4>
                                <p>
                                We're back! Thank you for your patience and we hope you like the new system! vAMSYS is a complete rewrite from the ground up, and so many vRAMS features are not yet ported.
                                </p><p>
                                <strong>IMPORTANT: OLD PIREPS</strong><br />Some of your old PIREPs (or all of them!) may be missing. This is normal - our import scripts are still importing the data. Please be patient, they will appear in the next 24 hours.</p>
                                </p>
                                <p>This Dashboard will be revamped and reworked over the coming days - keep an eye on this news feed and our Facebook page for updates!</p>

                            </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 136.986301369863px; background: rgb(161, 178, 189);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; display: none; background: yellow;"></div></div>
                    </div>
                </div>
                    </div>
                <div class="col-md-6">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-speech"></i>
                                <span class="caption-subject bold uppercase">Important Notices</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><div class="scroller" style="height: 200px; overflow: hidden; width: auto;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" data-initialized="1">
                                    <p>
                                    <ul>
                                        <li>Changing time settings in smartCARS 2 can cause PIREP processing bugs, please do not do it!</li>
                                        <li>Our maps engine is currently under maintenance, flight routes may not be displayed on some maps.</li>
                                        <li>Legacy PIREPs (from the vRACARS) system currently will not have a detail view. This is being investigated.</li>
                                        <li>smartCARS 1 PIREPs will currently not have a score breakdown. This is being investigated.</li>
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
