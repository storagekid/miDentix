<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfilesAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('es_ES');
        $group = \App\Group::where('name', 'Marketing')->first()->id;
        // $profile = factory('App\Profile')->create([
        //     'email' => 'jgvillalba@dentix.es',
        //     'personal_id_number' => '50459500F',
        //     'name' => 'Juan Gabriel',
        //     'lastname1' => 'Villalba',
        // ]);
        $profile = \App\Profile::where('email', 'jgvillalba@dentix.es')->first();
        $profile->phones()->create(['number' => $faker->e164PhoneNumber, 'type' => 'Personal', 'Description' => 'Personal Phone from Factory']);
        $profile->emails()->create(['email' => 'jgvillalba@dentix.es', 'type' => 'Trabajo', 'Description' => 'Work Email from Seeder']);

        $user = factory('App\User')->create([
            'name' => 'jgvillalba@dentix.es',
            'role' => 'root',
        ]);
        $user->group()->attach($group);
        $user->save();
        $profile->user_id = $user->id;
        $profile->save();

        // $group = \App\Group::where('name', 'Dentists')->first()->id;
        // $profile = factory('App\Profile')->create([
        //     'email' => 'ralvarado@dentix.es',
        //     'name' => 'Rafael',
        //     'lastname1' => 'Alvarado',
        // ]);
        // $user = $profile->user;
        // $user->email = $profile->email;
        // $user->password = Hash::make('Migabinete01');
        // $user->role = 'admin';
        // $user->group()->attach($group);
        // $user->save();

        $group = \App\Group::where('name', 'Marketing')->first()->id;
        $profile = \App\Profile::where('email', 'dhernandez@dentix.es')->first();
        // $user = factory('App\User')->create([
        //     'email' => $profile->email,
        //     'role' => 'admin',
        // ]);
        // $user->group()->attach($group);
        // $user->save();
        // $profile->user_id = $user->id;
        // $profile->save();
        // $profile = factory('App\Profile')->create([
        //     'name' => 'Diego',
        //     'lastname1' => 'Hernández',
        // ]);
        $profile->phones()->create(['number' => $faker->e164PhoneNumber, 'type' => 'Personal', 'Description' => 'Personal Phone from Factory']);
        $profile->emails()->create(['email' => 'dhernandez@dentix.es', 'type' => 'Trabajo', 'Description' => 'Work Email from Seeder']);

        $user = factory('App\User')->create([
            'name' => 'dhernandez@dentix.es',
            'role' => 'admin',
        ]);

        $user->group()->attach($group);
        $user->save();
        $profile->user_id = $user->id;
        $profile->save();

        $group = \App\Group::where('name', 'Marketing')->first()->id;
        $profile = factory('App\Profile')->create([
            'name' => 'Alba',
            'lastname1' => 'Cruz',
            'tutorial_completed' => 0,
        ]);
        // $profile->phones()->create(['number' => $faker->e164PhoneNumber, 'type' => 'Personal', 'Description' => 'Personal Phone from Factory']);
        // $profile->emails()->create(['email' => 'acruz@dentix.es', 'type' => 'Trabajo', 'Description' => 'Work Email from Seeder']);
        $user = $profile->user;
        $user->name = 'acruz@dentix.es';
        $user->password = Hash::make('Migabinete01');
        $user->role = 'user';
        $user->group()->attach($group);
        $user->save();
        

        $group = \App\Group::where('name', 'Marketing')->first()->id;
        $profile = factory('App\Profile')->create([
            'name' => 'Blanca',
            'lastname1' => 'Barragán',
            'tutorial_completed' => 0,
        ]);
        // $profile->phones()->create(['number' => $faker->e164PhoneNumber, 'type' => 'Personal', 'Description' => 'Personal Phone from Factory']);
        // $profile->emails()->create(['email' => 'bbarragan@dentix.es', 'type' => 'Trabajo', 'Description' => 'Work Email from Seeder']);
        $user = $profile->user;
        $user->name = 'bbarragan@dentix.es';
        $user->password = Hash::make('Migabinete01');
        $user->role = 'user';
        $user->group()->attach($group);
        $user->save();
    }
}
