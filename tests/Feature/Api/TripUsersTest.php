<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripUsersTest extends TestCase
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
    public function it_gets_trip_users()
    {
        $trip = Trip::factory()->create();
        $user = User::factory()->create();

        $trip->users()->attach($user);

        $response = $this->getJson(route('api.trips.users.index', $trip));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_trip()
    {
        $trip = Trip::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.trips.users.store', [$trip, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $trip
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_trip()
    {
        $trip = Trip::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.trips.users.store', [$trip, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $trip
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
