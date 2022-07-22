<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTripsTest extends TestCase
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
    public function it_gets_user_trips()
    {
        $user = User::factory()->create();
        $trip = Trip::factory()->create();

        $user->trips2()->attach($trip);

        $response = $this->getJson(route('api.users.trips.index', $user));

        $response->assertOk()->assertSee($trip->name);
    }

    /**
     * @test
     */
    public function it_can_attach_trips_to_user()
    {
        $user = User::factory()->create();
        $trip = Trip::factory()->create();

        $response = $this->postJson(
            route('api.users.trips.store', [$user, $trip])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->trips2()
                ->where('trips.id', $trip->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_trips_from_user()
    {
        $user = User::factory()->create();
        $trip = Trip::factory()->create();

        $response = $this->deleteJson(
            route('api.users.trips.store', [$user, $trip])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->trips2()
                ->where('trips.id', $trip->id)
                ->exists()
        );
    }
}
