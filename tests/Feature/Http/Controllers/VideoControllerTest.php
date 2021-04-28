<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use App\Order;
use App\Video;
use App\Lesson;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_sets_last_video_and_display_view()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create();
        $this->withoutExceptionHandling();
        $response = $this->actingAs($user)->get(route('videos.show', $video->id));

        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('now_playing', $video);

        $user->refresh();
        $this->assertEquals($video->id, $user->last_viewed_video_id);
    }

    /** @test */
    public function show_returns_403_when_user_does_not_have_access()
    {
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create([
            'product_id' => Product::FULL
        ]);
        $video = factory(Video::class)->create([
            'lesson_id' => $lesson->id
        ]);
        $order = factory(Order::class)->create([
            'user_id' => $user->id,
            'product_id' => Product::STARTER
        ]);

        $response = $this->actingAs($user)->get(route('videos.show', $video->id));
        $response->assertForbidden();
    }
}
