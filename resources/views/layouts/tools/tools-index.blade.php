@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            <div class="row">
                @include('layouts.tutorial.tutorial-header')
            </div>
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    @include('layouts.tools.tools-box')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
