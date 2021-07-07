<?php

return [
    'app_id' => env('TIM_APP_ID', ''),
    'app_secret' => env('TIM_APP_SECRET', ''),
    'userid' => env('TIM_USERID', ''),
    'sig_expire' => env('TIM_SIG_EXPIRE', 86400 * 180),
];
