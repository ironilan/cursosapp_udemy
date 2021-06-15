<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Alexis Valdez',
            'email' => 'ilanvaldez34@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        $user->assignRole('Admin');

        //llamamos al factory para crear 99 usuarios y lo oncatenamos con el de create osea serian 100
        User::factory(99)->create();
    }
}
