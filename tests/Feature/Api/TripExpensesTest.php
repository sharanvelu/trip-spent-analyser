<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripExpensesTest extends TestCase
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
    public function it_gets_trip_expenses()
    {
        $trip = Trip::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'trip_id' => $trip->id,
            ]);

        $response = $this->getJson(route('api.trips.expenses.index', $trip));

        $response->assertOk()->assertSee($expenses[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_trip_expenses()
    {
        $trip = Trip::factory()->create();
        $data = Expense::factory()
            ->make([
                'trip_id' => $trip->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.trips.expenses.store', $trip),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals($trip->id, $expense->trip_id);
    }
}
