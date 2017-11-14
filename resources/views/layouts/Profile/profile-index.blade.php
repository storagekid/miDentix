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
              <div class="col-xs-12 col-sm-12 col-md-6">
                @include('layouts.profile.personal-info-box')
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                @include('layouts.profile.profile-masters-box')
                @include('layouts.profile.profile-clinics-box')
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
