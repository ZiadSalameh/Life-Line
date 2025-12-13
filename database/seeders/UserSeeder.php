<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'office_id'=> null,
            'first_name'=>'root',
            'last_name'=>'root',
            'email'=>'root@mail.com',
            'password'=>'123456789',
            'role'=>'admin'
        ]);
    }
}
