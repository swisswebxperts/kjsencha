<?php

namespace KJSencha;

use KJSencha\Controller\Factory\KjSenchaDataFactory;
use KJSencha\Controller\Factory\KjSenchaDirectFactory;

return [
    "factories" => [
        'kjsencha_direct' => KjSenchaDirectFactory::class,
        'kjsencha_data' => KjSenchaDataFactory::class
    ]
];