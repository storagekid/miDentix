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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">

</head>
<body>
    <div id="app">
        @include('nav.main')
        <div class="container-fluid">
            <nav-left :menu="{{auth()->user()->getMenu('gabinete', [session('user.group.0.name')], session('user.role') )}}"></nav-left>
            <div class="row">
                <div id="main-content">
                    <!-- <loading></loading> -->
                    <!-- <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut"> -->
                        <loading v-if="!$store.getters.ready"></loading>
                        <router-view v-else></router-view>
                    <!-- </transition> -->
                    <!-- @yield('content') -->
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
</body>
</html>
