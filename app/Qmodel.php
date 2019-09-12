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
          if (request()->route()->uri === 'api/rest/auth/login') return true;
          else {
            static::authorize('view');
          }
        });
        static::saving(function () {
        });
        static::saved(function () {
          Cache::forget('clinics');
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


    // public function getShowView($view=null) {
    //   $views = [
    //     'distributions' => [
    //       'county',
    //       'cost_center',
    //       'addresses',
    //       'phones',
    //       'area_manager',
    //       'clinic_manager',
    //       'clinic_poster_priorities',
    //       'poster_distributions' => function ($q) { return $q->with(['original_facade', 'complete_facades']); }
    //     ],
    //     'default' => static::$show ? static::$show : []
    //   ];
    //   if (!$view) $view = 'default';
    //   else if (!array_key_exists($view, $views)) $view = 'default';
    //   return $views[$view];
    // }
    public function getShowView($view=null) {
      if (!$view) {
        $view = static::$show ? static::$show : [];
        return $view;
      }
      else if (!array_key_exists($view, static::$views)) return [];
      return static::$views[$view];
    }
    protected static function authorize($method) {
      // dump('Authorizing');
      // dump(static::class);
      // return false;
      // if (static::class === 'App\Group') return true;
      // if (static::class === 'App\GroupUser') return true;
      if(!array_key_exists($method, static::$permissions)) return false;
      if (in_array('*', static::$permissions[$method])) return true;
      $user = auth()->guard('api')->user();
      if ($user->isRoot()) return true;
      $userGroups = array_keys($user->groupsInfo);
      // if (count($this->permissions)) {
      //   foreach ($userGroups as $group) {
      //     if ($this->permissions[$group]) {
      //       $role = $user->groupsInfo[$group];
      //       if (arra_key_exists($role, $this->permissions[$group])) {
      //         if (in_array($this->permissions[$group][$role], $method)) return true;
      //       }
      //     }
      //   }
      // }
      // dump($userGroups);
      // dump($method);
      // dump(static::$permissions);
      foreach ($userGroups as $group) {
        // dump('Here');
        if (array_key_exists($group, static::$permissions[$method])) {
          if (in_array('*', static::$permissions[$method][$group])) return true;
          $role = $user->groupsInfo[$group];
          // dump('THere');
          // dump($role);
          // dump(in_array($role, static::$permissions[$method][$group]));
          if (in_array($role, static::$permissions[$method][$group])) return true;
        }
      }
      // return response([
      //   'message' => 'Unauthorized action.',
      // ], 403);
      abort(403, 'Unauthorized action.');
    }
}
