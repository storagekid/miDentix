<?php

namespace App\Traits;

use App\Clinic;

trait Scope {
    public function attachFull() {
        return $this->load(static::$full);
    }

    public static function getFullModels() {
        return static::$full;
    }

    public function getView($view=null) {
        $view = $this->getShowView($view);
        if (array_key_exists('with', $view)) $this->getShowRelations($view);
        if (array_key_exists('append', $view))$this->appendShowRelations($view);
        return $this;
    }

    public function getShowRelations($view=null) {
        return $this->load($view['with']);
    }

    public function appendShowRelations($view=null) {
        return $this->append($view['append']);
    }

    public static function fetch($model=null, $orderBy=null, $with=null, $withTrashed=false, $ids=null) {
        // if (!$model) $model = get_called_class();
        if(request()->has('with')) $with = request('with');
        if(request()->has('orderBy')) $orderBy = request('orderBy');
        if (request()->has('store_id')) {
            $models = self::storesScoped($model, $orderBy);
        } else if (request()->has('clinic_id')){
            $models = self::clinicsScoped($model, $orderBy);
        } else {
            $modelName = '\\' . static::class;
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
            if (request()->has('ids')) $models = $models->find(request('ids'));
            else if ($ids) $models = $models->find($ids);
            else $models = $models->get();
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
        $model = '\\' . static::class;
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
        $model = '\\' . static::class;

        $items = $model::whereHas('clinics', function($query) use ($clinics) {
            $query->whereIn('clinic_id', $clinics);
        });

        if ($orderBy) {
            $items->orderBy($orderBy);
        }
        
        $items = $items->get();
        return $items;
    }

    public static function storesScoped($model, $orderBy=null, $with=null) {
        $clinics = self::getScope();
        $model = '\\' . static::class;

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