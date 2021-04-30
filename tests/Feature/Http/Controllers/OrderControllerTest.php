<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Order;
use App\Product;
use Tests\TestCase;
use App\Services\PaymentGateway;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function purchase_a_course()
    {
        $this->withoutExceptionHandling();
        $event = Event::fake();
        $mail = Mail::fake();
        $product = factory(Product::class)->create();
        $token = $this->faker->md5;

        $paymentGateway = $this->mock(PaymentGateway::class);
        $paymentGateway->shouldReceive('charge')
            ->with($token, \Mockery::type(Order::class))
            ->andReturn('charge-id');

        $response = $this->post(route('order.store'), [
            'product_id' => $product->id,
            'stripeToken' => $token,
            'stripeEmail' => $this->faker->safeEmail,
        ]);

        $event->assertDispatched('order.placed');
        $mail->assertSent(OrderConfirmation::class);
        $response->assertRedirect('/users/edit');
        // order record in database
        // event was fired
        // mail sent
        // user was logged in
    }
}
