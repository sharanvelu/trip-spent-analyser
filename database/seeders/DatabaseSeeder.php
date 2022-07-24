<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Sharan',
                'phone' => '9843207572',
                'email' => 'sharanvelu@outlook.com',
                'password' => Hash::make('password'),
            ]);
        $this->call(PermissionsSeeder::class);

//        $this->call(ExpenseSeeder::class);
//        $this->call(SpaceSeeder::class);
//        $this->call(TripSeeder::class);
//        $this->call(UserSeeder::class);
    }
}
