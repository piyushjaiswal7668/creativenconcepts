<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShieldRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('name', 'admin')->first();
        $editor = Role::where('name', 'editor')->first();
        $sales = Role::where('name', 'sales')->first();

        // Admin: all permissions
        if ($admin) {
            $admin->syncPermissions(Permission::all());
        }

        // Editor: content & product resources (no force_delete)
        if ($editor) {
            $editorPermissions = Permission::where(function ($q) {
                $resources = [
                    'page',
                    'navigation_link',
                    'category',
                    'product',
                    'product_variant',
                    'asset',
                    'testimonial',
                    'faq',
                ];

                foreach ($resources as $resource) {
                    $q->orWhere('name', 'like', "view_any::{$resource}%")
                        ->orWhere('name', 'like', "view::{$resource}%")
                        ->orWhere('name', 'like', "create::{$resource}%")
                        ->orWhere('name', 'like', "update::{$resource}%")
                        ->orWhere('name', 'like', "delete::{$resource}%")
                        ->orWhere('name', 'like', "restore::{$resource}%");
                    // force_delete intentionally excluded
                }
            })->get();

            $editor->syncPermissions($editorPermissions);
        }

        // Sales: leads & newsletter_subscriptions (view/view_any/update only)
        if ($sales) {
            $salesPermissions = Permission::where(function ($q) {
                $resources = [
                    'lead',
                    'newsletter_subscription',
                ];

                foreach ($resources as $resource) {
                    $q->orWhere('name', 'like', "view_any::{$resource}%")
                        ->orWhere('name', 'like', "view::{$resource}%")
                        ->orWhere('name', 'like', "update::{$resource}%");
                }
            })->get();

            $sales->syncPermissions($salesPermissions);
        }
    }
}
