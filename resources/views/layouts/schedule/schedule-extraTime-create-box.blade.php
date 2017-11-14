<div class="col-xs-12 col-sm-10 col-sm-offset-1">
  <div id="schedule-create-box">
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Ampliación de Horario</h3>
        </div>
        <div class="panel-body panel-form">
          <form id="new-request-form">
            <div class="form-group">
              <label for="clinic_id">Lugar de ampliación</label>
              <select class="form-control" id="clinic_id" name="clinic_id">
                <option disabled="">Selecciona un destino</option>
                  <option>Castelldefels (Av. Santa Maria, 11</option>
                  <option>Cambrils (de Pau Casals, 45)</option>
                  <option selected="">Nuevo</option>
              </select>
            </div>
            <div class="row">
              <div class="col-xs-6 col-sm-4">
                <div class="form-group">
                  <label for="clinic_id">CCAA</label>
                  <select class="form-control" id="clinic_id" name="clinic_id" multiple="">
                      <option>Cualquiera</option>
                      <option>Madrid</option>
                      <option>Cataluña</option>
                      <option>Castilla y León</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-4">
                <div class="form-group">
                  <label for="clinic_id">Provincia</label>
                  <select class="form-control" id="clinic_id" name="clinic_id" multiple="">
                      <option>Cualquiera</option>
                      <option>Madrid</option>
                      <option>Barcelona</option>
                      <option>León</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label for="clinic_id">Clínica</label>
                  <select class="form-control" id="clinic_id" name="clinic_id" multiple="">
                      <option>Cualquiera</option>
                      <option>Terrassa (Rbla. d’Ègara, 162, cant. d’Iscle Soler, 30)</option>
                      <option>Teruel (Ramón y Cajal, 14)</option>
                      <option>Tomelloso (Don Víctor Peñasco, 41)</option>
                  </select>
                </div>
              </div>
            </div>
              @include('layouts.components.schedule')
            <button type="submit" class="btn btn-primary btn-block"><h4>Solicitar</h4></button>
          </form>
        </div>
      </div>
  </div>
</div>