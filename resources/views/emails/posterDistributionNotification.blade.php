@component('mail::message')

# Hola a todos.
 
Adjunto os enviamos un documento especialmente diseñado para vuestra clínica sobre la cartelería de la nueva campaña, que deberéis colocar @if($postersDate) el próximo {{ $postersDate }}. @else tan pronto como la recibáis. @endif<br>

Por favor, seguid las indicaciones de este documento y si tenéis cualquier duda, escribid un email a  <a href="mailto:marketing@dentix.es">marketing@dentix.es</a>.

Atentamente.<br>
El equipo de Marketing.
@endcomponent
