<table>
    <thead>
    <tr>
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">Clínica</th>
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">Modelo</th>
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">Tamaño</th>
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">Tipo</th>
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">Cantidad (CARAS)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($posters as $clinicId => $priorities)
      @foreach($priorities as $priority => $sizes)
        @foreach($sizes as $size => $types)
          @foreach($types as $type => $layers)
            <tr>
              <td style="font-size: 12px">{{ $layers[0]['clinic_poster']['clinic']['nickname'] ? $layers[0]['clinic_poster']['clinic']['nickname'] : $clinicId }}</td>
              <td style="font-size: 12px">
                @switch($priority)
                    @case(1)
                        {{ 'Revisiones' }}
                        @break
                    @case(2)
                        {{ 'Implantología' }}
                        @break
                    @case(3)
                        {{ 'Financiación' }}
                        @break
                    @case(4)
                        {{ 'Ortodoncia' }}
                        @break
                    @case(5)
                        {{ 'Ventajas' }}
                        @break
                    @default
                      {{ $priority }}
                @endswitch
              </td>
              <td style="font-size: 12px">{{ $size }}</td>
              <td style="font-size: 12px">
                @switch($type)
                  @case('Normal')
                      {{ 'Normal' }}
                      @break
                  @case('Office')
                      {{ 'Gabinete' }}
                      @break
                  @case('Office Int')
                      {{ 'Interior GAB' }}
                      @break
                  @default
                    {{ $type }}
                @endswitch
              </td>
              <td style="font-size: 12px">{{ count($layers) }}</td>
            </tr>
          @endforeach
        @endforeach
      @endforeach
    @endforeach
    </tbody>
</table>