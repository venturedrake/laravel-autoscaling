<?php

/*
|--------------------------------------------------------------------------
| Linodes
|--------------------------------------------------------------------------
|
| g6-nanode-1 - Nanode 1 GB
| g6-standard-1 - Linode 2GB
| g6-standard-2 - Linode 4GB
| g6-standard-4 - Linode 8GB
| g6-standard-6 - Linode 16GB
| g6-standard-8 - Linode 32GB
| g6-standard-16 - Linode 64GB
| g6-standard-20 - Linode 96GB
| g6-standard-24 - Linode 128GB
| g6-standard-32 - Linode 192GB
|
| g6-dedicated-2 - Dedicated 4GB
| g6-dedicated-4 - Dedicated 8GB
| g6-dedicated-8 - Dedicated 16GB
| g6-dedicated-16 - Dedicated 32GB
| g6-dedicated-32 - Dedicated 64GB
| g6-dedicated-48 - Dedicated 96GB
| g6-dedicated-50 - Dedicated 128GB
| g6-dedicated-56 - Dedicated 256GB
| g6-dedicated-64 - Dedicated 512GB
|
| g7-highmem-1 - Linode 24 GB
| g7-highmem-2 - Linode 48 GB
| g7-highmem-4 - Linode 90 GB
| g7-highmem-8 - Linode 150 GB
| g7-highmem-16 - Linode 300 GB
|
*/

return [
    'forge_api_token' => env('LARAVEL_AUTOSCALING_FORGE_API_TOKEN', ''),
    'linode_api_token' => env('LARAVEL_AUTOSCALING_LINODE_API_TOKEN', ''),
    'timezone' => env('LARAVEL_AUTOSCALING_TIMEZONE', 'UTC'),
    'load_balancer' => [
        'name' => env('LARAVEL_AUTOSCALING_LOAD_BALANCER', ''),
        'ip' => env('LARAVEL_AUTOSCALING_LOAD_BALANCER_IP', ''),
    ],
    'vertical' => [
        'enabled' => env('LARAVEL_AUTOSCALING_VERTICAL_ENABLED', false),
        'min_running' => 1,
        'servers' => [
            'server-1' => [
                'hourly' => [
                    '0800' => 'g6-standard-2', // Linode 4GB
                    '1800' => 'g6-standard-1', // Linode 2GB
                ],
            ],
            'server-2' => [
                'hourly' => [
                    '0815' => 'g6-standard-2', // Linode 4GB
                    '1815' => 'g6-standard-1', // Linode 2GB
                ],
            ],
            'server-3' => [
                'hourly' => [
                    '0840' => 'g6-standard-2', // Linode 4GB
                    '1830' => 'g6-standard-1', // Linode 2GB
                ],
            ],
        ],
    ],
    'horizontal' => [
        'enabled' => env('LARAVEL_AUTOSCALING_HORIZONTAL_ENABLED', false),
        'min_servers' => 1,
        'max_servers' => 5,
        'hourly' => [
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => [],
            8 => [],
            9 => [],
            10 => [],
            11 => [],
            12 => [],
            13 => [],
            14 => [],
            15 => [],
            16 => [],
            17 => [],
            18 => [],
            19 => [],
            20 => [],
            21 => [],
            22 => [],
            23 => [],
            24 => [],
        ],
        'daily' => [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
        ],
        'weekly' => [
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => [],
            8 => [],
            9 => [],
            10 => [],
            11 => [],
            12 => [],
            13 => [],
            14 => [],
            15 => [],
            16 => [],
            17 => [],
            18 => [],
            19 => [],
            20 => [],
            21 => [],
            22 => [],
            23 => [],
            24 => [],
            25 => [],
            26 => [],
            27 => [],
            28 => [],
            29 => [],
            30 => [],
            31 => [],
            32 => [],
            33 => [],
            34 => [],
            35 => [],
            36 => [],
            37 => [],
            38 => [],
            39 => [],
            40 => [],
            41 => [],
            42 => [],
            43 => [],
            44 => [],
            45 => [],
            46 => [],
            47 => [],
            48 => [],
            49 => [],
            50 => [],
            51 => [],
            52 => [],
        ],
        'monthly' => [
            'january' => [],
            'february' => [],
            'march' => [],
            'april' => [],
            'may' => [],
            'june' => [],
            'july' => [],
            'august' => [],
            'september' => [],
            'october' => [],
            'november' => [],
            'december' => [],
        ],
    ],
];
