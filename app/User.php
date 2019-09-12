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
        'groups' => [
            'label' => 'Groups',
        ],
    ];
    protected $tableOptions = [['show','edit','delete'], true, false];
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

    public function getMenu($domain, $groups, $role)
    {
        $list = null;
        switch ($domain) {
            case 'gabinete':
                switch ($groups[0]) {
                    case 'Dentists':
                        switch ($role) {
                            case 'user':
                                $list = ['CPanel', 'Profile', 'Requests', 'Schedule', 'Masters', 'Protocols', 'Surveys'];
                                break;
                            case 'admin':
                                $list = ['CPanel', 'Requests', 'ExtraTime', 'Dentists', 'Clinics', 'Papers'];
                                break;
                            case 'root':
                                $list = ['CPanel', 'Requests', 'ExtraTime', 'Users', 'Clinics', 'Papers', 'Tools'];
                                break;
                            default:
                                $list = [];
                                break;
                        };
                        break;
                    case 'Marketing':
                        switch ($role) {
                            case 'user':
                                $list = ['Orders','Stationary', 'PersonalTags', 'BusinessCard', 'MedicalDirectory', 'Profiles', 'Clinics','Providers'];
                                break;
                            case 'admin':
                                $list = ['Orders','Stationary', 'PersonalTags', 'BusinessCard', 'MedicalDirectory', 'Profiles', 'Clinics','Providers','Users'];
                                break;
                            case 'root':
                                $list = ['CPanel', 'Requests', 'ExtraTime', 'Users', 'Clinics', 'Papers', 'Tools'];
                                break;
                            default:
                                $list = [];
                                break;
                        };
                        break;
                    case 'Clinics':
                        switch ($role) {
                            case 'user':
                                $list = ['Orders','Stationary', 'PersonalTags', 'BusinessCard', 'MedicalDirectory', 'Profiles', 'Clinics','Providers'];
                                break;
                            case 'admin':
                                $list = ['Orders','Stationary', 'PersonalTags', 'BusinessCard', 'MedicalDirectory', 'Profiles', 'Clinics','Providers'];
                                break;
                            case 'root':
                                $list = ['CPanel', 'Requests', 'ExtraTime', 'Users', 'Clinics', 'Papers', 'Tools'];
                                break;
                            default:
                                $list = [];
                                break;
                        };
                        break;
                    case 'Administrators':
                        switch ($role) {
                            case 'user':
                                $list = ['CPanel', 'Profile', 'Requests', 'Schedule', 'Masters', 'Protocols', 'Surveys'];
                                break;
                            case 'admin':
                                $list = ['CPanel', 'Requests', 'ExtraTime', 'Dentists', 'Clinics', 'Papers'];
                                break;
                            case 'root':
                                $list = ['CPanel', 'Users', 'Clinics', 'Stationary', 'PersonalTags', 'MedicalDirectory', 'Tools'];
                                break;
                            default:
                                $list = [];
                                break;
                        };
                        break;
                }
        }
        $menu = new Menu;
        return json_encode($menu->get($list ? $list : []));
    }

    public function isRoot()
    {
        return auth()->user()->name === 'jgvillalba@dentix.es';
    }
}
