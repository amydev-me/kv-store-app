<?php

namespace Tests\Feature;

use App\Models\KeyValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class KeyValueTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    #[Test]
    public function it_can_store_a_key_value_pair(): void
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

    #[Test]
    public function it_can_get_the_latest_value_by_key()
    {
        $key = 'mykey';
        $value1 = ['foo' => 'bar'];
        $value2 = ['foo' => 'baz'];

        // Create initial record
        KeyValue::create(['key' => $key, 'value' => json_encode($value1)]);

        // Create latest record
        KeyValue::create(['key' => $key, 'value' => json_encode($value2)]);

        // Make GET request to fetch the latest value by key
        $response = $this->getJson("/api/object/{$key}");

        // Assert the response
        $response->assertStatus(200)
                 ->assertJson($value2);
    }
}
