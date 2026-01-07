<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\File;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        // Disable activity logs during seeding
        activity()->disableLogging();

        $data = json_decode(
            file_get_contents(database_path('seeders/data/content.json')),
            true
        );

        foreach ($data['projects'] as $item) {
            // Create or update project (idempotent)
            $project = Project::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title'        => $item['sub_category'], // cleaner title
                    'category'     => $item['category'],
                    'sub_category' => $item['sub_category'],
                    'location'     => $item['location'],
                    'year'         => $item['year'],
                    'description'  => $item['description'],
                    'sort_order'        => $item['order'],
                    'is_active'       => $item['status'] ?? true,
                ]
            );

            /**
             * MEDIA IMPORT (GALLERY)
             * - Clear previous gallery
             * - Import images from React assets
             */
            $project->clearMediaCollection('gallery');

            foreach ($item['images'] as $imagePath) {
                /**
                 * React paths like:
                 * src/assets/images/projects/...
                 *
                 * Must be converted to absolute disk path
                 */
                $absolutePath = storage_path(
                    'app/import/projects/' . str_replace(
                        'src/assets/images/projects/',
                        '',
                        $imagePath
                    )
                );


                if (File::exists($absolutePath)) {
                    $project
                        ->addMedia($absolutePath)
                        ->preservingOriginal()
                        ->toMediaCollection('gallery');
                }
            }
        }

        // Re-enable activity logs
        activity()->enableLogging();
    }
}
