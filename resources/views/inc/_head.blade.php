    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title> {{ config('app.name', "Hello")}} </title> --}}
    <title> @yield('title') </title>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/preloader.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icons.min.css') }}"  />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.min.css') }}"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @include('inc._extracss')
    @stack('css')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

