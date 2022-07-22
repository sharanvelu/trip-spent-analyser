<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Space;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_spaces()
    {
        $spaces = Space::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('spaces.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.spaces.index')
            ->assertViewHas('spaces');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_space()
    {
        $response = $this->get(route('spaces.create'));

        $response->assertOk()->assertViewIs('app.spaces.create');
    }

    /**
     * @test
     */
    public function it_stores_the_space()
    {
        $data = Space::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('spaces.store'), $data);

        unset($data['created_by']);

        $this->assertDatabaseHas('spaces', $data);

        $space = Space::latest('id')->first();

        $response->assertRedirect(route('spaces.edit', $space));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_space()
    {
        $space = Space::factory()->create();

        $response = $this->get(route('spaces.show', $space));

        $response
            ->assertOk()
            ->assertViewIs('app.spaces.show')
            ->assertViewHas('space');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_space()
    {
        $space = Space::factory()->create();

        $response = $this->get(route('spaces.edit', $space));

        $response
            ->assertOk()
            ->assertViewIs('app.spaces.edit')
            ->assertViewHas('space');
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

        $response = $this->put(route('spaces.update', $space), $data);

        unset($data['created_by']);

        $data['id'] = $space->id;

        $this->assertDatabaseHas('spaces', $data);

        $response->assertRedirect(route('spaces.edit', $space));
    }

    /**
     * @test
     */
    public function it_deletes_the_space()
    {
        $space = Space::factory()->create();

        $response = $this->delete(route('spaces.destroy', $space));

        $response->assertRedirect(route('spaces.index'));

        $this->assertSoftDeleted($space);
    }
}
