<div id="requests-info-box">
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <h3 class="panel-title"><span class="glyphicon glyphicon-hand-up"></span>  Mis Solicitudes</h3>
    </div>
    <div class="panel-body">
      <a href="/requests/create">
        <button type="button" class="btn btn-sm btn-info btn-block">
          <h3>Nueva solicitud</h3>
        </button>
      </a>
      <form>
        <table class="table table-responsive" id="clinics-table">
          <thead>
            <tr>
              <th>Clínica</th>
              <th class="hidden-xs">Dir. Real</th>
              <th class="hidden-xs">Dir. Comercial</th>
              <th>CP</th>
              <th class="hidden-xs noWrap">Tel. Real</th>
              <th>Tel. Virtual</th>
              <th>Email Ext.</th>
              <th>Código S.</th>
              <th>Provincia</th>
              <th>CCAA</th>
              <th>País</th>
              <th class="buttons-text"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($clinics as $clinic)
            <tr>
              <td><input type="text" name="city" value="{{$clinic->city}}" disabled=""></td>
              <td class="hidden-xs">{{$clinic->address_real_1}} {{$clinic->address_real_2}}</td>
              <td class="hidden-xs">{{$clinic->address_adv_1}} {{$clinic->address_adv_2}}</td>
              <td>{{$clinic->postal_code}}</td>
              <td class="hidden-xs noWrap">{{$clinic->phone_real}}</td>
              <td class="noWrap">{{$clinic->phone_adv}}</td>
              <td>{{$clinic->email_ext}}</td>
              <td>{{$clinic->sanitary_code}}</td>
              <td>{{$clinic->provincia->nombre}}</td>
              <td>{{$clinic->provincia->state->name}}</td>
              <td>{{$clinic->provincia->state->country->name}}</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Editar
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>