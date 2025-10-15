<?php

namespace Feature\Logs;

use App\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_index_success(): void
    {
        Log::factory()->count(20)->create();

        $response = $this->getJson(route('logs.index'));

        $response->dump()
            ->assertStatus(200);
    }

    public function test_log_index_search_event_success(): void
    {
        $searchEvent = 'TaskCreated';
        $otherEvent = 'TaskUpdated';
        $log1 = Log::factory()->create([
            'event' => $searchEvent,
        ]);
        $log2 = Log::factory()->create([
            'event' => $searchEvent,
        ]);
        $log3 = Log::factory()->create([
            'event' => $searchEvent,
        ]);
        $log4 = Log::factory()->create([
            'event' => $otherEvent,
        ]);

        $params = [
            'event' => $searchEvent,
        ];

        $response = $this->getJson(route('logs.index', $params));

        $response->dump()
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $log1->id,
                'event' => $searchEvent,
            ])
            ->assertJsonFragment([
                'id' => $log2->id,
                'event' => $searchEvent,
            ])
            ->assertJsonFragment([
                'id' => $log3->id,
                'event' => $searchEvent,
            ])
            ->assertJsonMissing([
                'id' => $log4->id,
                'event' => $otherEvent,
            ]);
    }

    public function test_log_index_search_user_id_success(): void
    {
        $searchUserId = '0199e665-75de-70f2-ba57-4c9f0263d9b4';
        $otherUserId = '0199ec39-ddfb-71cf-b180-d4dd495ab826';

        $log1 = Log::factory()->create([
            'user_id' => $searchUserId,
        ]);
        $log2 = Log::factory()->create([
            'user_id' => $searchUserId,
        ]);
        $log3 = Log::factory()->create([
            'user_id' => $searchUserId,
        ]);
        $log4 = Log::factory()->create([
            'user_id' => $otherUserId,
        ]);

        $params = [
            'user_id' => $searchUserId,
        ];

        $response = $this->getJson(route('logs.index', $params));

        $response->dump()
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $log1->id,
                'user_id' => $searchUserId,
            ])
            ->assertJsonFragment([
                'id' => $log2->id,
                'user_id' => $searchUserId,
            ])
            ->assertJsonFragment([
                'id' => $log3->id,
                'user_id' => $searchUserId,
            ])
            ->assertJsonMissing([
                'id' => $log4->id,
                'user_id' => $otherUserId,
            ]);
    }

    public function test_log_index_search_from_date_to_date_success(): void
    {
        $searchFromDate = '2025-10-01';
        $searchToDate = '2025-10-04';
        $otherDate = '2025-10-05';

        $log1 = Log::factory()->create([
            'created_at' => $searchFromDate,
        ]);
        $log2 = Log::factory()->create([
            'created_at' => $searchFromDate,
        ]);
        $log3 = Log::factory()->create([
            'created_at' => $searchToDate,
        ]);
        $log4 = Log::factory()->create([
            'created_at' => $otherDate,
        ]);

        $params = [
            'from_date' => $searchFromDate,
            'to_date' => $searchToDate,
        ];

        $response = $this->getJson(route('logs.index', $params));

        $response->dump()
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $log1->id,
            ])
            ->assertJsonFragment([
                'id' => $log2->id,
            ])
            ->assertJsonFragment([
                'id' => $log3->id,
            ])
            ->assertJsonMissing([
                'id' => $log4->id,
            ]);
    }
}
