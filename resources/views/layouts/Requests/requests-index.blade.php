@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            @if(auth()->user()->role === "user")
            <div class="row">
                @include('layouts.requests.requests-header')
            </div>
            @endif
            <div class="row">
                <div class="col-xs-12">
                @if(auth()->user()->role === "admin")
                    @include('layouts.home.home-solicitudes-admin-box')
                @else
                    <requests></requests>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
