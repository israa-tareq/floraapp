<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administrator Username
    |--------------------------------------------------------------------------
    |
    | The predefined username required to access the Flora administration panel.
    | Configured through the ADMIN_USERNAME environment variable.
    |
    */
    'username' => env('ADMIN_USERNAME', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Administrator Password Configuration
    |--------------------------------------------------------------------------
    |
    | Recommended: ADMIN_PASSWORD_HASH in .env holding a Bcrypt hash.
    | Fallback: ADMIN_PASSWORD in .env for local development convenience.
    |
    */
    'password_hash' => env('ADMIN_PASSWORD_HASH'),

    'password' => env('ADMIN_PASSWORD'),

];
