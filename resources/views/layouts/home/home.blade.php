@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            @if(auth()->user()->role === "user")
            <div class="row">
                @include('layouts.home.home-header')
            </div>
            @endif
            <div class="row">
                @if(auth()->user()->role === "admin")
                    @include('layouts.home.home-admin-box')
                @else
                    @include('layouts.home.home-user-box')
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
