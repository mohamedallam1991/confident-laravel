<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function users_database_table_columns()
    {
        $this->assertTrue(
          Schema::hasColumns('users', [
            'id', 'name', 'email', 'password'
        ]));
    }
}
