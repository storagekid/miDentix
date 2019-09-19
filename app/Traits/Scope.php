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

        if (request()->has('store_id')) $models = self::storesScoped();
        else if (request()->has('clinic_id')) $models = self::clinicsScoped();
        else {
            $modelName = '\\' . static::class;
            if (array_key_exists('withTrashed', $options)) $models = $modelName::withTrashed();
            else $models = $modelName::select();
        }
        if (array_key_exists('withCount', $options)) $models = $modelName::withCount($options['withCount']);
        if (request()->has('full')) $models->with(static::$full);
        else if (array_key_exists('with', $options)) $models->with($options['with']);
        if (array_key_exists('orderBy', $options)) $models = $models->orderBy($options['orderBy'], request()->has('orderDesc') ? 'desc' : 'asc');
        if (array_key_exists('ids', $options)) $models = $models->find($options['ids']);
        else $models = $models->get();

        if (array_key_exists('appends', $options)) $models->each(function ($i) use ($options) { $i->append($options['appends']); });
        return $models;
    }

    public static function filterOptions($options) {
        if(request()->has('with')) $options['with'] = is_array(request('with')) ? request('with') : json_decode(request('with'));
        if(request()->has('withTrashed')) $options['withTrashed'] = is_array(request('withTrashed')) ? request('withTrashed') : json_decode(request('withTrashed'));
        if(request()->has('withCount')) $options['withCount'] = is_array(request('withCount')) ? request('withCount') : json_decode(request('withCount'));
        if(request()->has('appends')) $options['appends'] = is_array(request('appends')) ? request('appends') : json_decode(request('appends'));
        if(request()->has('orderBy')) $options['orderBy'] = request('orderBy');
        if(request()->has('ids')) $options['ids'] = is_array(request('ids')) ? request('ids') : json_decode(request('ids'));
        return $options;
    }

    public static function clinicsScoped() {
        $clinics = self::getScope();
        $model = '\\' . static::class;

        $items = $model::whereHas('clinics', function($query) use ($clinics) {
            $query->whereIn('clinic_id', $clinics);
        });

        return $items;
    }

    public static function storesScoped() {
        $clinics = self::getScope();
        $model = '\\' . static::class;

        $items = $model::whereHas('stores', function($query) use ($clinics) {
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