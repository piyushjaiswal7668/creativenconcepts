<?php

namespace App\Services;

use App\Models\TeamMember;

class TeamService
{
    public function list(): array
    {
        $members = TeamMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        return [
            'team' => $members->map(fn (TeamMember $member) => [
                'name' => $member->name,
                'role' => $member->role ?: '',
                'bio' => $member->bio ?: '',
                'order' => $member->sort_order,
                'status' => $member->is_active,
                'photo' => $member->getFirstMediaUrl('photo') ?: '',
            ])->all(),
        ];
    }
}
