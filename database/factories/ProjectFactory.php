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
        $file = fake()->image(null ,350, 350);

        /* SALVO FILE */
        $url = Storage::putFileAs('project_images', $file, "$slug.png"); 

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraphs(15, true),
            'image' => $url,
            'is_published' => fake()->boolean()
        ];
    }
}