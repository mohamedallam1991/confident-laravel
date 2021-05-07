<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    //
    /** @test  */
    public function users_database_table_columns()
    {
        $this->assertTrue(
          Schema::hasColumns('users', [
            'id', 'name', 'email', 'email_verified_at', 'password', 'last_viewed_video_id',
        ]));
        $this->assertTrue(
          Schema::hasColumns('users', [
            'last_viewed_video_id',
        ]));
    }

    /** @test */
    public function videos_table_migrations()
    {
        $this->assertTrue(
            Schema::hasColumns('videos', [
                'id', 'title', 'heading', 'summary', 'vimeo_id', 'ordinal', 'lesson_id'
            ]));
        $this->assertTrue(
            Schema::hasColumns('videos', [
                'vimeo_sd_download_url', 'vimeo_hd_download_url',
            ]));
    }

    /** @test */
    public function watches_tabke_migration()
    {
        $this->assertTrue(
            Schema::hasColumns('watches', [
                'id', 'user_id', 'video_id'
            ]));
    }

    /** @test */
    public function products_table_migrations()
    {
        $this->assertTrue(
            Schema::hasColumns('products', [
                'id', 'name', 'price', 'ordinal'
            ]));
    }

    /** @test */
    public function orders_table_migration()
    {
        $this->assertTrue(
            Schema::hasColumns('orders', [
                'id', 'user_id', 'product_id', 'stripe_id', 'coupon_id', 'total'
            ]));
    }

    /** @test */
    public function coupons_table_migrations()
    {
        $this->assertTrue(
            Schema::hasColumns('coupons', [
                'id', 'code', 'percent_off', 'expired_at'
            ]));
    }

    /** @test */
    public function lessons_table_migrations()
    {
        $this->assertTrue(
            Schema::hasColumns('lessons', [
                'id', 'name', 'ordinal', 'product_id',
            ]));
    }
}
