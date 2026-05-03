<?php

return [
    'storefront_name' => env('BUSINESS_STOREFRONT_NAME', 'Telligent Store'),
    'legal_name' => env('BUSINESS_LEGAL_NAME', 'Earntelligent Network Corporation'),
    'support_email' => env('BUSINESS_SUPPORT_EMAIL', env('MAIL_FROM_ADDRESS', 'support@telligentstore.com')),
    'support_phone' => env('BUSINESS_SUPPORT_PHONE'),
    'mailing_address' => env('BUSINESS_MAILING_ADDRESS'),
    'business_hours' => env('BUSINESS_HOURS', 'Mon to Sat, 9:00 AM to 7:00 PM PKT'),
];
