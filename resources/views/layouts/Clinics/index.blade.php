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
                    <clinics-table :data="{{$clinics}}" :provincias-src="{{$provincias}}"></clinics-table>
                    {{-- @include('layouts.clinics.clinics-table-box') --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
