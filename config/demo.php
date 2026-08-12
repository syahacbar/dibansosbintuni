<?php

return [
    'enabled' => (bool) env('DEMO_MODE', false),

    'reset_allowed' => (bool) env('DEMO_RESET_ALLOWED', false),

    'auto_reset' => (bool) env('DEMO_AUTO_RESET', false),

    /*
    |--------------------------------------------------------------------------
    | Public application base path
    |--------------------------------------------------------------------------
    |
    | The Nginx gateway passes this path as X-Forwarded-Prefix after removing
    | it before proxying upstream. Keep this value empty for root/standalone
    | deployments and local development.
    |
    */
    'base_path' => env('DEMO_BASE_PATH') ? '/'.trim((string) env('DEMO_BASE_PATH'), '/') : '',
];
