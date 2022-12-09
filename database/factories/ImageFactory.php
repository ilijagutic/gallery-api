<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Gallery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image_url' => $this->faker->randomElement(['https://www.google.com/url?sa=i&url=http%3A%2F%2Fclipart-library.com%2Fclipart%2Fgceabj6cd.htm&psig=AOvVaw1zhZBxKQrfiBI-ntHNunOS&ust=1670536744999000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCOD0lbzA6PsCFQAAAAAdAAAAABAO', 'https://www.google.com/url?sa=i&url=http%3A%2F%2Fclipart-library.com%2Fsmall-cliparts.html&psig=AOvVaw1zhZBxKQrfiBI-ntHNunOS&ust=1670536744999000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCOD0lbzA6PsCFQAAAAAdAAAAABAJ', 'https://www.google.com/url?sa=i&url=http%3A%2F%2Fclipart-library.com%2Fsmall-cliparts.html&psig=AOvVaw1zhZBxKQrfiBI-ntHNunOS&ust=1670536744999000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCOD0lbzA6PsCFQAAAAAdAAAAABAE','https://www.google.com/url?sa=i&url=https%3A%2F%2Fhelloartsy.com%2Fhow-to-draw-a-small-cat%2F&psig=AOvVaw1zhZBxKQrfiBI-ntHNunOS&ust=1670536744999000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCOD0lbzA6PsCFQAAAAAdAAAAABAT']),
            'order' => $this->faker->numberBetween(1, 10),
            'galleries_id' => Gallery::inRandomOrder()->first()->id,

        ];
    }
}