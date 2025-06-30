<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Microservices Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for inter-service communication between microservices
    |
    */

    'advisor' => [
        'url' => env('ADVISOR_SERVICE_URL', 'http://advisor-service'),
        'secret' => env('ADVISOR_SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024'),
    ],

    'trainee' => [
        'url' => env('TRAINEE_SERVICE_URL', 'http://trainee-service'),
        'secret' => env('TRAINEE_SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024'),
    ],

    'task' => [
        'url' => env('TASK_SERVICE_URL', 'http://task-service'),
        'secret' => env('TASK_SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024'),
    ],

    'user' => [
        'url' => env('USER_SERVICE_URL', 'http://user-service'),
        'secret' => env('USER_SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024'),
    ],

    'field' => [
        'url' => env('FIELD_SERVICE_URL', 'http://field-service'),
        'secret' => env('FIELD_SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024'),
    ],

];
