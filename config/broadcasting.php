<?php
return [
  // Supported: "pusher", "redis", "log", "null"
  'default' => env('BROADCAST_DRIVER', 'pusher'),

  'connections' => [

    'pusher' => [
      'driver' => 'pusher',
      'key' => env('PUSHER_APP_KEY'),
      'secret' => env('PUSHER_APP_SECRET'),
      'app_id' => env('PUSHER_APP_ID'),
      'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
      ],
    ],

    'redis' => [
      'driver' => 'redis',
      'connection' => 'default',
    ],

    'log' => ['driver' => 'log'],

    'null' => ['driver' => 'null'],
  ],
];
