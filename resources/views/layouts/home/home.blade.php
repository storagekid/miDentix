@extends('layouts.app')

@section('content')

@if(auth()->user()->role === "user")
<div class="row">
    @include('layouts.home.home-header')
</div>
@endif
<div class="row">
	@if(in_array("Dentists", auth()->user()->group()->pluck('name')->toArray()))
		@if(auth()->user()->role === "admin")
        	@include('layouts.home.home-admin-dentists-box')
        @elseif(auth()->user()->role === "user")
        	@include('layouts.home.home-user-box')
        @endif
    @elseif(auth()->user()->role === "root")
    	@include('layouts.home.home-admin-box')
    @endif
</div>

@endsection
