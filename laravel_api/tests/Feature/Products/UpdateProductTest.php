<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /** @test */
    use WithFaker;
    public function user_can_update_product_if_valid_data_with_put_method()
    {
        $product = Product::factory()->create();
        $response = $this->json('PUT', "/api/products/{$product->id}",[
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(250),
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(fn (AssertableJson $json)=>
            $json->has('message')
                 ->has('data', fn (AssertableJson $json)=>
                     $json->where('id', $product->id)
                          ->etc()                 
                 )
                 ->etc()
        );
    }

    /** @test */
    public function user_can_not_update_product_if_not_valid_data_with_put_method()
    {
        $product = Product::factory()->create();

        $response = $this->json('PUT', "/api/products/{$product->id}",[
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(250),
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ]);
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonValidationErrors(['name']);


        $response = $this->json('PUT', "/api/products/{$product->id}",[
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ]);
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonValidationErrors(['name', 'slug', 'description']);


        $response = $this->json('PUT', "/api/products/{$product->id}",[]);
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonValidationErrors(['name', 'slug', 'description', 'price']);
    }

    /** @test */
    public function user_can_not_update_product_if_not_exists()
    {
        $product_id = -1;

        $response = $this->json('PUT', "/api/products/{$product_id}",[
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(250),
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json)=>
            $json->where('status_code', Response::HTTP_NOT_FOUND)
                 ->etc()
        );
    }

    /** @test */
    public function user_can_update_product_if_valid_data_with_patch_method()
    {
        $product = Product::factory()->create();

        $response = $this->json('PATCH', "/api/products/{$product->id}",[]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json)=>
            $json->has('message')
                 ->has('data', fn (AssertableJson $json)=>
                    $json->where('name', $product->name)
                         ->etc()
                 )
                 ->etc()
        );

        $newName = $this->faker->name;
        $updateProduct = [
            'name' => $newName,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(250),
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ];
        $response = $this->json('PATCH', "/api/products/{$product->id}",$updateProduct);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json)=>
            $json->has('message')
                 ->has('data', fn (AssertableJson $json)=>
                    $json->where('name', $newName)
                         ->etc()
                 )
                 ->etc()
        );
    }

    /** @test */
    public function user_can_not_update_product_if_not_valid_data_with_patch_method()
    {
        $product_id = -1;

        $response = $this->json('PATCH', "/api/products/{$product_id}",[]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json)=>
            $json->where('status_code', Response::HTTP_NOT_FOUND)
                 ->etc()
        );
    }
}
