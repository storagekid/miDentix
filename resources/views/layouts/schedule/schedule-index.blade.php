@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            <div class="row">
                @include('layouts.schedule.schedule-header')
            </div>
            <div class="row">
              <div class="col-xs-12">
                <schedule
                {{-- :profile-src="{{$profile}}"  --}}
                :clinics-src="{{$clinics}}"
                :provincias-src="{{$provincias}}"
                :states-src="{{$states}}"
                ></schedule>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
