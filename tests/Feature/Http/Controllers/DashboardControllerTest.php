<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function It_retrives_the_last_video_watched()
    {
        $video = factory(Video::class)->create();
        $user = factory(User::class)->create([
            'last_viewed_video_id' => $video->id,
        ]);
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('now_playing', $video);
    }

    /** @test */
    public function it_defaults_last_video_for_a_new_user()
    {
        $video = factory(Video::class)->create();
        $user = factory(User::class)->create();

        $this->assertNull($user->last_viewed_video_id);
        $this->assertDatabaseHas(
            'users', [
                'id' => $user->id,
                'last_viewed_video_id' => null,
            ],
        );

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('now_playing', $video);

        $this->assertEquals($video->id, $user->last_viewed_video_id);
        $this->assertDatabaseHas(
            'users', [
                'id' => $user->id,
                'last_viewed_video_id' => $video->id,
            ],
        );
    }

}
