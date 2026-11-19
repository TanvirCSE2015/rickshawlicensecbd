
<?php

return [
    'base_url' => env(
        'JANATAPAY_BASE_URL',
        'https://sandbox-pg.janatapay.com'
    ),

    'merchant_uid' => env('JANATAPAY_MERCHANT_UID'),
    'merchant_username' => env('JANATAPAY_MERCHANT_USERNAME'),
    'merchant_password' => env('JANATAPAY_MERCHANT_PASSWORD'),

    // Raw Base64 public key supplied by JanataPay.
    'public_key' => env('JANATAPAY_PUBLIC_KEY'),

    'currency' => env('JANATAPAY_CURRENCY', 'BDT'),

    // Leave empty until JanataPay confirms the exact success code.
    'status_codes' => [
        'initiated' => (int) env('JANATAPAY_STATUS_INITIATED', 1001),
        'sent_to_pgw' => (int) env('JANATAPAY_STATUS_SENT_TO_PGW', 1002),
        'success' => (int) env('JANATAPAY_STATUS_SUCCESS', 1003),
        'failed' => (int) env('JANATAPAY_STATUS_FAILED', 1004),
        'canceled' => (int) env('JANATAPAY_STATUS_CANCELED', 1005),
        'refunded' => (int) env('JANATAPAY_STATUS_REFUNDED', 1007),
    ],

    'timeout' => 30,
];
