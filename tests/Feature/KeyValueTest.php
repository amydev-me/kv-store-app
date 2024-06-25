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
    // /**
    //  * A basic feature test example.
    //  */
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

    /**
     * Test retrieval of value by key.
     *
     * @return void
     */
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
                 ->assertJsonFragment($value2);
    }

    /**
     * Test retrieval of value at a specific timestamp.
     *
     * @return void
     */
    public function testRetrieveValueAtTimestamp()
    {
        $key = 'mykey';
        $value1 = ['foo' => 'bar'];
        $value2 = ['foo' => 'baz'];

        // Create records with identical created_at timestamps (simulating same second)
        KeyValue::create(['key' => $key, 'value' => json_encode($value1)]); 
        KeyValue::create(['key' => $key, 'value' => json_encode($value2)]);

        // Make GET request to fetch the value at the specific timestamp
        $timestamp = strtotime(now()); // Use current timestamp
        $response = $this->getJson("/api/object/{$key}?timestamp={$timestamp}");

        // Assert the response
        $response->assertStatus(200)
                 ->assertJson($value2);
    }

    /**
     * Test retrieval of value when no records exist at the specific timestamp.
     *
     * @return void
     */
    public function testRetrieveValueAtNonExistingTimestamp()
    {
        $key = 'nonexistent_key';
        $timestamp = strtotime(now()); // Use current timestamp

        // Make GET request to fetch the value at the specific timestamp
        $response = $this->getJson("/api/object/{$key}?timestamp={$timestamp}");

        // Assert the response
        $response->assertStatus(404)
                 ->assertJson(['error' => 'No value found for the given timestamp.']);
    }

     /**
     * Test pagination for fetching all records.
     *
     * @return void
     */
    public function testPaginationForAllRecords()
    {
        // Seed the database with 16 test records
        KeyValue::factory()->count(16)->create();

        // Make GET request to fetch the first page
        $response = $this->getJson('/api/object/get_all_records');

        // Assert response status
        $response->assertStatus(200);

        
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
        
    }
}
