@extends('layouts.app')

@section('content')
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
            @else
            <requests></requests>
            @endif
        </div>
    </div>
@endsection
