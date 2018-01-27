<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/excel-tables.css') }}">
</head>
<body>
  <table cellpadding="5">
    <thead>
      <tr></tr>
      <tr>
        <th class="margin"></th>
        <th class="header">Nombre</th>
        <th class="header">Email</th>
        <th class="header">Teléfono</th>
        <th class="header">Especialidades</th>
        <th class="header">Nº Solicitudes</th>
        <th class="header">Nº Clínicas</th>
        <th class="header">Clínicas</th>
        <th class="header">Año de Licencia</th>
        <th class="header">Centro de Licencia</th>
        <th class="header">Nº de Licencia</th>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $item)
      <tr>
        <td class="margin"></td>
        <td class="data">{{$item->lastname1}} {{$item->lastname2}}, {{$item->name}}</td>
        <td class="data">{{$item->email}}</td>
        <td class="data">{{$item->phone}}</td>
        @if($item->especialties())
          <td class="data">
            @foreach($item->especialties() as $especialty)
            {{$especialty->name}}, 
            @endforeach
          </td>
        @else
          <td class="data">-</td>
        @endif
        <td class="data">{{$item->requestsCount}}</td>
        <td class="data">{{$item->clinicsCount}}</td>
        @if($item->clinics)
          <td class="data">
            @foreach($item->clinics as $clinic)
            {{$clinic->city}}, 
            @endforeach
          </td>
        @else
          <td class="data">-</td>
        @endif
        <td class="data">{{$item->license_year}}</td>
        @if($item->university)
          <td class="data">
            {{$item->university->name}} 
          </td>
        @elseif($item->university_id === 0)
          <td class="data">
            Otro 
          </td>
        @else
          <td class="data">-</td>
        @endif
        <td class="data">{{$item->license_number}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
