<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;

use App\Models\Space;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_trips_list()
    {
        $trips = Trip::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.trips.index'));

        $response->assertOk()->assertSee($trips[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_trip()
    {
        $data = Trip::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.trips.store'), $data);

        unset($data['created_by']);

        $this->assertDatabaseHas('trips', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_trip()
    {
        $trip = Trip::factory()->create();

        $space = Space::factory()->create();
        $user = User::factory()->create();

        $data = [
            'space_id' => $this->faker->randomNumber,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'from_date' => $this->faker->date,
            'to_date' => $this->faker->date,
            'space_id' => $space->id,
            'created_by' => $user->id,
        ];

        $response = $this->putJson(route('api.trips.update', $trip), $data);

        unset($data['created_by']);

        $data['id'] = $trip->id;

        $this->assertDatabaseHas('trips', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_trip()
    {
        $trip = Trip::factory()->create();

        $response = $this->deleteJson(route('api.trips.destroy', $trip));

        $this->assertSoftDeleted($trip);

        $response->assertNoContent();
    }
}
