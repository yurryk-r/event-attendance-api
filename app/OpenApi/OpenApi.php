<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Event Attendance API',
    version: '1.0.0',
    description: 'REST API for managing events, participants and users.'
)]
#[OA\Server(
    url: '/api',
    description: 'API server'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Enter your Sanctum token'
)]
class OpenApi
{
}