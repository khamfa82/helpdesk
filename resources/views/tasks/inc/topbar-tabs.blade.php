<?php
    $agent_group = auth()->user()->assign_group;
    $group = App\Model\helpdesk\Agent\Groups::where('id', '=', $agent_group)->first();
?>

<!-- Content Header (Page header) -->
<!-- <div class="tab-content" style="background-color: #80B5D3; position: relative; width:100% ;padding: 0 0px 0 0px; z-index:999"> --> <?php #TODO: Hii imeleta Error ?>
    <div class="tab-content" style="background-color: #80B5D3; position: fixed; width:100% ;padding: 0 0px 0 0px; z-index:999">

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <div class="tabs-content">
                
                <div class="tabs-pane @yield('ticket-bar')" id="tabC">
                    <ul class="nav navbar-nav">
                        <li id="bar" @yield('open')><a href="{{ url('/tickets?show=unanswered') }}" id="load-open">{!! Lang::get('lang.not-answered') !!}</a></li>
                        <li id="bar" @yield('answered')><a href="{{ url('/tickets?show=answered')}}" id="load-answered">{!! Lang::get('lang.answered') !!}</a></li>
                        <li id="bar" @yield('assigned')><a href="{{ url('/tickets?show=assigned') }}" id="load-assigned" >{!! Lang::get('lang.assigned') !!}</a></li>
                        <li id="bar" @yield('closed')><a href="{{ url('/tickets?show=closed') }}" >{!! Lang::get('lang.closed') !!}</a></li>
                        <li id="bar" @yield('reopened')><a href="{{ url('/tickets?show=reopened') }}" >{!! Lang::get('lang.reopened') !!}</a></li>
                        @if ($group->can_create_ticket == 1)
                            <li id="bar" @yield('newticket')><a href="{{ url('/newticket')}}" >{!! Lang::get('lang.create_ticket') !!}</a></li>
                        @endif
                    </ul>
                </div>
                
            </div>
        </div>
    </div>

    <section class="content-header">
        @yield('PageHeader')
        @if(Breadcrumbs::exists())
            {!! Breadcrumbs::render() !!}
        @endif
    </section>