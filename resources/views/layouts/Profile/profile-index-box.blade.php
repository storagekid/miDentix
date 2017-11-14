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
          @if(auth()->user()->role === "user")
          <li role="presentation">
            <a href="#profile-masters" aria-controls="profile-masters" role="tab" data-toggle="tab">
              <span class="glyphicon glyphicon-education"></span>Masters
            </a>
          </li>
          @endif
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
              <a href="#" id="image-change-button">
                <button class="btn btn-info">Cambiar Imagen</button>
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
                @if(auth()->user()->role === "user")
                <div class="form-group col-xs-6 col-sm-6 col-md-2">
                  <label for="name">Año de Licenciatura:</label>
                  <input type="text" class="form-control" value="2010"> 
                </div>
                @endif
              </div>
              @if(auth()->user()->role === "user")
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
              @endif
            </form>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile-masters">
          <div class="row">
            <div class="col-xs-12">
              <div class="table-container">
                <table class="table">
                  <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Universidad</th>
                        <th class="buttons"></th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Master Implantologia y Protesis</td>
                      <td>Universidad Católica de Valencia San Vicente Mártir</td>
                      <td>
                        <button class="btn btn-small btn-danger">
                          <span class="glyphicon glyphicon-remove"></span>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>Master Rehabilitación Protésica y Oclusal</td>
                      <td>Universidad de Oviedo</td>
                      <td>
                        <button class="btn btn-small btn-danger">
                          <span class="glyphicon glyphicon-remove"></span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-xs-12">
              <form action="">
                <div class="form-group col-xs-12 col-sm-5">
                  <label>Universidad</label>
                  <select class="form-control">
                    <option>Master Implantologia y Protesis</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Implantologia y Protesis</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Implantologia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Protesis</option>
                    <option>Especialista en implantoprotesis</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Rehabilitación Protésica y Oclusal</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Periodoncia e Implantología</option>
                    <option>Master Endodoncia</option>
                    <option>Master Implantologia Oral y Microcirugia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Prótesis, Implantoprótesis y Estética</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Implantologia</option>
                    <option>Master Rehabilitacion Oral y Estetica</option>
                    <option>Master Implantologia e Implantoprotesis</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Implantologia+Implantoprotesis</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Implantologia y Protesis</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Protesis</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Residencia Clinica en Protésis Bucal</option>
                  </select>
                </div>
                <div class="form-group col-xs-12 col-sm-5">
                  <label>Nombre</label>
                  <select class="form-control">
                    <option>Master Implantologia y Protesis</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Implantologia y Protesis</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Implantologia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Protesis</option>
                    <option>Especialista en implantoprotesis</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Rehabilitación Protésica y Oclusal</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Periodoncia e Implantología</option>
                    <option>Master Endodoncia</option>
                    <option>Master Implantologia Oral y Microcirugia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Prótesis, Implantoprótesis y Estética</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Implantologia</option>
                    <option>Master Rehabilitacion Oral y Estetica</option>
                    <option>Master Implantologia e Implantoprotesis</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Implantologia+Implantoprotesis</option>
                    <option>Master Cirugia Bucal / Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Implantologia y Protesis</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Master Endodoncia</option>
                    <option>Master Protesis</option>
                    <option>Master Endodoncia</option>
                    <option>Master Ortodoncia</option>
                    <option>Master Cirugia Oral e Implantologia</option>
                    <option>Residencia Clinica en Protésis Bucal</option>
                  </select>
                </div>
                <div class="form-group col-xs-12 col-sm-2">
                  <button class="btn btn-primary">Añadir Máster</button>
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
            <span class="glyphicon glyphicon-calendar"></span> Actualizado el: 27/10/2017
          </h3>
          <button type="button" class="btn btn-primary">Actualizar</button>
        </div>
      </div>
    </div>
  </div>
</div>