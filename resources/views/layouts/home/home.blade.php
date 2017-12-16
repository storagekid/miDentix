@extends('layouts.app')

@section('content')

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

@endsection
