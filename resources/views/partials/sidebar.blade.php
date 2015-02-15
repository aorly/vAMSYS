<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="400">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start">
                <a href="/dashboard">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">Flight Centre</h3>
            </li>
            <li>
                <a href="/flights">
                    <i class="icon-plane"></i>
                    <span class="title">{{ Lang::choice('sidebar.flightBooking', vAMSYS\Repositories\PilotRepository::countBookedFlights()) }}</span>
                </a>
            </li>
            @if (vAMSYS\Repositories\UserRepository::hasRole($airline->prefix.'-staff', $user))
            <li class="heading">
                <h3 class="uppercase">Staff</h3>
            </li>
            <li>
                <a href="/staff">
                    <i class="icon-wrench"></i>
                    <span class="title">Staff Centre</span>
                </a>
            </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>