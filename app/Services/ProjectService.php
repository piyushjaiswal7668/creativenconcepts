<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    /**
     * Project listing
     * One record per image (frontend card view)
     */
    public function list(): array
    {
        $projects = Project::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        $flattened = [];

        foreach ($projects as $project) {
            $images = $project->getMedia('gallery')->map->getUrl()->values();

            // If no images, still return one fallback record
            if ($images->isEmpty()) {
                $flattened[] = $this->serializeSingleImage($project, null);
                continue;
            }

            foreach ($images as $imageUrl) {
                $flattened[] = $this->serializeSingleImage($project, $imageUrl);
            }
        }

        return [
            'projects' => $flattened,
        ];
    }

    /**
     * Project detail page
     * Full gallery (correct already)
     */
    public function findBySlug(string $slug): array
    {
        $project = Project::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (! $project) {
            return [
                'project' => $this->emptyProject($slug),
            ];
        }

        return [
            'project' => $this->serialize($project),
        ];
    }

    /**
     * Serialize project for listing (single image)
     */
    private function serializeSingleImage(Project $project, ?string $image): array
    {
        return [
            'title'        => $project->title,
            'slug'         => $project->slug,
            'category'     => $project->category ?? '',
            'sub_category' => $project->sub_category ?? '',
            'location'     => $project->location ?? '',
            'year'         => $project->year ?? '',
            'description'  => $project->description ?? '',
            'order'        => $project->sort_order,
            'status'       => (bool) $project->is_active,
            'image'        => $image, // 👈 single image
        ];
    }

    /**
     * Serialize project for detail page (gallery)
     */
    private function serialize(Project $project): array
    {
        return [
            'title'        => $project->title,
            'slug'         => $project->slug,
            'category'     => $project->category ?? '',
            'sub_category' => $project->sub_category ?? '',
            'location'     => $project->location ?? '',
            'year'         => $project->year ?? '',
            'description'  => $project->description ?? '',
            'order'        => $project->sort_order,
            'status'       => (bool) $project->is_active,
            'images'       => $project->getMedia('gallery')->map->getUrl()->values()->all(),
        ];
    }

    /**
     * Fallback object (no nulls)
     */
    private function emptyProject(string $slug): array
    {
        return [
            'title'        => '',
            'slug'         => $slug,
            'category'     => '',
            'sub_category' => '',
            'location'     => '',
            'year'         => '',
            'description'  => '',
            'order'        => 0,
            'status'       => false,
            'images'       => [],
        ];
    }
}
