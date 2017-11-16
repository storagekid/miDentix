<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Menu;
use App\Profile;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function getMenu($role) {
        switch ($role) {
            case 'user':
                $list = ['CPanel','Profile','Requests','Schedule','Masters','Protocols','Surveys'];
                break;
            case 'admin':
                $list = ['CPanel','Requests','Users','Clinics','Papers'];
                break;
            default:
                $list = array();
                break;
        };
        $menu = new Menu;
        return json_encode($menu->get($list));
    }
}
