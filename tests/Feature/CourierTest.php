<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Courier;

class CourierTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_courier()
    {
        $response = $this->postJson('/api/couriers', [
            'name' => 'Budi Agung',
            'email' => 'budi@test.com',
            'phone' => '08123456789',
            'level' => 3,
            'joined_at' => now()->toDateString()
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('couriers', [
            'email' => 'budi@test.com'
        ]);
    }

    public function test_delete_courier()
    {
        $courier = Courier::factory()->create();

        $response = $this->deleteJson("/api/couriers/{$courier->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('couriers', [
            'id' => $courier->id
        ]);
    }
}
