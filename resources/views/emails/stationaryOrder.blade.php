@component('mail::message')
# Nuevo pedido para la clínica de {{ $clinic->fullName }}:

<ul>
    @foreach($stationaries as $stationary)
        @if($stationary->profile)
            <li>{{ $stationary->orderable->description }} ({{ $stationary->profile->fullName }})</li>
        @elseif($stationary->details)
            <li>{{ $stationary->orderable->description }}  ({{ $stationary->details }})</li>
        @else
            <li>{{ $stationary->orderable->description }}</li>
        @endif
    @endforeach
</ul>
@if(count($buttons))
@foreach($buttons as $button => $ids)
@if($button == 'medicalCharts')
@component('mail::button', ['url' => action('ProfileController@downloadCharts', ['profiles' => $ids, 'clinic' => $clinic]), 'color' => 'red'])
Descargar Tiras
@endcomponent
@elseif($button == 'medicalChartJob')
@component('mail::button', ['url' => action('ProfileController@downloadJobCharts', ['jobs' => $ids]), 'color' => 'red'])
Descargar Especialidades
@endcomponent
@elseif($button == 'businessCards')
@component('mail::button', ['url' => action('ProfileController@downloadBusinessCard', ['profiles' => $ids, 'clinic' => $clinic]), 'color' => 'red'])
Descargar Tarjetas de Visita
@endcomponent
@elseif($button == 'stationaries')
@component('mail::button', ['url' => action('ShoppingBagController@download', ['shoppingBag' => $stationary->shopping_bag_id, 'provider' => $stationary->provider_id]), 'color' => 'red'])
Descargar Materiales
@endcomponent
@endif
@endforeach
@endif

Muchas gracias.<br>
Un saludo.<br>
<!-- {{ config('app.name') }} -->
@endcomponent
