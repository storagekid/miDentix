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
        $shoppingBag = ShoppingBag::create();

        if (request()->has('items.stationaries')) {
            if (request()->has('items.stationaries.ids')) {
                $items = \App\Stationary::find(request('items')['stationaries']['ids']);

                foreach($items as $item) {
                    $provider = $this->findBestProvider($item);
                    $order = $this->createOrder($shoppingBag, $clinic, $provider);
                    
                    $item->orders()->save($order);
                }
            }
        }

        if (request()->has('items.medicalCharts')) {
            if (request()->has('items.medicalCharts.ids')) {
                $item = \App\Stationary::where('name','medicalChart')->first();
                $profiles = request('items')['medicalCharts']['ids'];
                $provider = $this->findBestProvider($item);

                foreach ($profiles as $profile) {
                    $order = $this->createOrder($shoppingBag, $clinic, $provider, $profile);
                    $item->orders()->save($order);
                }
            }
        }

        if (request()->has('items.medicalChartJobs')) {
            if (request()->has('items.medicalChartJobs.ids')) {
                $item = \App\Stationary::where('name','medicalChartJob')->first();
                $jobs = \App\JobType::find(request('items')['medicalChartJobs']['ids']);
                $provider = $this->findBestProvider($item);
                foreach ($jobs as $job) {
                    $order = $this->createOrder($shoppingBag, $clinic, $provider, null, null, $job->name);
                    $item->orders()->save($order);
                }
            }
        }

        if (request()->has('items.businessCards')) {
            if (request()->has('items.businessCards.ids')) {
                $item = \App\Stationary::where('name','businessCard')->first();
                $profiles = request('items')['businessCards']['ids'];
                $provider = $this->findBestProvider($item);

                foreach ($profiles as $profile) {
                    $order = $this->createOrder($shoppingBag, $clinic, $provider, $profile);
                    $item->orders()->save($order);
                }
            }
        }
        
        $groupOrders = $shoppingBag->orders->groupBy('provider_id');
        foreach ($groupOrders as $id => $stationaries) {
            $provider = \App\Provider::find($id);
            // dd($provider);
            Mail::to($provider->email)
                ->cc(Auth()->user()->email)
                ->send(new StationaryOrder($stationaries));
        }
        return response([
            'newmodel' => $shoppingBag->orders,
            ], 200);
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

    public function findBestProvider($item) {
        $provider = $item->providers[0]->provider_id;
        if (count($item->providers) > 1) {
            $top = 1;
            foreach ($item->providers as $tempProvider) {
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
        return $provider;
    }

    public function createOrder($shoppingBag, $clinic, $provider, $profile=null, $item=null, $details=null) {
        $order = new Order;
        $order->shopping_bag_id = $shoppingBag->id;
        $order->user_id = auth()->id();
        $order->clinic_id = $clinic->id;
        $order->provider_id = $provider;
        $order->profile_id = $profile;
        $order->details = $details;
        $order->quantity = 500;
        $order->urgent = 0;

        return $order;
    }
}
