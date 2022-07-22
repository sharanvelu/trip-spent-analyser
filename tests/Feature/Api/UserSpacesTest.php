<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Space;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSpacesTest extends TestCase
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
    public function it_gets_user_spaces()
    {
        $user = User::factory()->create();
        $space = Space::factory()->create();

        $user->spaces()->attach($space);

        $response = $this->getJson(route('api.users.spaces.index', $user));

        $response->assertOk()->assertSee($space->name);
    }

    /**
     * @test
     */
    public function it_can_attach_spaces_to_user()
    {
        $user = User::factory()->create();
        $space = Space::factory()->create();

        $response = $this->postJson(
            route('api.users.spaces.store', [$user, $space])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->spaces()
                ->where('spaces.id', $space->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_spaces_from_user()
    {
        $user = User::factory()->create();
        $space = Space::factory()->create();

        $response = $this->deleteJson(
            route('api.users.spaces.store', [$user, $space])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->spaces()
                ->where('spaces.id', $space->id)
                ->exists()
        );
    }
}
