<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'contact',
                'value_json' => [
                    'email' => 'contact@imlystudio.com',
                    'phone' => '+91-9606032020',
                    'hours' => 'Mon-Sat 10:00 AM - 6:30 PM',
                ],
            ],
            [
                'key' => 'social',
                'value_json' => [
                    'facebook' => 'https://www.facebook.com/imlystudio',
                    'instagram' => 'https://www.instagram.com/imlystudio',
                    'linkedin' => 'https://www.linkedin.com/company/imlystudio',
                    'youtube' => 'https://www.youtube.com/@imlystudio',
                ],
            ],
            [
                'key' => 'seo_defaults',
                'value_json' => [
                    'title' => 'Imly Studio - Modular Interiors',
                    'description' => 'Premium modular kitchens, wardrobes, and living solutions.',
                    'keywords' => ['modular kitchen', 'wardrobe', 'living room', 'imly'],
                ],
            ],
        ];

        foreach ($settings as $data) {
            Setting::updateOrCreate(
                ['key' => $data['key']],
                ['value_json' => $data['value_json']]
            );
        }
    }
}
