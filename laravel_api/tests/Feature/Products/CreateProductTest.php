<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    /** @test */
    use WithFaker;
    use DatabaseTransactions;
    public function user_can_create_new_product()
    {
        // $product = Product::factory()->make();
        $response = $this->json('POST', 'api/products', [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(250),
            'price'=> $this->faker->randomFloat(2, 50, 999),
        ]);
        // $product_id = $product->id;
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json)=>
            $json->has('message')
                 ->has('data', fn (AssertableJson $json)=>
                     $json->where('id', Product::latest()->first()->id)
                          ->etc()
                 )->etc()
        );
    }

    /** @test */
    public function user_can_not_create_new_product()
    {
        //no data
        $response = $this->json('POST', 'api/products', []);
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonValidationErrors(['name', 'slug', 'description','price']);

        //send 1 column
        $response = $this->json('POST', 'api/products', ['name' => 'test']);
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonValidationErrors(['slug', 'description','price']);

        //send full-1
        $response = $this->json('POST', 'api/products', ['name'=>'test', 'slug'=>'test','description'=>'test']);
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonValidationErrors(['price']);
    }
}
