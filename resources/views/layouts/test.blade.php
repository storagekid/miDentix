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
    <div class="fx fx-100 fx-col" style="height: 100vh">
        <div class="fx fx-100">
            <div id="main-content">
              @foreach($model as $clinicPoster)
              <p>{{ $clinicPoster }}</p>
              @endforeach
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <!-- <script src="{{ asset('js/functions.js') }}"></script> -->
</body>
</html>
