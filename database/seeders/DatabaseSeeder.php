<?php

namespace Database\Seeders;

use App\Eunms\User\UserStatus;
use App\Eunms\User\UserType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username'=> 'admin',
            'name'=>'Admin User',
            'password'=>'password' , 
            'type'=> UserType::Admin->value, 
            'status'=>UserStatus::Active
        ]);
    }
}
