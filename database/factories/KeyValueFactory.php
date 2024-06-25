<?php

namespace Database\Factories;

use App\Models\KeyValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KeyValue>
 */
class KeyValueFactory extends Factory
{
    protected $model = KeyValue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word,
            'value' => json_encode(['foo' => 'bar']), // Example JSON value
        ];
    }
}
