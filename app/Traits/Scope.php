<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use App\Clinic;
use App\Order;

trait Scope {

    public static function clinicScoped($model, $orderBy=null) {
        $clinics = self::getScope();
        // $models = strtolower(str_plural($model));
        // $model = '\\App\\' . ucfirst(strtolower($model));
        $model = '\\App\\' . ucfirst($model);

        $items = $model::whereHas('clinic', function($query) use ($clinics) {
            $query->whereIn('id', $clinics);
        });

        if ($orderBy) {
            $items->orderBy($orderBy);
        }

        $items = $items->get();

        return $items;
    }
    public static function clinicsScoped($model, $orderBy=null) {
        $clinics = self::getScope();

        // $model = '\\App\\' . ucfirst(strtolower($model));
        $model = '\\App\\' . ucfirst($model);

        $items = $model::whereHas('clinics', function($query) use ($clinics) {
            $query->whereIn('clinic_id', $clinics);
        });

        if ($orderBy) {
            $items->orderBy($orderBy);
        }

        $items = $items->get();

        return $items;
    }

    public static function getScope() {
        $clinics = null;
        switch (true) {
            case request()->has('country_id') :
                $clinics = Clinic::cacheClinics();
                $clinics = $clinics->where('country_id', request('country_id'))->pluck('id')->toArray();
                break;
            case request()->has('state_id') :
                $clinics = Clinic::cacheClinics();
                $clinics = $clinics->where('state_id', request('state_id'))->pluck('id')->toArray();
                break;
            case request()->has('county_id') :
                $clinics = Clinic::cacheClinics();
                $clinics = $clinics->where('county_id', request('county_id'))->pluck('id')->toArray();
                break;
            case request()->has('clinic_id') :
                $clinics = [request('clinic_id')];
                break;
        }
        if (!$clinics) {
            $clinics = session('clinicsScope');
        }
        return $clinics;
    }
}