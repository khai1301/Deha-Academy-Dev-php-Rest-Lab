<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetListProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // use RefreshDatabase;

    /** @test */
    public function user_can_get_list_products()
    {
        // Product::factory()->count(50)->create();
        $totalProduct = Product::count();

        $response = $this->getJson('/api/products');
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(fn (AssertableJson $json)=>
            $json->has('data', fn (AssertableJson $json)
                =>$json->has('products', 10)
                       ->has('meta', fn (AssertableJson $json)=>
                            $json->where('total', $totalProduct)
                                 ->has('links', fn (AssertableJson $json)=>
                                        $json->where('current_page', 1)
                                             ->where('last_page', intval(ceil($totalProduct/10))) 
                                             ->etc()   
                                )
                                ->etc()
                                
                )
            )->etc()
        );
    }
}
