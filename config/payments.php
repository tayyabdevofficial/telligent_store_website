<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | The default payment gateway to use when multiple or no explicit gateway
    | is specified.
    |
    */
    'default' => env('DEFAULT_PAYMENT_GATEWAY', 'xsolla'),

    /*
    |--------------------------------------------------------------------------
    | Payment Gateways Configuration
    |--------------------------------------------------------------------------
    |
    | Each gateway has its own credentials, settings, and an enabled flag that
    | can be toggled via your environment variables (.env).
    |
    */
    'gateways' => [
        'stripe' => [
            'name' => 'Stripe (Cards, Digital Wallets)',
            'enabled' => env('STRIPE_ENABLED', false),
            'key' => env('STRIPE_PUBLISHABLE_KEY'),
            'secret' => env('STRIPE_SECRET_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],

        'xsolla' => [
            'name' => 'Xsolla (Credit Card, PayPal, Local Methods)',
            'enabled' => env('XSOLLA_ENABLED', true),
            'merchant_id' => env('XSOLLA_MERCHANT_ID'),
            'project_id' => env('XSOLLA_PROJECT_ID'),
            'api_key' => env('XSOLLA_API_KEY'),
            'webhook_secret' => env('XSOLLA_WEBHOOK_SECRET'),
            'sandbox' => (bool) env('XSOLLA_SANDBOX', true),
        ],
    ],

];

