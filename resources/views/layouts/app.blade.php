<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'miDentix') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Scripts --}}
    <script>
        // $page = window.getPage();
        getPage = function() {
            let str = window.location.pathname.substring(1);
            let index = str.indexOf('/',2);
            if (index != -1) {
                str = str.substring(1,index);
            } 
            return str;
        }
        let auth = "<?php echo auth()->check(); ?>"      
        if (auth != '') {
            let role = {!! json_encode(auth()->user()->role) !!};
            let groups = {!! json_encode(auth()->user()->group()->pluck('name')) !!};
            window.App = {!! json_encode([
                'role' => '',
            ]) !!};
            window.App.role = role;
            window.App.group = groups;
            window.App.page = getPage();
        }
    </script>
</head>
<body>
    <div id="app">
        @if(auth()->check())
        @include('nav.main')
        @endif
        <div class="container-fluid">
            @include('nav.left')
            <div class="row">
                <div class="'col-xs-12" id="main-content">
                    <loading></loading>
                    @yield('content')
                </div>
            </div>
        </div>
        <flash message="{{ session('flash') }}"></flash>
        @if (session('status'))
        <flash message="{{ session('status') }}"></flash>
        @endif
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    {{-- <script src="{{ asset('js/charts.js') }}"></script> --}}
</body>
</html>
