<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class; 

    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [    
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(250),
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ];
    }
}
