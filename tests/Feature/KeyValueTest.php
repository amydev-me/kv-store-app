<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeyValueTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->postJson('/api/object', [
            'key' => 'mykey', 
            'value' => ['foo' => 'bar']
        ]);
         
        $response->assertStatus(201)->assertJson(['success' => true]);
        $this->assertDatabaseHas('key_value_store', [
            'key' => 'mykey',
            'value' => json_encode(['foo' => 'bar'])
        ]);
    }
}
