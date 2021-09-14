<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HMAC Secret
    |--------------------------------------------------------------------------
    |
    | The secret string used for hashing your data with a hmac function
    | You should define this value in your env file and reference it
    | in this file.
    |
    */
    'secret' => env('HMAC_VALIDATION_SECRET', ''),

];
