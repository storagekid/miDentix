@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav.left')
        <div class="col-sm-10" id="main-content">
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
        </div>
    </div>
</div>
@endsection
