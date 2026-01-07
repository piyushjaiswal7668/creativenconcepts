<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        $resources = [
            'company_setting',
            'project',
            'team_member',
            'testimonial',
            'lead',
            'user',
        ];

        $actions = ['view_any', 'view', 'create', 'update', 'delete'];

        $permissions = [];
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $permissions[] = Permission::firstOrCreate([
                    'name' => $action . '_' . $resource,
                    'guard_name' => $guard,
                ]);
            }
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => $guard]);
        $superAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        $contentManager = Role::firstOrCreate(['name' => 'content_manager', 'guard_name' => $guard]);
        $sales = Role::firstOrCreate(['name' => 'sales', 'guard_name' => $guard]);

        $superAdmin->syncPermissions($permissions);

        $contentManager->syncPermissions([
            'view_any_company_setting',
            'view_company_setting',
            'update_company_setting',
            'view_any_project',
            'view_project',
            'create_project',
            'update_project',
            'delete_project',
            'view_any_team_member',
            'view_team_member',
            'create_team_member',
            'update_team_member',
            'delete_team_member',
            'view_any_testimonial',
            'view_testimonial',
            'create_testimonial',
            'update_testimonial',
            'delete_testimonial',
        ]);

        $sales->syncPermissions([
            'view_any_lead',
            'view_lead',
            'update_lead',
        ]);
    }
}
