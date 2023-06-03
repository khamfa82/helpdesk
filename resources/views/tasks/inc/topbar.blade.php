<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="collapse navbar-collapse" id="navbar-collapse">
        
        
        {{-- Topbar left side --}}
        <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
            <li style="color: white"><strong>FAVEO TASKS</strong></li>
            <li @yield('Dashboard')><a id="dash" data-target="#tabA" href="{{URL::route('dashboard')}}" onclick="clickDashboard(event);">{!! Lang::get('lang.dashboard') !!}</a></li>
            <li @yield('Tickets')><a data-target="#tabC" href="#">{!! Lang::get('lang.tickets') !!}</a></li>
        </ul>
        
        {{-- Topbar right side --}}
        <ul class="nav navbar-nav navbar-right">
            
            @if(auth()->user()->role == 'admin')
                <li>
                    <a href="{{url('admin')}}">{!! Lang::get('lang.admin_panel') !!}</a>
                </li>
            @endif

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu" id="myDropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="myFunction()">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-danger" id="count"> (X) </span>
                </a>
                <ul class="dropdown-menu" style="width:500px">

                    <div id="alert11" class="alert alert-success alert-dismissable" style="display:none;">
                        <button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i>Alert!</h4>
                        <div id="message-success1"></div>
                    </div>

                    <li id="refreshNote">

                    <ul class="menu">
                        {{-- // TODO: notifications for tickets --}}
                    </ul>
            </li>
            
            <li class="footer no-border"><div class="col-md-5"></div><div class="col-md-2">
                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="display: none;" id="notification-loader">
                </div><div class="col-md-5"></div></li>
            <li class="footer"><a href="{{ url('notifications-list')}}">View all</a>
            
            </li>
            </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    @if(!auth()->guest())
                    <img src="{{auth()->user()->profile_pic}}"class="user-image" alt="User Image"/>
                    <span class="hidden-xs">{{auth()->user()->first_name . " " . auth()->user()->last_name}}</span>
                    @endif
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header"  style="background-color:#343F44;">
                        <img src="{{auth()->user()->profile_pic}}" class="img-circle" alt="User Image" />
                        <p>
                            {{auth()->user()->first_name . " " . auth()->user()->last_name}} - {{auth()->user()->role}}
                            <small></small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer" style="background-color:#1a2226;">
                        <div class="pull-left">
                            <a href="{{URL::route('profile')}}" class="btn btn-info btn-sm"><b>{!! Lang::get('lang.profile') !!}</b></a>
                        </div>
                        <div class="pull-right">
                            <a href="{{url('auth/logout')}}" class="btn btn-danger btn-sm"><b>{!! Lang::get('lang.sign_out') !!}</b></a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

