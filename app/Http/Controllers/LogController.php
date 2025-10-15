<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLogsRequest;
use App\Http\Resources\LogResource;
use App\Models\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class LogController extends Controller
{
    #[OA\Get(
        path: "/api/logs",
        summary: "Get logs",
        tags: ["Logs"],
        parameters: [
            new OA\Parameter(
                name: "page",
                description: "Page number",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", example: 1)
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Per page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", example: 10)
            ),
            new OA\Parameter(
                name: "event",
                description: "Event",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", example: "created")
            ),
            new OA\Parameter(
                name: "user_id",
                description: "User id",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", example: "0199ed04-f3ca-7355-a82e-e53bd1528cc1")
            ),
            new OA\Parameter(
                name: "from_date",
                description: "From date",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "date", example: "2025-10-15")
            ),
            new OA\Parameter(
                name: "to_date",
                description: "To date",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "date", example: "2025-10-16")
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new OA\JsonContent(ref: "#/components/schemas/LogListResponse")
            ),
        ]
    )]
    public function index(GetLogsRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        $perPage = $validated['per_page'] ?? 10;
        $page = $validated['page'] ?? 1;
        $event = $validated['event'] ?? null;
        $userId = $validated['user_id'] ?? null;
        $fromDate = $validated['from_date'] ?? null;
        $toDate = $validated['to_date'] ?? null;

        $query = Log::query();

        if ($event) {
            $query->where('event', 'LIKE', "%{$event}%");
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        $query->orderBy('created_at', 'DESC');

        $tasks = $query->paginate($perPage, ['*'], 'page', $page);

        return LogResource::collection($tasks);
    }
}
