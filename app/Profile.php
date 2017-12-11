<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\Especialty;
use App\Experience;
use App\User;

class Profile extends Model
{
    protected $fillable = ['name','lastname1','lastname2','email','phone','personal_id_number','license_number','license_year','tutorial_completed'];
    protected $hidden = ['user_id'];

    protected $appends = ['requestsCount','clinicsCount'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    // public function especialties() {
    //     return $this->belongsToMany(Especialty::class);
    // }
    public function experiences() {
        return $this->belongsToMany(Experience::class);
    }
    public function masters() {
    	return $this
    		->belongsToMany(
    			Master_University::class,
    			'master_university_profile',
    			'profile_id',
    			'master_university_id'
    		);
    }
    public function courses() {
        return $this->hasMany(Course::class);
    }
    public function clinics() {
        return $this->belongsToMany(Clinic::class);
    }
    public function schedules() {
        return $this->hasMany(Schedule::class);
    }
    public function requests() {
        return $this->hasMany(Request::class);
    }
    public function getRequestsCountAttribute() {
        return $this->requests->count();
    }
    public function getClinicsCountAttribute() {
        return $this->clinics->count();
    }
    public function extratimes() {
        return $this->hasMany(Extratime::class);
    }
    public function especialties() {
        $ids = [];
        $schedules = $this->schedules;
        foreach ($schedules as $schedule) {
            $especialties = $schedule->especialties;
            if (count($especialties)) {
                // print($especialties);
                for ($i=0; $i < count($especialties); $i++) { 
                    if (!in_array($especialties[$i]->id, $ids)) {
                        // echo $especialties[$i]->id;
                        $ids[] = $especialties[$i]->id;
                    }
                }
            }
        }
        return Especialty::whereIn('id',$ids)->get();
    }
}
