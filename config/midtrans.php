<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Server & Client Key
    |--------------------------------------------------------------------------
    |
    | Ambil dari .env, gunakan SB-xxxx untuk sandbox
    | dan Mid-server-xxxx untuk production
    |
    */
    'server_key' => env('MIDTRANS_SERVER_KEY', ''), // server key dari .env
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''), // client key dari .env

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | false = sandbox, true = production
    |
    */
    'is_production' => (bool) env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitized & 3DS
    |--------------------------------------------------------------------------
    |
    | is_sanitized = true untuk membersihkan input transaksi
    | is_3ds = true untuk pembayaran kartu kredit 3D Secure
    |
    */
    'is_sanitized' => (bool) env('MIDTRANS_SANITIZED', true),
    'is_3ds'       => (bool) env('MIDTRANS_3DS', true),
];
