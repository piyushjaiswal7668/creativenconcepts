<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamMembersSeeder extends Seeder
{
    public function run(): void
    {
        activity()->disableLogging();

        $data = json_decode(
            file_get_contents(database_path('seeders/data/content.json')),
            true
        );

        foreach ($data['team_members'] as $member) {
            $team = TeamMember::updateOrCreate(
                ['name' => $member['name']],
                [
                    'role' => $member['role'],
                    'bio' => $member['bio'],
                    'sort_order' => $member['order'],
                    'is_active' => $member['status'],
                ]
            );

            if (!empty($member['photo'])) {
                $team
                    ->clearMediaCollection('photo')
                    ->addMediaFromUrl($member['photo'])
                    ->toMediaCollection('photo');
            }
        }

        activity()->enableLogging();
    }
}
