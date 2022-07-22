<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Space;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceUsersTest extends TestCase
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
    public function it_gets_space_users()
    {
        $space = Space::factory()->create();
        $user = User::factory()->create();

        $space->users()->attach($user);

        $response = $this->getJson(route('api.spaces.users.index', $space));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_space()
    {
        $space = Space::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.spaces.users.store', [$space, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $space
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_space()
    {
        $space = Space::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.spaces.users.store', [$space, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $space
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
