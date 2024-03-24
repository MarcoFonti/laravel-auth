<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /* ALL'AVVIO CREO LA CARTELLA PER L'IMMAGINI */
        Storage::makeDirectory('project_images');
        
        /* TITOLO */
        $title = fake()->text(20);

        /* SLUG */
        $slug = Str::slug($title);

        /* CREO FILE */
        $file = fake()->image(storage_path('app/public/project_images') ,250, 250);

        /* SALVO FILE */
        /* $url = Storage::putFileAs('project_images', $file, "$slug.png"); <--- ERRORE */ 

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraphs(15, true),
            'image' => $file,
            'is_published' => fake()->boolean()
        ];
    }
}