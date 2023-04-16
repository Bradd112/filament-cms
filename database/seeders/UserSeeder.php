<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! empty(User::email('admin@teszt.hu'))) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@teszt.hu',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('Titok01'),
            ]);
        }
    }
}
