@component('mail::message')
# Nuevo pedido para la clínica de {{ $clinic->fullName }}:

<ul>
    @foreach($stationaries as $stationary)
    <li>{{ $stationary->orderable->description }}</li>
    @endforeach
</ul>

@component('mail::button', ['url' => action('ShoppingBagController@download', ['shoppingBag' => $stationary->shopping_bag_id, 'provider' => $stationary->provider_id]), 'color' => 'red'])
Descargar Materiales
@endcomponent

Muchas gracias.<br>
Un saludo.<br>
{{ config('app.name') }}
@endcomponent
