<div class="col-xs-12 col-sm-10 col-sm-offset-1">
  <div id="requests-create-box">
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Nueva Solicitud</h3>
        </div>
        <div class="panel-body panel-form">
          <form id="new-request-form">
            <div class="form-group">
              <label for="clinic_id">Clínica</label>
              <select class="form-control" id="clinic_id" name="clinic_id">
                <option disabled="" selected>Selecciona una de tus clínicas</option>
                <option>Castelldefels (Av. Santa Maria, 11)</option>
                <option>Cambrils (de Pau Casals, 45)</option>
              </select>
            </div>
            <div class="row">
              <div class="form-group col-xs-12">
                <label for="name">¿En qué te podemos ayudar: (selecciona todas las que procedan)</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="" checked="">
                    Gestión de clínica
                  </label>
                  <label>
                    <input type="checkbox" value="">
                    Relaciones equipo médico
                  </label>
                  <label>
                    <input type="checkbox" value="">
                    Relaciones equipo gestión
                  </label>
                  <label>
                    <input type="checkbox" value="">
                    Nóminas
                  </label>
                  <label>
                    <input type="checkbox" value="" checked="">
                    Laboratorio
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-xs-12 col-sm-6">
                <label for="name">Indícanos el tipo de gestión: <br>(selecciona todas las que procedan)</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="">
                    Agendas
                  </label>
                  <label>
                    <input type="checkbox" value="">
                    Auxiliares
                  </label>
                  <label>
                    <input type="checkbox" value="">
                    Materiales
                  </label>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="request_type">Indícanos el laboratorio</label>
                  <select class="form-control" id="request_type" name="request_type" multiple>
                    <option>ANGEL LORENZO CHISCANO</option>
                    <option >ATRIDENT</option>
                    <option>IMASDENT</option>
                    <option>INSTITUTO DENTAL DE MURCIA</option>
                    <option >KORFU</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="request_text">Explícanos en detalle (Máximo 500 caracteres)</label>
              <textarea name="request_text" rows="3" maxlength="500" placeholder="" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><h4>Enviar</h4></button>
          </form>
        </div>
      </div>
  </div>
</div>