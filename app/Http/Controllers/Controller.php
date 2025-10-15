<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "Logs API",
    title: "Logs API"
)]
#[OA\Server(
    url: "http://localhost:8001",
    description: "Logs API"
)]
abstract class Controller
{
    //
}
