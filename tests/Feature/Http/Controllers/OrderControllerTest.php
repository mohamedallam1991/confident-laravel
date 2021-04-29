<?php

namespace Tests\Feature\Http\Controllers;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function purchase_a_course()
    {
        $product = factory(Product::class)->create();

        $response = $this->post('order.store', [
            'product_id' => $product->id,
            'stripeToken' => $this->faker,
        ]);
        $response->assertStatus(200);
    }
}
