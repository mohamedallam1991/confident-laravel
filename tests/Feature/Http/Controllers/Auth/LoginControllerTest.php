<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function login_redirects_to_dashboard()
    {
        // as a guest we have a user created from factory
        $user = factory(User::class)->create();
        $this->assertGuest();
        // we act logging in
        $response = $this->post('/login',[
            'email' => $user->email,
            'password' => 'password',
        ]);
        // we assert we get logged in and we are redirected properly
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
