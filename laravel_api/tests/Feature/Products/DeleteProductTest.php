<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    /** @test */
    public function user_can_delete_product_if_exists()
    {
        $product = Product::factory()->create();
        $response = $this->json('DELETE', "api/products/{$product->id}");
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(fn (AssertableJson $json)=>
            $json->has('message')
                ->where('data', '')
                ->etc()
    );
    }
}
