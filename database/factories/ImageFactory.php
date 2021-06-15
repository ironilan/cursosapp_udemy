<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //el valor false hace q solo guarde el nombre de la imagen, si pones true guardara toda la url
        return [
            'url' => 'courses/'.$this->faker->image('public/storage/courses', 640, 480, null, false)
        ];
    }
}
