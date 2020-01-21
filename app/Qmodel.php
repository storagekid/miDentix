<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Quasarable;
use App\Traits\Tableable;
use App\Traits\Scope;
use Illuminate\Support\Facades\Cache;

class Qmodel extends Model
{
    use Quasarable, Tableable, Scope;

    public static function boot()
    {
        parent::boot();
        static::retrieved(function () {
          if (request()->route()) {
            if (request()->route()->uri === 'api/rest/auth/login') return true;
            else {
              static::authorize('view');
            }
          }
        });
        static::saving(function () {
        });
        static::saved(function () {
          // Cache::forget('clinics');
        });
        static::creating(function () {
            static::authorize('create');
        });
        static::created(function () {
        });
        static::updated(function () {
        });
        static::updating(function () {
          static::authorize('update');
        });
        static::deleted(function () {
          Cache::forget('clinics');
        });
        static::deleting(function () {
          static::authorize('destroy');
        });
    }

    // Quasar DATA
    protected $appends = ['label', 'value'];
    protected static $permissions = [
        'view' => [
          ],
        'create' => [
          ],
        'update' => [
          ],
        'destroy' => [
          ],
    ];
    // END Quasar DATA
    public static function useSoftDeleting()
    {
      // ... check if 'this' model uses the soft deletes trait
      return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(static::make()));
    }
    public static function useFileable()
    {
      // ... check if 'this' model uses the Fileable trait
      return in_array('App\Traits\Fileable', class_uses(static::make()));
    }
    public function getShowView($view=null) {
      if (!$view) {
        $view = [];
        (isset(static::$show) ? $view['with'] = static::$show : isset(static::$full)) ? $view['with'] = static::$full : $view['with'] = [];
        isset(static::$appends) ? $view['append'] = static::$appends : $view['append'] = [];
        return $view;
      }
      else if (!array_key_exists($view, static::$views)) return [];
      return static::$views[$view];
    }
    public function buildName() {
      return null;
    }
    protected static function authorize($method) {
      $user = auth()->user() instanceof \App\User ? auth()->user() : auth()->guard('api')->user();
      if ($user->isRoot()) return true;

      if(!array_key_exists($method, static::$permissions)) return false;
      if (in_array('*', static::$permissions[$method])) return true;

      $user->append('groupsInfo');
      $userGroups = array_keys($user->groupsInfo);
      foreach ($userGroups as $group) {
        if (array_key_exists($group, static::$permissions[$method])) {
          if (in_array('*', static::$permissions[$method][$group])) return true;
          $role = $user->groupsInfo[$group];
          if (in_array($role, static::$permissions[$method][$group])) return true;
        }
      }
      abort(403, 'Unauthorized action.');
    }
    public function fixRelationUniqueFields($parent) {
      $formRules = $this->formRules();
      // dump($parent->toArray());
      // dump($parent[$parent->getKeyField()]);
      foreach ($formRules as $field => $rules) {
        if (in_array('unique', $rules)) {
          $name = $this->buildName();
          if ($name) $this[$field] = $name;
          else $this[$field] .= $parent[$parent->getKeyField()];
          $this->save();
        }
      }
    }
}
