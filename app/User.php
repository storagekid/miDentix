<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Traits\Tableable;
use App\Traits\Quasarable;
use App\Traits\Scope;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use Tableable;
    use Quasarable;
    use Scope;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_access',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $with = [];
    protected $appends = ['value', 'label'];

    // Quasar DATA
    protected $relatedTo = ['group_users'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'password', 'password2']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'password', 'password2']
            ],
        ],
        [
            'title' => 'Groups & Roles',
            'icon' => 'group',
            'fields' => [],
            'relations' => ['group_users']
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' => 'Nombre',
        ],
        'password' => [
            'label' =>'Password',
            'type' => [
                'name' =>'password',
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
        'password2' => [
            'unreal' => true,
            'label' =>'Password Confirm',
            'type' => [
                'name' =>'password',
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ], 
        'group_users' => [
            'label' => 'Groups',
        ],
    ];
    // END Tableable Data

    public function findForPassport($identifier) {
        return $this->orWhere('name', $identifier)->first();
    }
    public function routeNotificationForMail()
    {
        return $this->name;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_users')->as('role')->withPivot('role')->withTimestamps();
    }
    public function group_users() {
        return $this->hasMany(GroupUser::class, 'user_id');
    }
    public function getGroupsInfoAttribute()
    {
        $groups = [];
        if (count($this->groups)) {
            foreach ($this->groups as $group) {
                $groups[$group->name] = $group->role->role;
            }
        }
        return $groups;
    }

    public function getHomeRoutes()
    {
        $homes = ['ProfileHome'];
        if (count($this->groups)) {
            foreach ($this->groups as $group) {
                $routeName = ucfirst($group->name) . ucfirst($group->role->role) . 'Home';
                $homes[] = $routeName;
                // $groups[$group->name] = $group->role->role;
            }
        }
        return $homes;
    }

    public function isRoot()
    {
        // dd(auth()->user() instanceof \App\User);
        $user = auth()->user() instanceof \App\User ? auth()->user() : auth()->guard('api')->user();
        return $user->name === 'jgvillalba@dentix.es';
    }

    public static function useSoftDeleting()
    {
      // ... check if 'this' model uses the soft deletes trait
      return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(static::make()));
    }

    public function loginApi() {
        $this->load('profiles', 'groups', 'group_users');
        $this->append('groupsInfo');
        if (count($this->profiles) === 1) {
            $this['profile'] = \App\Profile::fetch(['full' => true, 'ids' => [$this->profiles[0]->id], 'appends' => ['clinicScope', 'storeScope']])[0];
        }
    }

    public function buildMainMenu() {
        $menus = \App\Menu::get()->toArray();
        if (!$this->isRoot()) {
            $userGroups = collect($this->groupsInfo)->keys()->toArray();
            $routes = [];
            $menuItems = collect();
            foreach ($this->groups as $group) {
                $groupMenuItems = $group->menu_items;
                $groupRoutes = $group->menu_items->pluck('to')->all();
                $routes = array_merge($routes, $groupRoutes);
                $menuItems = $menuItems->merge($groupMenuItems);
            }
            foreach ($menus AS $key => $parent) {
                $filteredItems = [];
                foreach ($parent['shorted_items'] as $i) {
                    if (!count($i['groups'])) continue;
                    foreach ($i['groups'] as $menusGroup) {
                        if (in_array($menusGroup['name'], $userGroups)) $filteredItems[] = $i;
                    }
                }
                $menus[$key]['filtered_items'] = $filteredItems;
                unset($menus[$key]['shorted_items']);
            }
        } else {
            foreach ($menus as $key => $parent) {
                $menus[$key]['filtered_items'] = $parent['shorted_items'];
                unset($menus[$key]['shorted_items']);
            }
            $routes = \App\MenuItem::get()->pluck('to')->all();
        }
        $routes = array_values(array_filter($routes, function($i) {
            return $i !== null;
        }));
        $routes = array_merge($routes, $this->getHomeRoutes());

        if (!count($routes)) {
            return response()->json(['message' => 'User has no Accesses Granted'], 403);
        }

        return [$menus, $routes];
    }
}
