<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeyValueTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $storedData = [
            'key' => 'mykey',
            'value' => ['foo' => 'bar']
        ];

        $response = $this->postJson('/api/object', $storedData);
    
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    
        $this->assertDatabaseHas('key_values', [
            'key' => $storedData['key'],
            'value' => $this->castAsJson($storedData['value'])
        ]);
    }
}
