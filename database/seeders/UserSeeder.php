<?php

namespace Database\Seeders;

use App\Models\Role;
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
        collect([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ],

            [
                'name' => 'Moderator',
                'email' => 'Moderator@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ],

            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ],

        ])->each(function ($user) {
            User::create($user);
        });

        collect(['admin', 'moderator'])->each(fn ($role) => Role::create(['name' => $role]));

        User::find(1)->roles()->attach([1]);
        User::find(2)->roles()->attach([2]);
    }
}
