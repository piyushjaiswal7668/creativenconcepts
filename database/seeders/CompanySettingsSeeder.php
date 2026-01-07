<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanySetting;
use Spatie\Activitylog\Models\Activity;

class CompanySettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Disable activity logging during seeding
        activity()->disableLogging();

        $data = json_decode(
            file_get_contents(database_path('seeders/data/content.json')),
            true
        );

        $settingsData = $data['company_settings'];

        // Ensure singleton record (id = 1)
        $companySetting = CompanySetting::updateOrCreate(
            ['id' => 1],
            [
                'address'         => $settingsData['address'] ?? '',
                'mobile'          => $settingsData['mobile'] ?? '',
                'email'           => $settingsData['email'] ?? '',
                'whatsapp'        => $settingsData['whatsapp'] ?? '',
                'google_maps'  => $settingsData['google_map_url'] ?? '',
                'social_links_json'    => $settingsData['social_links'] ?? [],
            ]
        );

        /**
         * Logo handling via Spatie Media Library
         * - Only attach if logo exists
         * - Clear previous logo before attaching
         */
        if (!empty($settingsData['logo'])) {
            $companySetting
                ->clearMediaCollection('logo')
                ->addMediaFromUrl($settingsData['logo'])
                ->toMediaCollection('logo');
        }

        // Re-enable activity logging
        activity()->enableLogging();
    }
}
