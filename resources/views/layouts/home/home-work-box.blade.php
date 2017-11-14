<div id="work-box">
  <div class="panel panel-default" id="clinic-times">
    <div class="panel-heading text-center">
      <a href="/schedule">
        <h3 class="panel-title"><span class="glyphicon glyphicon-time"></span> Mi Jornada de Trabajo</h3>
      </a>
    </div>
    <div class="panel-body">
      <ul class="list-group">
        <li class="list-group-item" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel-heading active" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a class="col-xs-8" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <span class="glyphicon glyphicon-triangle-bottom"></span>Castelldefels (Av. Santa Maria, 11)
              </a>
              <div class="clinic-hours col-xs-4">
                <span class="badge">24 Horas</span>
              </div>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
              @include('layouts.components.schedule')
            </div>
          </div>
        </li>
      </ul>
      <ul class="list-group">
        <li class="list-group-item" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
              <a class="col-xs-8" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <span class="glyphicon glyphicon-triangle-right"></span>Cambrils (de Pau Casals, 45)
              </a>
              <div class="clinic-hours col-xs-4">
                <span class="badge">16 Horas</span>
              </div>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
              @include('layouts.components.schedule')
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="panel-footer">
      <div id="clinic-total-hours">
      <h3><span class="glyphicon glyphicon-home"></span> 2 Clínicas</h3>
      <span class="badge"><span class="glyphicon glyphicon-time"></span> 40 horas</span>
      </div>
    </div>
  </div>
</div>