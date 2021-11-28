<!DOCTYPE html>
<!--
    Author : JoomShaper -> Jobayer Al Mahmud Tuser
    Company Websiste: http://joomshaper.com
    Author Website : http://jobayertuser.tk
-->

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title> {{ config('app.name', "Hello")}} </title> --}}
    <title> @yield('title') </title>


    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/loader.js') }}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @include('projects.layouts._extracss')
    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 166px)!important;
        }
    </style>
    @stack('css')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body>
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN HEADER  -->
    @include('projects.layouts._header')
    <!--  END HEADER  -->

    <!--  BEGIN SUB HEADER  -->
    @include('projects.layouts._subheader')
    <!--  END SUB HEADER  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN NAVBAR  -->
        @include('projects.layouts._navbar')
        <!--  END NAVBAR  -->

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                @yield('content')
            </div>
            @include('projects.layouts._footer')
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset( 'assets/js/libs/jquery-3.1.1.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/bootstrap/js/popper.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/bootstrap/js/bootstrap.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js' ) }}"></script>
    <script src="{{ asset( 'assets/js/app.js' ) }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset( 'assets/js/custom.js' ) }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    @include('projects.layouts._extrajs')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @stack('script');
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>
