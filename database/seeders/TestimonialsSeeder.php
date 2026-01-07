<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        activity()->disableLogging();

        $data = json_decode(
            file_get_contents(database_path('seeders/data/content.json')),
            true
        );

        foreach ($data['testimonials'] as $item) {
            $testimonial = Testimonial::updateOrCreate(
                ['name' => $item['name']],
                [
                    'role' => $item['role'],
                    'content' => $item['content'],
                    'rating' => $item['rating'],
                    'sort_order' => $item['order'],
                    'status' => $item['status'],
                ]
            );

            if (!empty($item['avatar'])) {
                $testimonial
                    ->clearMediaCollection('avatar')
                    ->addMediaFromUrl($item['avatar'])
                    ->toMediaCollection('avatar');
            }
        }

        activity()->enableLogging();
    }
}

