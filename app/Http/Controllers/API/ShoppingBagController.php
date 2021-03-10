<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ShoppingBagController extends Controller
{
    public function placeOrder () {
        $shoppingBag = \App\ShoppingBag::create();
        foreach (request('shoppingCart') as $category) {
            foreach ($category['items'] as $item) {
                $order = \App\Order::make([
                    'shopping_bag_id' => $shoppingBag->id,
                    'user_id' => auth()->user()->id,
                    'clinic_id' => request('clinicId'),
                    'store_id' => request('storeId'),
                    'provider_id' => $item['provider']['provider']['id'],
                    'profile_ id' => $item['profileable'] ? $item['profile']['id'] : null,
                    'quantity' => $category['times'][$item['id']],
                    'priority' => 3,
                    'state' => 1
                ]);
                $orderable = \App\Product::find($item['id']);
                $orderable->orders()->save($order);
                $shoppingBag->orders()->save($order);
            }
        }
        return response([
            'model' => $shoppingBag->fresh()->orders()->with(\App\Order::getFullModels())->get()
        ], 200);
    }
}
