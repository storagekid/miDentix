@extends('layouts.app')

@section('content')
  @if(auth()->user()->role == 'user')
    <div class="row header">
      @include('layouts.profile.profile-header')
    </div>
  @endif
  <div class="row below-header">
    <div class="col-xs-12">
      <dentists2
      :admin="true"
      >  
      </dentists2>
    </div>
  </div>
@endsection
