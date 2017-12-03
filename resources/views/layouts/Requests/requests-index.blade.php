@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            @if(auth()->user()->role === "user")
            <div class="row header">
                @include('layouts.requests.requests-header')
            </div>
            @endif
            <div class="row below-header">
                <div class="col-xs-12">
                @if(auth()->user()->role === "admin")
                    <requests
                    :admin="true"
                    ></requests>
                   {{--  @include('layouts.home.home-solicitudes-admin-box') --}}
                @else
                    <requests></requests>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
