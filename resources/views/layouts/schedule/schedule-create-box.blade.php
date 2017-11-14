<div class="col-xs-12 col-sm-10 col-sm-offset-1">
  <div id="schedule-create-box">
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>Nueva Clínica</h3>
        </div>
        <div class="panel-body panel-form">
          <form id="new-request-form">
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
            <button type="submit" class="btn btn-primary btn-block"><h4>Añadir</h4></button>
          </form>
        </div>
      </div>
  </div>
</div>