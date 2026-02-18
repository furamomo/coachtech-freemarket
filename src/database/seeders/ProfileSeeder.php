<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            'taro@example.com' => [
                'postal_code' => '123-4567',
                'address' => '東京都新宿区1-1-1',
                'building_name' => 'テストマンション101',
                'profile_image_path' => null,
            ],
            'hanako@example.com' => [
                'postal_code' => '234-5678',
                'address' => '大阪府大阪市2-2-2',
                'building_name' => 'サンプルハイツ202',
                'profile_image_path' => null,
            ],
            'jiro@example.com' => [
                'postal_code' => '345-6789',
                'address' => '福岡県福岡市3-3-3',
                'building_name' => null,
                'profile_image_path' => null,
            ],
        ];

        foreach ($profiles as $email => $p) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                continue;
            }

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profile_image_path' => $p['profile_image_path'],
                    'postal_code' => $p['postal_code'],
                    'address' => $p['address'],
                    'building_name' => $p['building_name'],
                ]
            );
        }
    }
}
