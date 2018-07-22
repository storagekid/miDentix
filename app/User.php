<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'last_access',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token',
    ];

    protected $with = ['group'];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function group()
    {
        return $this->belongsToMany(Group::class);
    }

    public function getMenu($domain, $groups, $role)
    {
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
                                $list = ['Stationary', 'PersonalTags', 'MedicalDirectory','Orders','Clinics','Providers'];
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
        return json_encode($menu->get($list));
    }
}
