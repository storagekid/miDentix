@component('mail::message')
# Esta es tu distribución de carteles para la nueva campaña: {{ $campaign['name'] }}:
<head>
  <style>
    img {
      border: 1px solid lightgrey;
    }
    table#list * {
      text-align: center;
    }
    table#list td {
      border-bottom: 1px solid #C398B9;
      text-align: center;
      vertical-align: middle;
    }
    table#list td.first {
      background-color: #F2EAF1;
      vertical-align: middle;
    }
    table#list td.footer {
      font-size: 10px;
      font-weight: bold;ç
      color: grey;
      border-bottom: 2px solid #873173;
    }
  </style>
</head>
<body>
@foreach($clinic['poster_distributions'] as $designIndex => $design)
<table cellpadding="5">
    <tbody>
      <tr>
        <td style="text-align: center">
          <h1>Cartelería: {{ $clinic->nickname }}</h1>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; color: grey">
          {{ $campaign ? 'Distribución para la campaña ' . $campaign['name'] : 'Distribución Genérica'}}
        </td>
      </tr>
      <tr>
        <td style="text-align: center; color: grey; font-size: 16px; font-weight: bold">
          Fachada: {{ $design['address']['address_line_1'] }}
        </td>
      </tr>
      <tr>
        <td style="text-align: center">
          <img src="{{ asset('storage/facades/' . $clinic->nickname . '/' . $design['address']['address_line_1'] . '-facade-with-holders.jpg') }}" alt="">
        </td>
      </tr>
      <tr>
        <td>
          <table id="list" cellpadding="5">
            <thead>
            <tr>
                <th width="20%" style="background-color:#873173; color:#FFFFFF; font-size: 16px">Soporte</th>
                <th width="40%" style="background-color:#873173; color:#FFFFFF; font-size: 16px">Cartel Exterior</th>
                <th width="40%" style="background-color:#873173; color:#FFFFFF; font-size: 16px">Cartel Interior</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clinic['poster_distributions'][$designIndex]['holders'] as $holder)
              <tr>
                <td class="first" valign="middle" style="vertical-align: middle; font-size: 20px; font-weight: bold; line-height: 75px">{{ $holder['name'] }}</td>
                @foreach($holder['ext'] as $campaignId => $poster)
                  @if ($campaign['id'] === $campaignId)
                  <td>
                    <img height="75" src="{{ asset('storage/' . $poster['image']) }}" alt="">
                  </td>
                  @endif
                @endforeach
                @foreach($holder['int'] as $campaignId => $poster)
                  @if ($campaign['id'] === $campaignId || $campaignId === '')
                  <td>
                    <img height="75" src="{{ asset('storage/' . $poster['image']) }}" alt="">
                  </td>
                  @endif
                @endforeach
              </tr>
              <tr>
                <td class="footer">
                  Tamaño: {{ $holder['size']}}
                </td>
                <td class="footer">
                  Código: {{ $design['clinic']['sanitary_code'] }}
                </td>
                <td class="footer">
                  Código: {{ $design['clinic']['sanitary_code'] }}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </td>
      </tr>
  </tbody>
</table>
@endforeach
</body>

Muchas gracias.<br>
Un saludo.<br>
<!-- {{ config('app.name') }} -->
@endcomponent
