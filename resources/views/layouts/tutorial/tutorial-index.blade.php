@extends('layouts.app-tutorial')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" id="main-content">
            <div class="row">
                @include('layouts.tutorial.tutorial-header')
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                    <tutorial></tutorial>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
