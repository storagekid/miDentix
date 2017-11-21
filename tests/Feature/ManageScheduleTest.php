<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManageScheduleTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
     /** @test */
    public function an_authenticated_user_may_created_his_own_schedules()
    {
        $this->withOutExceptionHandling()->signIn();
        $schedule = make('App\Schedule');
        $schedule->clinic_profile = false;
        // dd($schedule);
        // $this->expectException(\Exception::class);
        $response = $this->json('post','/schedule', $schedule->toArray());
        $response->assertStatus(200);
        // dd($response->getContent());
    }
    /** @test */
    public function an_authenticated_user_can_delete_his_own_schedules()
    {
        $this->withExceptionHandling()->signIn();
        $schedule = create('App\Schedule', ['clinic_id'=>13]);
        $this->json('delete','/schedule/'.$schedule->id);
        // dd($schedule);
        // $this->expectException(\Exception::class);
        // $response = $this->json('post','/schedule', $schedule->toArray());
        // $response->assertStatus(200);
    }
    /** @test */
    public function an_authenticated_user_can_delete_his_own_Clinic_Profile_Link()
    {
        $user = create('App\User');
        $profile = create('App\Profile', ['user_id'=>$user->id]);
        $this->withOutExceptionHandling()->signIn($user);
        $c = create('App\Clinic');
        $cp = new \App\Clinic_Profile;
        $cp->clinic_id = $c->id;
        $cp->profile_id = $profile->id;
        $cp->save();
        $s = create('App\Schedule', [
            'clinic_id'=>$c->id,
            'profile_id'=>$profile->id
        ]);
        $this->assertDatabaseHas('schedules',[
            'clinic_id'=>$c->id,
            'profile_id'=>$profile->id
        ]);
        // dd($s);
        $this->assertDatabaseHas('clinic_profile',[
            'clinic_id'=>$c->id,
            'profile_id'=>$profile->id
        ]);
        $this->json('delete','/clinic_profile/'.$c->id.'/'.$profile->id);
        $this->assertDatabaseMissing('clinic_profile',[
            'clinic_id'=>$c->id,
            'profile_id'=>$profile->id
        ]);
        $this->assertDatabaseMissing('schedules',[
            'clinic_id'=>$c->id,
            'profile_id'=>$profile->id
        ]);
    }
}
