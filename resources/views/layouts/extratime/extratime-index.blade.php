@extends('layouts.app')

@section('content')
  @if(auth()->user()->role == 'user')
    <div class="row header">
      @include('layouts.profile.profile-header')
    </div>
  @endif
  <div class="row below-header">
    <div class="col-xs-12">
      <extra-time
      :admin="true"
      >  
      </extra-time>
    </div>
  </div>
@endsection