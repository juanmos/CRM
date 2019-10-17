<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Free Datta Able Admin Template come up with latest Bootstrap 4 framework with basic components, form elements and lots of pre-made layout options" />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

    <!-- Favicon icon -->
    <link rel="icon" href="{{url('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    {{-- <link rel="stylesheet" href="{{url('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}"> --}}

    <style>
        {{-- <?php include(public_path().'/assets/fonts/fontawesome/css/fontawesome-all.min.css');?> --}}
        <?php include(public_path().'/assets/plugins/bootstrap/css/bootstrap.min.css');?>
        <?php include(public_path().'/assets/css/style1.css');?>
    </style>
    <script>
        <?php include(public_path().'/assets/js/vendor-all.min.js');?>
        <?php include(public_path().'/assets/plugins/bootstrap/js/bootstrap.min.js');?>
        <?php include(public_path().'/assets/js/pcoded.min.js');?>
    </script>
    @stack('scripts')
</head>
<body style="background-color:white">
    <div id="app">
            
        <!-- [ Main Content ] start -->
        @yield('content')
        <!-- [ Main Content ] end -->
    </div>
    
    
</body>
</html>
