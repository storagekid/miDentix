<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Clinic;
use App\ShoppingBag;
use Illuminate\Support\Facades\Mail;
use App\Mail\StationaryOrder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Clinic $clinic)
    {
        // $items = \App\ClinicStationary::find(request('items'));
        $items = \App\Stationary::find(request('items'));

        $shoppingBag = ShoppingBag::create();

        foreach($items as $item) {
            $provider = $item->providers[0]->provider_id;
            if (count($item->providers) > 1) {
                $top = 1;
                foreach ($item->providers as $tempProvider) {
                    // $level = $tempProvider->country_id + $tempProvider->state_id + $tempProvider->county_id + $tempProvider->clinic_id;
                    // if ($level > $top) {
                    //     $top = $level;
                    //     $provider = $tempProvider->provider_id;
                    // }
                    if ($tempProvider->clinic_id && $tempProvider->clinic_id == $clinic->id) {
                        $provider = $tempProvider->provider_id;
                        break;
                    } else if ($tempProvider->county_id && $tempProvider->county_id == $clinic->county_id) {
                        $top = 3;
                        $provider = $tempProvider->provider_id;
                    } else if ($tempProvider->state_id && $tempProvider->state_id == $clinic->county->state_id) {
                        if ($top < 2) {
                            $provider = $tempProvider->provider_id;                            
                        }
                    } else if ($tempProvider->country_id && $tempProvider->country_id == $clinic->country_id && !$tempProvider->county_id && !$tempProvider->state_id && !$tempProvider->clinic_id) {
                        $top = 1;
                        $provider = $tempProvider->provider_id;  
                    }
                }
            }
            // dd($item);
            $order = new Order;
            $order->shopping_bag_id = $shoppingBag->id;
            $order->user_id = auth()->id();
            $order->clinic_id = $clinic->id;
            $order->provider_id = $provider;
            $order->quantity = 500;
            $order->urgent = 0;
            // dd($order);

            // $orderItem = \App\Stationary::find($item->stationary_id)->fresh();
            // $orderItem->orders()->save($order);
            
            $item->orders()->save($order);
        }

        $groupOrders = $shoppingBag->orders->groupBy('provider_id');
        foreach ($groupOrders as $id => $stationaries) {
            $provider = \App\Provider::find($id);
            // dd($provider);
            Mail::to($provider->email)
                ->cc(Auth()->user()->email)
                ->send(new StationaryOrder($stationaries));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
