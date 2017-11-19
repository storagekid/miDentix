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
        $schedule = create('App\Schedule');
        // dd($schedule);
        // $this->expectException(\Exception::class);
        $response = $this->json('post','/schedule', $schedule->toArray());
        $response->assertStatus(200);
    }
    /** @test */
    public function an_authenticated_user_can_delete_his_own_schedules()
    {
        $this->withOutExceptionHandling()->signIn();
        $schedule = create('App\Schedule');
        $this->json('delete','/schedule/'.$schedule->id);
        // dd($schedule);
        // $this->expectException(\Exception::class);
        // $response = $this->json('post','/schedule', $schedule->toArray());
        // $response->assertStatus(200);
    }
}
