<?php

namespace Database\Factories;

use App\Models\Picture;
use Illuminate\Database\Eloquent\Factories\Factory;

class PictureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Picture::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $file_name = $this->faker->imageUrl(600,480);
        return [
            'file_name' => $file_name,
            'file_path' => 'storage/pictures/' . $file_name,
            'title' => Str::random(10),
            'post_comment' => $this -> faker -> text(30),
            'favorites_count' => 0,
        ];
    }
}
