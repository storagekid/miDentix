@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.schedule.schedule-header')
    </div>
    <div class="row">
        <div class="col-xs-12">
            <schedule
            :clinics-src="{{$clinics}}"
            :counties-src="{{$counties}}"
            :states-src="{{$states}}"
            :clickable="true"
            ></schedule>
        </div>
    </div>
@endsection
