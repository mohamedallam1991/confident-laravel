<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use App\Coupon;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_store_coupon_and_redirect()
    {
        //$this->withoutExceptionHandling();
        // coupon not expired and not used for a happy path
        // we need coupon from database
        $coupon1 = factory(Coupon::class)->create();
        $coupon2 = factory(Coupon::class)->create();

        $this->get('/promotions/'. $coupon1->code)
            ->assertRedirect('/#buy-now')
            ->assertSessionHas('coupon_id', $coupon1->id);

        $this->get('/promotions/'. $coupon2->code)
            ->assertRedirect('/#buy-now')
            ->assertSessionHas('coupon_id', $coupon2->id);
            return;
    }

    /** @test */
    public function it_does_not_store_coupon_for_invalid_code()
    {
        return $this->get('/promotions/invalid-code')
            ->assertRedirect('/#buy-now')
            ->assertSessionMissing('coupon_id');
    }

    /** @test */
    public function it_does_not_store_for_expired_code()
    {
        $coupon = factory(Coupon::class)->create([
            'expired_at' => now(),
        ]);

        $this->get('/promotions/'. $coupon->code)
            ->assertRedirect('/#buy-now')
            ->assertSessionMissing('coupon_id');
    }

    /** @test */
    public function it_does_not_store_a_previously_used_coupon()
    {
        $user = factory(User::class)->create();
        $coupon = factory(Coupon::class)->create();
        $order = factory(Order::class)->create([
            'user_id' => $user->id,
            'coupon_id' => $coupon->id,
        ]);

        $this->actingAs($user)->get('/promotions/'.$coupon->code)
            ->assertRedirect('/#buy-now')
            ->assertSessionMissing('coupon_id');
    }
}
