<?php

namespace Tests\Feature\Http\Controllers;

use App\Coupon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_store_coupon_and_redirect()
    {
        $this->withoutExceptionHandling();
        // coupon not expired and not used for a happy path
        // we need coupon from database
        $coupon = factory(Coupon::class)->create();
        $response = $this->get('/promotions/'. $coupon);

        //$response->assertSessionHas('coupon_id', $coupon->id);
        $response->assertRedirect('/#buy-now');
    }
}
