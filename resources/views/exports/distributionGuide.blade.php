<head>
  <style>
    .dest {
      font-weight: bold;
      color: #873173;
    }
    .email {
      color: darkblue;
      font-style: italic;
    }
  </style>
</head>
<body>
<table cellpadding="5" width="650" style="font-family: Helvetica, Arial, Verdana; font-size: 12px; color: #333333">
    <tbody>
      <tr>
        <td style="text-align: left">
          <p class="dest">Estimados compañeros de Dentix {{ $clinic->city }}:</p>
          <p>Este es un documento especialmente creado para vuestra clínica, con el que pretendemos ayudaros en la colocación de la nueva cartelería y en el que encontraréis:</p>
          <p><span class="dest">1. Dibujo fachada:</span><br>Cada fachada aparece en una hoja diferente, bajo el nombre exacto de la calle a la que pertenece.<br>
Sobre el dibujo de la fachada vienen indicados con un rectángulo morado cada uno de los @if($hasFoam) huecos @else soportes @endif para carteles que tenéis instalados en vuestra clínica y cada uno de estos rectángulos ha sido numerado (S-1, S-2, S-3…) para que podáis identificarlos con facilidad.
          </p>
          <p><span class="dest">2. Tabla explicativa:</span><br>Para cada uno de los @if($hasFoam) huecos @else soportes @endif numerados del dibujo encontraréis una línea en la tabla, donde se especifica:
            <ul>
              <li>Tamaño: debajo del nombre del @if($hasFoam) hueco @else soporte @endif aparece el tamaño del cartel que debes colocar en ese @if($hasFoam) hueco. @else soporte. @endif</li>
              <li>Cara visible: hemos indicado con imágenes qué cara debe verse en cada @if($hasFoam) hueco @else soporte @endif desde la calle (Cara Exterior) o desde el interior de la clínica (Cara Interior).</li>
              <li>Cristal vinilado: En caso de que tengáis cristales vinilados en la fachada, este tipo de @if($hasFoam) hueco @else soporte @endif irá marcado en la tabla con el indicador: “Cristal vinilado”.</li>
              <li>Código: El adhesivo que debe colocarse en cada cara de cada @if($hasFoam) cartel. @else soporte. @endif Recordad que es imprescindible que todos los @if($hasFoam) carteles @else soportes @endif lleven el código asignado y que esta es la colocación óptima de los adhesivos:</li>
            </ul>
            <img width="350" src="{{ $image }}" alt="" style="text-align: center">
          </p>
          <p><span class="dest">IMPORTANTE:</span> Comprueba que los carteles que has recibido en tu clínica coinciden exactamente con los @if($hasFoam) huecos @else soportes @endif que aparecen en el dibujo del dossier y las especificaciones correspondientes de la tabla y que, además, ambos coinciden con el número de @if($hasFoam) huecos @else soportes @endif reales que tú tienes en clínica.</p>
          <p class="dest">Si algo no cuadra: sobran o faltan, o tenéis alguna duda, escribid cuanto antes un email explicando las diferencias a <a href="mailto:marketing@dentix.es" class="email">marketing@dentix.es.</a></p>
          <br>
          <p>Muchas gracias por vuestra colaboración.</p>
        </td>
      </tr>
  </tbody>
</table>
</body>