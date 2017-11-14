<div id="profile-info-box">
  <div class="panel panel-default panel-tabbed">
      <div class="panel-heading text-center">
        <h3 class="panel-title">
          <ul class="nav nav-tabs" role="tablist" id="profile-tabs">
            <li role="presentation" class="active">
              <a href="#profile-info" aria-controls="profile-info" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-user"></span>Datos Personales
              </a>
            </li>
            <li role="presentation">
              <a href="#profile-masters" aria-controls="profile-masters" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-education"></span>Masters
              </a>
            </li>
          </ul>
        </h3>
      </div>
      <div class="panel-body">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="profile-info">
            <div id="profile-box-picture">
              <div class="profile-pic-round text-center">
                <a href="/profile" class="thumbnail center-block">
                  <img src="/img/profile.jpg" alt="...">
                </a>
                <a href="#" id="image-change-button"><button class="btn btn-info">Cambiar Imagen</button></a>
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
                    <label for="name">Apellidos:</label>
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
                  <div class="form-group col-xs-6 col-sm-6 col-md-2">
                    <label for="name">Año de Licenciatura:</label>
                    <input type="text" class="form-control" value="2010"> 
                  </div>
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
                </form>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="profile-masters">
            Masters
          </div>
        </div>
        <div class="panel-footer">
          <div id="profile-info-footer">
            <h3><span class="glyphicon glyphicon-calendar"></span> Actualizado el: 27/10/2017</h3>
            <button type="button" class="btn btn-primary">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>