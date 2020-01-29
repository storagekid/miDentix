<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait Scope {
    protected static $options = [];

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

        self::filterOptions($options);
        // dump(self::$options);
        if (request()->has('scope_store_id')) $models = self::storesScoped();
        else if (request()->has('scope_clinic_id')) $models = self::clinicsScoped();
        else {
            $modelName = '\\' . static::class;
            if (array_key_exists('withTrashed', static::$options) || ($modelName::useSoftDeleting() && auth()->user()->isRoot())) $models = $modelName::withTrashed();
            else $models = $modelName::select();
        }
        if (array_key_exists('withCount', static::$options)) $models = $models->withCount(static::$options['withCount']);
        if (array_key_exists('full', static::$options)) $models->with(static::$full);
        else if (array_key_exists('with', static::$options)) $models->with(static::$options['with']);
        if (array_key_exists('where', static::$options)) $models->where(static::$options['where']);
        if (array_key_exists('whereIn', static::$options)) {
            if (count(static::$options['whereIn'])) {
                foreach (static::$options['whereIn'] as $filter) {
                    $found = strpos($filter[0], '.');
                    if (!$found) $models->whereIn($filter[0], $filter[1]);
                    else {
                        $words = explode('.', $filter[0]);
                        foreach ($filter[1] as $key => $value) {
                            if (is_string($value)) {
                                if ($value[0] === '#') {
                                    $pos = strpos($value, 'lastId');
                                    if ($pos) {
                                        $model = substr(strrchr($value, ':'), 1);
                                        $model = ucfirst(Str::singular($model));
                                        $nameSpace = '\App\\' . $model;
                                        $filter[1][$key] = $nameSpace::orderBy('starts_at', 'desc')->first()->id;
                                    }
                                }
                            }
                        }
                        $models->whereHas($words[0], function($q) use ($words, $filter) {
                            $q->whereIn($words[1], $filter[1]);
                        });
                    }
                }
            }
            // $models->whereIn(static::$options['whereIn']);
        }
        if (array_key_exists('orderBy', static::$options)) $models = $models->orderBy(static::$options['orderBy'], array_key_exists('orderDesc', static::$options) ? 'desc' : 'asc');
        if (array_key_exists('ids', static::$options)) $models = $models->find(static::$options['ids']);
        else $models = $models->get();

        if (array_key_exists('appends', static::$options)) $models->each(function ($i) { $i->append(static::$options['appends']); });
        return $models;
    }

    public static function filterOptions($options) {
        // dd($options);
        if (!request()->has('options')) {
            static::$options = $options;
            return true;
        }
        $requestOptions = is_array(request('options')) ? collect(request('options')) : collect(json_decode(request('options'), true));
        if($requestOptions->has('scoped')) $options['scoped'] = $requestOptions['scoped'];
        if($requestOptions->has('scopedThrough')) $options['scopedThrough'] = $requestOptions['scopedThrough'];
        if (!array_key_exists('where', $options)) {
            if($requestOptions->has('where')) $options['where'] = is_array($requestOptions['where']) ? $requestOptions['where'] : json_decode($requestOptions['where']);
        }
        if (!array_key_exists('whereIn', $options)) {
            if($requestOptions->has('whereIn')) $options['whereIn'] = is_array($requestOptions['whereIn']) ? $requestOptions['whereIn'] : json_decode($requestOptions['whereIn']);
        }
        if($requestOptions->has('full')) $options['full'] = $requestOptions['full'];
        if($requestOptions->has('with')) {
            $requestWith = is_array($requestOptions['with']) ? $requestOptions['with'] : json_decode($requestOptions['with']);
            $options['with'] = array_key_exists('with', $options) ? array_merge($options['with'], $requestWith) : $requestWith;
        }
        if($requestOptions->has('withTrashed')) $options['withTrashed'] = is_array($requestOptions['withTrashed']) ? $requestOptions['withTrashed'] : json_decode($requestOptions['withTrashed']);
        if($requestOptions->has('withCount')) $options['withCount'] = is_array($requestOptions['withCount']) ? $requestOptions['withCount'] : json_decode($requestOptions['withCount']);
        if($requestOptions->has('appends')) {
            $requestAppends = is_array($requestOptions['appends']) ? $requestOptions['appends'] : json_decode($requestOptions['appends']);
            $options['appends'] = array_key_exists('appends', $options) ? array_merge($options['appends'], $requestAppends) : $requestAppends;
        }
        if($requestOptions->has('orderBy')) $options['orderBy'] = $requestOptions['orderBy'];
        if($requestOptions->has('orderDesc')) $options['orderDesc'] = $requestOptions['orderDesc'];
        if($requestOptions->has('ids')) $options['ids'] = is_array($requestOptions['ids']) ? $requestOptions['ids'] : json_decode($requestOptions['ids']);
        static::$options = $options;
    }

    public static function clinicsScoped() {
        $clinics = self::getScope();
        $model = '\\' . static::class;
        $method = method_exists($model, 'clinics') ? 'clinics' : 'clinic';
        
        if (!array_key_exists('scopedThrough', static::$options)) {
            $items = $model::whereHas($method, function($query) use ($clinics) {
                $query->whereIn('clinic_id', $clinics);
            });
        } else {
            $items = $model::whereHas(static::$options['scopedThrough'], function ($query) use ($clinics) {
                $query->whereHas('clinic', function ($query) use ($clinics) {
                    $query->whereIn('clinic_id', $clinics);
                });
            });
        }

        return $items;
    }

    public static function storesScoped() {
        $clinics = self::getScope();
        $model = '\\' . static::class;
        $method = method_exists($model, 'stores') ? 'stores' : 'store';

        $items = $model::whereHas($method, function($query) use ($clinics) {
            $query->whereIn('store_id', $clinics);
        });

        return $items;
    }

    public static function getScope() {
        $clinics = null;
        switch (true) {
            case request()->has('scope_country_id') :
                $clinics = $clinics->where('country_id', request('country_id'))->pluck('id')->toArray();
                break;
            case request()->has('scope_state_id') :
                $clinics = $clinics->where('state_id', request('state_id'))->pluck('id')->toArray();
                break;
            case request()->has('scope_county_id') :
                $clinics = $clinics->where('county_id', request('county_id'))->pluck('id')->toArray();
                break;
            case request()->has('scope_clinic_id') :
                if (is_array(request('scope_clinic_id'))) {
                    $clinics = request('scope_clinic_id');
                } else {
                    $clinics = [request('scope_clinic_id')];
                }
                break;
            case request()->has('scope_store_id') :
                if (is_array(request('scope_store_id'))) {
                    $clinics = request('scope_store_id');
                } else {
                    $clinics = [request('scope_store_id')];
                }
                break;
        }
        if (!$clinics) {
            $clinics = session('clinicsScope');
        }
        return $clinics;
    }
}