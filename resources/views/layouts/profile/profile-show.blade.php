@extends('layouts.app')

@section('content')
<div id="profile-info-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span>Datos personales</h3>
      </div>
      <div class="">
        <div id="profile-box-picture">
          <div class="profile-pic-round">
            <a href="/profile" class="thumbnail center-block">
              <img src="/img/profile.jpg" alt="...">
            </a>
          </div>
        </div>
        <div id="profile-box-table">
          <ul>
                <li class="list-group-item">
                  <div class="row">
                      <div class="col-xs-4">Nombre: </div>
                      <div class="col-xs-8"><strong>{{$profile->name}} {{$profile->lastname1}} {{$profile->lastname2}}</strong></div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                      <div class="col-xs-4">Correo Electrónico: </div>
                      <div class="col-xs-8"><a href="mailto:{{$profile->email}}"><strong>{{$profile->email}}</strong></a></div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                      <div class="col-xs-4">Teléfono: </div>
                      <div class="col-xs-8"><strong>{{$profile->phone}}</strong></div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                      <div class="col-xs-4">Especialidades: </div>
                      <div class="col-xs-8">
                        <strong>
                          @foreach($profile->especialties() as $especialty)
                            {{$especialty->name.", "}}
                          @endforeach
                        </strong>
                      </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                      <div class="col-xs-4">Año de licenciatura: </div>
                      <div class="col-xs-8"><strong>{{$profile->license_year}}</strong></div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                      <div class="col-xs-4">Experiencia Profesional: </div>
                      <div class="col-xs-8">
                        <strong>Cadena Dental</strong><br>
                        <strong>Aseguradora</strong>
                      </div>
                  </div>
                </li>
          </ul>
        </div>
      </div>
      <div class="panel-footer">
        <div id="profile-info-footer">
          <h3><span class="glyphicon glyphicon-calendar"></span> Actualizado el: 27/10/2017</h3>
          <a href="/profile/{{auth()->user()->id}}/create"><button type="button" class="btn btn-primary">Modificar</button></a>
        </div>
      </div>
    </div>
</div>
@endsection