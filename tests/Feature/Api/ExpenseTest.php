<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expense;

use App\Models\Trip;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseTest extends TestCase
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
    public function it_gets_expenses_list()
    {
        $expenses = Expense::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.expenses.index'));

        $response->assertOk()->assertSee($expenses[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_expense()
    {
        $data = Expense::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.expenses.store'), $data);

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_expense()
    {
        $expense = Expense::factory()->create();

        $trip = Trip::factory()->create();
        $user = User::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber(2),
            'description' => $this->faker->sentence(15),
            'user_id' => $this->faker->randomNumber,
            'trip_id' => $this->faker->randomNumber,
            'type' => $this->faker->word,
            'trip_id' => $trip->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.expenses.update', $expense),
            $data
        );

        $data['id'] = $expense->id;

        $this->assertDatabaseHas('expenses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->deleteJson(route('api.expenses.destroy', $expense));

        $this->assertSoftDeleted($expense);

        $response->assertNoContent();
    }
}
