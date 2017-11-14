<div id="requests-info-filters" style="margin-top: 20px;">
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <h3 class="panel-title"><span class="glyphicon glyphicon-filter"></span>  Filtros</h3>
    </div>
  </div>
{{--   @include('layouts.components.filters')
 --}}</div>
<div id="requests-info-box" style="margin-top: 20px;">
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Solicitudes</h3>
    </div>
    <div class="panel-body" id="admin-requests-table">
      <table class="table table-responsive">
        <thead>
          <tr>
            <th>
              Usuario
              <p>
                  <span class="glyphicon glyphicon-triangle-bottom"></span>
                  <span class="glyphicon glyphicon-filter"></span>
              </p>
            </th>
            <th>
              Clínica
              <p>
                  <span class="glyphicon glyphicon-triangle-bottom"></span>
                  <span class="glyphicon glyphicon-filter"></span>
              </p>
            </th>
            <th class="hidden-xs">
              Tipo
              <p>
                  <span class="glyphicon glyphicon-triangle-bottom"></span>
                  <span class="glyphicon glyphicon-filter"></span>
              </p>
            </th>
            <th class="hidden-xs">Detalle</th>
            <th>
              Fecha
              <p>
                  <span class="glyphicon glyphicon-triangle-bottom"></span>
                  <span class="glyphicon glyphicon-filter"></span>
              </p>
            </th>
            <th class="hidden-xs">Texto</th>
            <th>
              Estado
              <p>
                  <span class="glyphicon glyphicon-triangle-bottom"></span>
                  <span class="glyphicon glyphicon-filter"></span>
              </p>
            </th>
            <th class="buttons-text"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Juan Gabriel Villalba</th>
            <td>Castelldefels (Av. Santa Maria, 11)</td>
            <td class="hidden-xs">Gestion de Clínica</td>
            <td class="hidden-xs">Auxiliares <br>Agendas <br>Materiales</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...
            </td>
            <td>
              <div class="label label-warning list-badget">Pendiente</div>
            </td>
            <td>
              <a href="/requests/1">
                <button type="button" class="btn btn-primary">
                  Detalles
                </button>
              </a>
            </td>
          </tr>
          <tr>
            <th>Diego Hernández</th>
            <td>Cambrils (de Pau Casals, 45)</td>
            <td class="hidden-xs">Materiales</td>
            <td class="hidden-xs">-</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...</td>
            <td>
              <div class="label label-success list-badget">Resuelta</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
          <tr>
            <th>Juan Gabriel Villalba</th>
            <td>Castelldefels (Av. Santa Maria, 11)</td>
            <td class="hidden-xs">Laboratorio:</td>
            <td class="hidden-xs"><br>ATRIDENT <br>LEDEZMA</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...
            </td>
            <td>
              <div class="label label-success list-badget">Resuelta</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
          <tr>
            <th>Alba Cruz</th>
            <td>Cambrils (de Pau Casals, 45)</td>
            <td class="hidden-xs">Materiales</td>
            <td class="hidden-xs">-</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...</td>
            <td>
              <div class="label label-success list-badget">Resuelta</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
          <tr>
            <th>Alba Cruz</th>
            <td>Castelldefels (Av. Santa Maria, 11)</td>
            <td class="hidden-xs">Auxiliares</td>
            <td class="hidden-xs">-</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...
            </td>
            <td>
              <div class="label label-warning list-badget">Pendiente</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
          <tr>
            <th>Diego Hernández</th>
            <td>Cambrils (de Pau Casals, 45)</td>
            <td class="hidden-xs">Materiales</td>
            <td class="hidden-xs">-</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...</td>
            <td>
              <div class="label label-success list-badget">Resuelta</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
          <tr>
            <th>Diego Hernández</th>
            <td>Castelldefels (Av. Santa Maria, 11)</td>
            <td class="hidden-xs">Auxiliares</td>
            <td class="hidden-xs">-</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...
            </td>
            <td>
              <div class="label label-success list-badget">Resuelta</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
          <tr>
            <th>Diego Hernández</th>
            <td>Cambrils (de Pau Casals, 45)</td>
            <td class="hidden-xs">Materiales</td>
            <td class="hidden-xs">-</td>
            <td>12/09/2017</td>
            <td class="hidden-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod...</td>
            <td>
              <div class="label label-success list-badget">Resuelta</div>
            </td>
            <td>
              <button type="button" class="btn btn-primary">
                Detalles
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="panel-footer">
      <div class="progress">
        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
          <span>75% Resueltas</span>
        </div>
      </div>
    </div>
  </div>
</div>