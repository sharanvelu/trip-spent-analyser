<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Space;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
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
    public function it_gets_spaces_list()
    {
        $spaces = Space::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.spaces.index'));

        $response->assertOk()->assertSee($spaces[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_space()
    {
        $data = Space::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.spaces.store'), $data);

        unset($data['created_by']);

        $this->assertDatabaseHas('spaces', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_space()
    {
        $space = Space::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'created_by' => $user->id,
        ];

        $response = $this->putJson(route('api.spaces.update', $space), $data);

        unset($data['created_by']);

        $data['id'] = $space->id;

        $this->assertDatabaseHas('spaces', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_space()
    {
        $space = Space::factory()->create();

        $response = $this->deleteJson(route('api.spaces.destroy', $space));

        $this->assertSoftDeleted($space);

        $response->assertNoContent();
    }
}
