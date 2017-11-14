<div id="profile-info-box" style="margin-top: 30px">
  <div class="panel panel-default panel-tabbed">
    <div class="panel-heading text-center">
      <h3 class="panel-title">
        <ul class="nav nav-tabs" role="tablist" id="profile-tabs">
          <li role="presentation" class="active">
            <a href="#profile-info" aria-controls="profile-info" role="tab" data-toggle="tab">
              <span class="glyphicon glyphicon-user"></span>Usuario
            </a>
          </li>
          <li role="presentation">
            <a href="#profile-masters" aria-controls="profile-masters" role="tab" data-toggle="tab">
              <span class="glyphicon glyphicon-bullhorn"></span>Solicitud
            </a>
          </li>
        </ul>
      </h3>
    </div>
    <div class="panel-body">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="profile-info">
          <div id="profile-box-picture" style="width: 20%">
            <div class="profile-pic-round text-center">
              <a href="/profile" class="thumbnail center-block">
                <img src="/img/profile.jpg" alt="...">
              </a>
            </div>
          </div>
          <div id="profile-box-table">
            <form id="profile-create-form">
              <div class="row">
                <div class="form-group col-xs-12 col-sm-6">
                  <label for="name">Nombre:</label>
                  <input type="text" class="form-control" value="Isabel">
                </div>
                <div class="form-group col-xs-12 col-sm-6">
                  <label for="name">Clínica:</label>
                  <input type="text" class="form-control" value="Castaño">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                  <label for="name">Correo Electrónico:</label>
                  <input type="email" class="form-control" value="icastano@dentix.es">
                </div>
                <div class="form-group col-xs-6 col-sm-6 col-md-4">
                  <label for="name">Teléfono:</label>
                  <input type="text" class="form-control" value="+34 665 926 083">
                </div>
                @if(auth()->user()->role === "user")
                <div class="form-group col-xs-6 col-sm-6 col-md-2">
                  <label for="name">Año de Licenciatura:</label>
                  <input type="text" class="form-control" value="2010"> 
                </div>
                @endif
              </div>
              <div class="row">
                <div class="form-group col-xs-12 col-sm-6">
                  <label for="name">Experiencia profesional: <br>(selecciona todas las que procedan)</label>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="" checked="">
                      Endodoncia
                    </label>
                    <label>
                      <input type="checkbox" value="" checked="">
                      Ortodoncia
                    </label>
                    <label>
                      <input type="checkbox" value="">
                      Cirugía
                    </label>
                    <label>
                      <input type="checkbox" value="">
                      Director Médico
                    </label>
                    <label>
                      <input type="checkbox" value="">
                      General
                    </label>
                    <label>
                      <input type="checkbox" value="" checked="">
                      PSI
                    </label>
                  </div>
                </div>
                <div class="form-group col-xs-12 col-sm-6">
                  <label for="name">Experiencia profesional: <br>(selecciona todas las que procedan)</label>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="" checked="">
                      Cadena Dental
                    </label>
                    <label>
                      <input type="checkbox" value="" checked="">
                      Aseguradora
                    </label>
                    <label>
                      <input type="checkbox" value="">
                      Clínica Privada
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile-masters">
          <div class="row">
            <div class="col-xs-12">
              <form id="new-request-form">
                <div class="form-group">
                  <label for="clinic_id">Clínica</label>
                  <select class="form-control" id="clinic_id" name="clinic_id" disabled="">
                    <option disabled="" selected>Castelldefels (Av. Santa Maria, 11)</option>
                  </select>
                </div>
                <div class="row">
                  <div class="form-group col-xs-12">
                    <label for="name">Tipo de Solicitud</label>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="" checked="" disabled="">
                        Gestión de clínica
                      </label>
                      <label>
                        <input type="checkbox" value="" disabled="">
                        Relaciones equipo médico
                      </label>
                      <label>
                        <input type="checkbox" value="" disabled="">
                        Relaciones equipo gestión
                      </label>
                      <label>
                        <input type="checkbox" value="" disabled="">
                        Nóminas
                      </label>
                      <label>
                        <input type="checkbox" value="" checked="" disabled="">
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
                        <input type="checkbox" value="" checked=""  disabled="">
                        Agendas
                      </label>
                      <label>
                        <input type="checkbox" value="" disabled="">
                        Auxiliares
                      </label>
                      <label>
                        <input type="checkbox" value="" disabled="">
                        Materiales
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="request_type">Indícanos el laboratorio</label>
                      <select class="form-control" id="request_type" name="request_type" multiple disabled="">
                        <option>ANGEL LORENZO CHISCANO</option>
                        <option selected="">ATRIDENT</option>
                        <option>IMASDENT</option>
                        <option selected="">INSTITUTO DENTAL DE MURCIA</option>
                        <option >KORFU</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="request_text">Explícanos en detalle (Máximo 500 caracteres)</label>
                  <textarea name="request_text" rows="3" maxlength="500" placeholder="" class="form-control">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia nisi error, est debitis sit illum ipsa cum, repellat unde sapiente, dolor dolorum et soluta dolore! Ad at corrupti recusandae nihil?
                  </textarea>
                </div>
              </form>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-8">
            </div>
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <div id="profile-info-footer">
          <h3>
            <span class="glyphicon glyphicon-calendar"></span> Enviada el: 27/10/2017
          </h3>
          <button type="button" class="btn btn-primary" style="width: auto">Marcar como Resuelta</button>
        </div>
      </div>
    </div>
  </div>
</div>