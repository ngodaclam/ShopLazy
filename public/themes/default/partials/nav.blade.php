<div class="sidebar">
    <div class="logopanel">
        <h1><a href="{{ url('/') }}">{!! env('APP_NAME', 'PTS-VIET') !!}</a></h1>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-top big-img clearfix">
            <div class="user-image">
                <img src="{{ session('user.avatar') ?: url('themes/default/assets/img/avatars/avatar1_big@2x.png') }}"
                     class="img-responsive img-circle">
            </div>
            <div class="user-details">
                <h4>{!! session('user.name') !!}</h4>
            </div>
        </div>
        <ul class="nav nav-sidebar">
            {!! theme()->partial('menu.items', ['items' => $menu_backend->roots()]) !!}
        </ul>
        <!-- SIDEBAR WIDGET FOLDERS -->
        <div class="sidebar-widgets">
            <p class="menu-title widget-title">Statistics
    <span class="pull-right">
      <a href="#" class="hide-widget"> <i class="icons-office-52"></i></a>
    </span>
            </p>

            <div class="charts-sidebar">
                <div class="sidebar-charts-inner">
                    <div class="sidebar-charts-left">
                        <div class="sidebar-chart-title">Orders</div>
                        <div class="sidebar-chart-number">1,256</div>
                    </div>
                    <div class="sidebar-charts-right" data-type="bar">
                        <span class="dynamicbar1"><canvas width="69" height="28"
                                                          style="display: inline-block; width: 69px; height: 28px; vertical-align: top;"></canvas></span>
                    </div>
                </div>
                <hr class="divider">
                <div class="sidebar-charts-inner">
                    <div class="sidebar-charts-left">
                        <div class="sidebar-chart-title">Income</div>
                        <div class="sidebar-chart-number">$47,564</div>
                    </div>
                    <div class="sidebar-charts-right" data-type="bar">
                        <span class="dynamicbar2"><canvas width="69" height="28"
                                                          style="display: inline-block; width: 69px; height: 28px; vertical-align: top;"></canvas></span>
                    </div>
                </div>
                <hr class="divider">
                <div class="sidebar-charts-inner">
                    <div class="sidebar-charts-left">
                        <div class="sidebar-chart-title">Visits</div>
                        <div class="sidebar-chart-number" id="number-visits">147,687</div>
                    </div>
                    <div class="sidebar-charts-right" data-type="bar">
                        <span class="dynamicbar3"><canvas width="69" height="28"
                                                          style="display: inline-block; width: 69px; height: 28px; vertical-align: top;"></canvas></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar-footer clearfix">
            <a class="pull-left footer-settings" href="#" data-rel="tooltip" data-placement="top"
               data-original-title="Settings">
                <i class="icon-settings"></i></a>
            <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top"
               data-original-title="Fullscreen">
                <i class="icon-size-fullscreen"></i></a>
            <a class="pull-left" href="#" data-rel="tooltip" data-placement="top" data-original-title="Lockscreen">
                <i class="icon-lock"></i></a>
            <a class="pull-left btn-effect" href="{{ route('logout') }}" data-modal="modal-1" data-rel="tooltip"
               data-placement="top" data-original-title="Logout">
                <i class="icon-power"></i></a>
        </div>
    </div>
</div>