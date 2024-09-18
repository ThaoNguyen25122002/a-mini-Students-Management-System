<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'=>'Thao',
                'email'=>'nlcongthao@gmail.com',
                'password'=>bcrypt('password'),
            ],
        ];
        User::insert($users);
    }
}
