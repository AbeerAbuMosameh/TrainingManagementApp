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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],


    'google' => [
        'client_id' => env('GOOGLE_ClIENT_ID'),
        'client_secret' => env('GOOGLE_ClIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],
    'firebase' => [
        'credential' => storage_path('app/Http/Controllers/Admin/it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json'),
        'database_url' => 'https://it-training-app-386209-default-rtdb.firebaseio.com/',
        'storage_bucket' => 'gs://it-training-app-386209.appspot.com/',
    ],
];
