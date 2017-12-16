@extends('layouts.app')

@section('content')
  <div class="row">
    @include('layouts.profile.profile-header')
  </div>
  <div class="row">
    <div class="col-xs-12">
      @include('layouts.profile.profile-vue-box')
    </div>
  </div>
@endsection
