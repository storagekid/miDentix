<div id="schedule-info-box">
  <div class="panel panel-default panel-tabbed">
    <div class="panel-heading text-center">
      <h3 class="panel-title">
        <ul class="nav nav-tabs" role="tablist" id="profile-tabs">
          <li role="presentation" class="active">
            <a href="#profile-clinics" aria-controls="profile-clinics" role="tab" data-toggle="tab">
              <span class="glyphicon glyphicon-home"></span>Clínicas
            </a>
          </li>
          <li role="presentation">
            <a href="#schedule-extra-time" aria-controls="schedule-extra-time" role="tab" data-toggle="tab">
              <span class="glyphicon glyphicon-time"></span>Bolsa de Horas
            </a>
          </li>
        </ul>
      </h3>
    </div>
    <div class="panel-body">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="profile-clinics">
          <a href="/schedule/{{auth()->id()}}/create" class="btn-new text-center">
            <button type="button" class="btn btn-sm btn-info">
              <h3><span class="glyphicon glyphicon-plus-sign"></span>Añadir Clínica</h3>
            </button>
          </a>
          <ul class="list-group">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6">
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
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                <li class="list-group-item" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel-heading active" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="col-xs-8" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <span class="glyphicon glyphicon-triangle-bottom"></span>Castelldefels (Av. Santa Maria, 11)
                      </a>
                      <div class="clinic-hours col-xs-4">
                        <span class="badge">24 Horas</span>
                      </div>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      @include('layouts.components.schedule')
                    </div>
                  </div>
                </li>
              </div>
            </div>
          </ul>
        </div>
        <div role="tabpanel" class="tab-pane" id="schedule-extra-time">
          <div class="schedule-table">
            <a href="/schedule/{{auth()->id()}}/extratime/create" class="text-center" style="display: inherit;">
              <button type="button" class="btn btn-sm btn-info">
                <h3><span class="glyphicon glyphicon-plus-sign"></span>Nueva solicitud</h3>
              </button>
            </a>
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th>Provincia</th>
                  <th>Clínica</th>
                  <th class="hidden-xs">Fecha</th>
                  <th>Detalles</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Barcelona</td>
                  <td>Castelldefels (Av. Santa Maria, 11)</td>
                  <td class="hidden-xs">25/11/2017</td>
                  <td>
                    M: 18:00 - 20:00 <br>
                    X: 18:00 - 20:00 <br>
                    S: 9:00 - 15:00
                  </td>
                  <td>
                    <div class="label label-danger list-badget">
                      <span class="hidden-xs">Denegada</span>
                      <span class="glyphicon glyphicon-remove-sign visible-xs-block"></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    Barcelona <br>
                    Tarragona <br>
                    Castellón
                  </td>
                  <td>Indiferente</td>
                  <td class="hidden-xs">12/09/2017</td>
                  <td>
                    L: 14:00 - 18:00 <br>
                    X: 14:00 - 18:00
                  </td>
                  <td>
                    <div class="label label-warning list-badget">
                      <span class="hidden-xs">Pendiente</span>
                      <span class="glyphicon glyphicon-question-sign visible-xs-block"></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Indiferente</td>
                  <td>Indiferente</td>
                  <td class="hidden-xs">27/08/2017</td>
                  <td>
                    L: 10:00 - 14:00 <br>
                    X: 10:00 - 14:00
                  </td>
                  <td>
                    <div class="label label-success list-badget">
                      <span class="hidden-xs">Aceptada</span>
                      <span class="glyphicon glyphicon-ok-sign visible-xs-block"></span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
{{--           <form id="new-request-form">
            <div class="form-group">
              <label for="clinic_id">Clínica</label>
              <select class="form-control" id="clinic_id" name="clinic_id">
                <option disabled="" selected>Selecciona una clínica</option>
                  <option>Torrelavega (Julián Ceballos, 15)</option>
                  <option>Torrelavega (Serafín Escalante, 1)</option>
                  <option>Torremolinos (San Miguel, 2)</option>
                  <option>Torrent (Av. del Vedat, 101)</option>
                  <option>Torrevieja (María Parodi, 21)</option>
                  <option>Tudela (Pl. Nueva, 1)</option>
                  <option>Úbeda (Pl. de Andalucía, 14)</option>
                  <option>Utrera (La Fuente Vieja, 22 )</option>
                  <option>Valencia (de Sant Vicent Màrtir, 55)</option>
                  <option>Valencia (del Pintor Sorolla, 35)</option>
              </select>
            </div>
              @include('layouts.components.schedule')
            <button type="submit" class="btn btn-primary btn-block"><h4>Nueva Solicitud</h4></button>
          </form> --}}
        </div>
      </div>
      <div class="panel-footer">
        <div id="profile-info-footer">
          <h3>
            <span class="glyphicon glyphicon-time"></span> Total: 48 horas
          </h3>
          <button type="button" class="btn btn-primary">Actualizar</button>
        </div>
      </div>
    </div>
  </div>
</div>