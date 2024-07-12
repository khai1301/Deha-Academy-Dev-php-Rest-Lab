<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // use DatabaseTransactions;
    /** @test */
    public function user_can_get_product_if_exists()
    {
        $product = Product::factory()->create();
        $product_id = $product->id;
        $response= $this->getJson("/api/products/{$product_id}");
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('message')
                ->has('data', fn (AssertableJson $json) =>
                    $json->where('id', $product_id)
                    ->etc()
                )->etc()
        );
    }

    /** @test */
    public function user_can_not_get_product_if_not_exists()
    {
        $product_id = -1;
        $response = $this->getJson("/api/products/{$product_id}");
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(fn (AssertableJson $json)=>
            $json->where('status_code', Response::HTTP_NOT_FOUND)
                 ->has('message')
    );
    }
}
