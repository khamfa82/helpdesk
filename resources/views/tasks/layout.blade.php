<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" ng-app="myApp">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        
        @include('tasks.links.header')
    </head>

    <body class="skin-green fixed">
        <div class="wrapper">
            <header class="main-header">
                <a href="{{ route('/')}}" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png')}}" width="100px;"></a>
                @include('tasks.inc.topbar')
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                @include('tasks.inc.sidebar')
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                @include('tasks.inc.topbar-tabs')
                <!-- Main content -->
                <section class="content">
                    @include('tasks.inc.messages')
                    @yield('content')
                </section>
            </div>

            @include('tasks.inc.footer')
        </div><!-- ./wrapper -->

        @include('tasks.links.footer')
    </body>
</html>
