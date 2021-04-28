<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class WatchesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function stores_returns_a_204()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create();
        $this->withoutExceptionHandling();

        $mock = \Mockery::mock();
        $mock->shouldReceive('info') // or expects('info') this will make sure its called at least once
            ->once()
            ->with('video.watched', [$video->id]);

        Log::swap($mock);

        $response = $this->actingAs($user)->post(route('watches.store'), [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
        $response->assertStatus(204);
    }
}
