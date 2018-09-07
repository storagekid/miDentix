<?php

namespace App\Traits;

use App\Clinic;
use App\Order;

trait Scope {

    public static function scoped($model) {
        $models = strtolower(str_plural($model));
        $model = '\\App\\' . ucfirst(strtolower($model));
        $clinics = null;
        if (request('clinic_id')) {
            $clinics = Clinic::find(request('clinic_id'));
            $items = $clinics[$models]->toArray();
        }
        elseif (request('clinics')) {
            $clinics = Clinic::find(request('clinics'));
            $count = 1;
            if (count($clinics)) {
                $items = $clinics[0][$models]->toArray();
                if (count($clinics) > 1) {
                    foreach ($clinics as $clinic) {
                        if ($count > 1) {
                            $items = array_merge($items, $clinic[$models]->toArray());
                        }
                        $count++;
                    }
                }
            } else {
                $items = $clinics[$models]->toArray();
            }
        } 
        
        if (!$clinics) {
            $items = $model::get();
        }
        return $items;
    }
}