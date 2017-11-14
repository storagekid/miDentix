@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
            <div class="row">
              @include('layouts.profile.profile-header')
            </div>
            <div class="row">
              <div class="col-xs-12">
                @include('layouts.profile.profile-index-box')
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
