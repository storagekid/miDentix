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
<table cellpadding="5">
    <tbody>
      <tr>
        <td style="text-align: center">
          <h2>Cartelería: {{ $design->clinic->fullname }}</h2>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; color: grey; font-size: 16px; font-weight: bold">
          Fachada: {{ $design->address->address_line_1 }} @if(isset($pages)) <span style="color: darkgreen;">({{ $round }}/{{ $pages }}) </span>@endif
        </td>
      </tr>
      <tr>
        <td style="text-align: center">
          <img src="{{ public_path('storage/' . urlencode($composed->url)) }}" alt="">
        </td>
      </tr>
      <tr>
        <td>
        <table id="list" cellpadding="5">
          <thead>
          <tr>
              <th width="20%" style="background-color:#873173; color:#FFFFFF; font-size: 16px">@if($hasFoam) Hueco @else Soporte @endif</th>
              <th width="40%" style="background-color:#873173; color:#FFFFFF; font-size: 16px">Cara Exterior</th>
              <th width="40%" style="background-color:#873173; color:#FFFFFF; font-size: 16px">Cara Interior</th>
          </tr>
          </thead>
          <tbody>
          @foreach($holders as $holder)
            <tr>
              <td class="first" valign="middle" style="vertical-align: middle">
                <span style="font-size: 20px; font-weight: bold; line-height: 75px">{{ $holder['name'] }}</span>
                @if($holder['ext'])
                  @if($holder['ext']['blur'])
                    <br><span style="font-size: 10px; font-weight: bold; color: darkgreen; line-height: 18px">Cristal vinilado</span>
                  @endif
                @elseif($holder['int'])
                  @if($holder['int']['blur'])
                    <br><span style="font-size: 10px; font-weight: bold; color: darkgreen; line-height: 18px">Cristal vinilado</span>
                  @endif
                @endif
              </td>
              <td>
                @if($holder['ext'])
                <img height="75" src="{{ asset('storage/' . $holder['ext']['image']) }}" alt="">
                @else
                <p>Sin Cartel</p>
                @endif
              </td>
              <td>
                @if($holder['int'])
                <img height="75" src="{{ asset('storage/' . $holder['int']['image']) }}" alt="">
                @else
                <p>Sin Cartel</p>
                @endif
              </td>
            </tr>
            <tr>
              <td class="footer">
                <span style="color: darkgrey; font-weight: bold;">Tamaño:</span> {{ $holder['size']}}
              </td>
              <td class="footer">
                @if($holder['ext'])
                  @if($holder['ext']['code'])
                    <span style="color: darkgrey; font-weight: bold;">Código:</span> {{ $holder['ext']['code'] }}
                  @elseif($design->clinic->sanitary_code)
                    <span style="color: darkgrey; font-weight: bold;">Código:</span> {{ $design->clinic->sanitary_code }}
                  @else
                    <span style="color: darkgrey; font-weight: bold;">Código: <span style="color: darkred">Aún no disponible</span></span>
                  @endif
                @else
                  Sin Cartel
                @endif
              </td>
              <td class="footer">
                @if($holder['int'])
                  @if($holder['int']['code'])
                    <span style="color: darkgrey; font-weight: bold;">Código:</span> {{ $holder['int']['code'] }}
                  @elseif($holder['ext'])
                    @if($holder['ext']['code'])
                      <span style="color: darkgrey; font-weight: bold;">Código:</span> {{ $holder['ext']['code'] }}
                    @elseif($design->clinic->sanitary_code)
                      <span style="color: darkgrey; font-weight: bold;">Código:</span> {{ $design->clinic->sanitary_code }}
                    @else
                      <span style="color: darkgrey; font-weight: bold;">Código: <span style="color: darkred">Aún no disponible</span></span>
                    @endif
                  @else
                    <span style="color: darkgrey; font-weight: bold;">Código: <span style="color: darkred">Aún no disponible</span></span>
                  @endif
                @else
                Sin Cartel
                @endif
              </td>
            </tr>
          @endforeach
      </table>
        </td>
      </tr>
  </tbody>
</table>
</body>