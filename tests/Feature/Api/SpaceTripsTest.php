<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;
use App\Models\Space;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTripsTest extends TestCase
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
    public function it_gets_space_trips()
    {
        $space = Space::factory()->create();
        $trips = Trip::factory()
            ->count(2)
            ->create([
                'space_id' => $space->id,
            ]);

        $response = $this->getJson(route('api.spaces.trips.index', $space));

        $response->assertOk()->assertSee($trips[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_space_trips()
    {
        $space = Space::factory()->create();
        $data = Trip::factory()
            ->make([
                'space_id' => $space->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.spaces.trips.store', $space),
            $data
        );

        unset($data['created_by']);

        $this->assertDatabaseHas('trips', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $trip = Trip::latest('id')->first();

        $this->assertEquals($space->id, $trip->space_id);
    }
}
