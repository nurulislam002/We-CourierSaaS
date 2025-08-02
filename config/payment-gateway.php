<?php

use App\Enums\PaymentType;

return [
    'gateway-type' => [
        'bank' => PaymentType::BANK,
        'mobile' => PaymentType::MOBILE
    ]
];
