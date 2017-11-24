<div id="work-box">
  <div class="panel panel-default" id="clinic-times">
    <div class="panel-heading text-center">
      <a href="/schedule">
        <h3 class="panel-title"><span class="glyphicon glyphicon-time"></span> Mi Jornada de Trabajo</h3>
      </a>
    </div>
    <schedule
    :clinics-src="{{$clinics}}"
    :provincias-src="{{$provincias}}"
    :states-src="{{$states}}"
    :page="'home'"
    ></schedule>
  </div>
</div>