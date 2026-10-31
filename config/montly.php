<?php

declare(strict_types=1);

return [
    'institution' => [
        'name' => env('APP_NAME', 'Montly LMS'),
        'hierarchy' => ['school_year', 'grade', 'section', 'classroom', 'subject'],
        'schedule_export_format' => 'png',
    ],

    'rbac' => [
        'roles' => [
            'admin'    => ['level' => 'full',       'label' => 'Administrator'],
            'teacher'  => ['level' => 'moderate',   'label' => 'Teacher'],
            'student'  => ['level' => 'basic',      'label' => 'Student'],
            'guardian' => ['level' => 'read_only',  'label' => 'Parent / Guardian'],
            'alumni'   => ['level' => 'historical', 'label' => 'Alumni'],
            'support'  => ['level' => 'technical',  'label' => 'Support'],
        ],
    ],

    'jitsi' => [
        'domain' => env('JITSI_DOMAIN', 'meet.jit.si'),
        'app_id' => env('JITSI_APP_ID', 'montly-erp'),
        'room_prefix' => 'montly_',
    ],

    'notifications' => [
        'telegram_bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'resend_api_key' => env('RESEND_API_KEY'),
    ],
];
