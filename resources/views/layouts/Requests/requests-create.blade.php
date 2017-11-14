@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            <div class="row">
                @include('layouts.requests.requests-header')
            </div>
            <div class="row">
                <div class="col-xs-12">
                @include('layouts.requests.requests-create-box')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
