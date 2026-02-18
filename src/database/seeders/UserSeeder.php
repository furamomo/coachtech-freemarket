<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'テスト太郎',
                'email' => 'taro@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'テスト花子',
                'email' => 'hanako@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'テスト次郎',
                'email' => 'jiro@example.com',
                'password' => 'password123',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make($u['password']),
                ]
            );
        }
    }
}
