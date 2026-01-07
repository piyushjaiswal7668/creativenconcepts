<?php

namespace App\Services;

use App\Models\CompanySetting;

class CompanySettingsService
{
    public function getSettings(): array
    {
        $settings = CompanySetting::query()->first();

        if (! $settings) {
            return $this->fallback();
        }

        return [
            'logo' => $settings->getFirstMediaUrl('logo') ?: '',
            'address' => $settings->address ?: '',
            'mobile' => $settings->mobile ?: '',
            'email' => $settings->email ?: '',
            'whatsapp' => $settings->whatsapp ?: '',
            'socialLinks' => $settings->social_links_json ?: [],
            'googleMaps' => $settings->google_maps ?: '',
        ];
    }

    private function fallback(): array
    {
        return [
            'logo' => '',
            'address' => '',
            'mobile' => '',
            'email' => '',
            'whatsapp' => '',
            'socialLinks' => [],
            'googleMaps' => '',
        ];
    }
}
