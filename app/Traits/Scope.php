<?php

namespace App\Traits;

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

    public static function fetch($options = []) {

        $options = self::filterOptions($options);
        // dd($options);
        if (request()->has('store_id')) $models = self::storesScoped();
        else if (request()->has('clinic_id')) $models = self::clinicsScoped();
        else {
            $modelName = '\\' . static::class;
            if (array_key_exists('withTrashed', $options)) $models = $modelName::withTrashed();
            else $models = $modelName::select();
        }
        if (array_key_exists('withCount', $options)) $models = $models->withCount($options['withCount']);
        if (array_key_exists('full', $options)) $models->with(static::$full);
        else if (array_key_exists('with', $options)) $models->with($options['with']);
        if (array_key_exists('orderBy', $options)) $models = $models->orderBy($options['orderBy'], request()->has('orderDesc') ? 'desc' : 'asc');
        if (array_key_exists('ids', $options)) $models = $models->find($options['ids']);
        else $models = $models->get();

        if (array_key_exists('appends', $options)) $models->each(function ($i) use ($options) { $i->append($options['appends']); });
        return $models;
    }

    public static function filterOptions($options) {
        if (!request()->has('options')) return $options;
        $requestOptions = collect(json_decode(request('options'), true));
        if($requestOptions->has('full')) $options['full'] = is_array($requestOptions['full']) ? $requestOptions['full'] : json_decode($requestOptions['full']);
        if($requestOptions->has('with')) $options['with'] = is_array($requestOptions['with']) ? $requestOptions['with'] : json_decode($requestOptions['with']);
        if($requestOptions->has('withTrashed')) $options['withTrashed'] = is_array($requestOptions['withTrashed']) ? $requestOptions['withTrashed'] : json_decode($requestOptions['withTrashed']);
        if($requestOptions->has('withCount')) $options['withCount'] = is_array($requestOptions['withCount']) ? $requestOptions['withCount'] : json_decode($requestOptions['withCount']);
        if($requestOptions->has('appends')) $options['appends'] = is_array($requestOptions['appends']) ? $requestOptions['appends'] : json_decode($requestOptions['appends']);
        if($requestOptions->has('orderBy')) $options['orderBy'] = $requestOptions['orderBy'];
        if($requestOptions->has('ids')) $options['ids'] = is_array($requestOptions['ids']) ? $requestOptions['ids'] : json_decode($requestOptions['ids']);
        return $options;
    }

    public static function clinicsScoped() {
        $clinics = self::getScope();
        $model = '\\' . static::class;
        $method = method_exists($model, 'clinics') ? 'clinics' : 'clinic';
        
        $items = $model::whereHas($method, function($query) use ($clinics) {
            $query->whereIn('clinic_id', $clinics);
        });

        return $items;
    }

    public static function storesScoped() {
        $clinics = self::getScope();
        $model = '\\' . static::class;

        $items = $model::whereHas(count($clinics) === 1 ? 'store' : 'stores', function($query) use ($clinics) {
            $query->whereIn('store_id', $clinics);
        });

        return $items;
    }

    public static function getScope() {
        $clinics = null;
        switch (true) {
            case request()->has('country_id') :
                $clinics = $clinics->where('country_id', request('country_id'))->pluck('id')->toArray();
                break;
            case request()->has('state_id') :
                $clinics = $clinics->where('state_id', request('state_id'))->pluck('id')->toArray();
                break;
            case request()->has('county_id') :
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