<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UsersControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function update_saves_data_and_redirect_to_dashboard()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $name = $this->faker->name();
        $password = $this->faker->password(8);

        $response = $this->actingAs($user)->put('/users', [
            'name' => $name,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect('/dashboard');

        $user->refresh();
        $this->assertEquals($name, $user->name);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    /** @test */
    public function update_fails_for_invalid_name()
    {
        $user = factory(User::class)->create();
        $password = $this->faker->password(8);

        $response = $this->from(route('user.edit'))
            ->actingAs($user)
            ->put('/users', [
                'name' => null,
                'password' => $password,
                'password_confirmation' => $password,
            ]);

        $response->assertRedirect(route('user.edit'));
        $response->assertSessionHasErrors('name');
        $this->assertNotNull($user->name);
    }

    /** @test */
    public function update_fails_for_null_password()
    {
        $user = factory(User::class)->create();

        $response = $this->from(route('user.edit'))
            ->actingAs($user)
            ->put('/users', [
                'name' => $this->faker->name,
                'password' => null,
                'password_confirmation' => null,
            ]);

        $response->assertRedirect(route('user.edit'));
        $response->assertSessionHasErrors('password');
        $this->assertNotNull($user->name);
    }
}
