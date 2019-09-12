<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use App\Clinic;
use App\Order;

trait Scope {
    public function attachFull() {
        return $this->load(static::$full);
    }

    public static function getFullModels() {
        return static::$full;
    }

    public function getShowRelations($view=null) {
        return $this->load($this->getShowView($view));
    }

    public static function fetch($model=null, $orderBy=null, $with=null, $withTrashed=false) {
        // if (!$model) $model = get_called_class();
        if(request()->has('with')) $with = request('with');
        if(request()->has('orderBy')) $orderBy = request('orderBy');
        if (request()->has('store_id')) {
            $models = self::storesScoped($model, $orderBy);
        } else if (request()->has('clinic_id')){
            $models = self::clinicsScoped($model, $orderBy);
        } else {
            $modelName = !$model ? get_called_class() : '\\App\\' . ucfirst($model);
            if (request()->has('withTrashed') || $withTrashed) {
                $models = $modelName::withTrashed();
            } else {
                $models = $modelName::select();
            }
            if (request()->has('withCount')) {
                $models = $models->withCount(request('withCount'));
            }
            if ($orderBy) {
                $models = $models->orderBy($orderBy, request()->has('orderDesc') ? 'desc' : 'asc');
            }
            $models = $models->get();
        }
        if (request()->has('full')) $models->load(static::$full);
        else if ($with) {
            if (is_array($with)) $models->load($with);
            else if (is_string($with) && $with === 'full') $models->load(static::$full);
        }
        if (request()->has('appends')) $models->each(function ($i) { $i->append(request('appends')); });
        return $models;
    }

    public static function clinicScoped($model, $orderBy=null) {
        $clinics = self::getScope();
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
    public static function clinicsScoped($model, $orderBy=null, $with=null) {
        $clinics = self::getScope();

        $model = '\\App\\' . ucfirst($model);

        $items = $model::whereHas('clinics', function($query) use ($clinics) {
            $query->whereIn('clinic_id', $clinics);
        });
        // if ($with) {
        //     foreach ($with as $item) {
        //         $items->with([$item => function($query) use ($clinics) {
        //             $query->whereIn('clinic_id', $clinics);
        //         }]);
        //     }
        // }

        if ($orderBy) {
            $items->orderBy($orderBy);
        }

        $items = $items->get();

        return $items;
    }

    public static function storesScoped($model, $orderBy=null, $with=null) {
        $clinics = self::getScope();
        // $model = '\\App\\' . ucfirst(strtolower($model));
        $model = '\\App\\' . ucfirst($model);

        $items = $model::whereHas('stores', function($query) use ($clinics) {
            $query->whereIn('store_id', $clinics);
        });
        if ($with) {
            foreach ($with as $item) {
                $items->with([$item => function($query) use ($clinics) {
                    $query->whereIn('store_id', $clinics);
                }]);
            }
        }

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
                if (is_array(request('clinic_id'))) {
                    $clinics = request('clinic_id');
                } else {
                    $clinics = [request('clinic_id')];
                }
                break;
            case request()->has('store_id') :
                $clinics = explode(',',request('store_id'));
                break;
        }
        if (!$clinics) {
            $clinics = session('clinicsScope');
        }
        return $clinics;
    }
}