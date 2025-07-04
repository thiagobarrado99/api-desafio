<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API-DESAFIO",
    description: "API documentation for API-DESAFIO project."
)]
#[OA\Server(
    url: "http://localhost:8000/api",
    description: "Local server API"
)]
class OpenApiSpec {}