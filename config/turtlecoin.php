<?php

return [
    'daemon_host'                 => env('DAEMON_HOST', 'http://localhost'),
    'daemon_port'                 => env('DAEMON_PORT', 11898),
    'wallet_service_host'         => env('WALLET_SERVICE_HOST', 'http://localhost'),
    'wallet_service_port'         => env('WALLET_SERVICE_PORT', 8070),
    'wallet_service_rpc_password' => env('WALLET_SERVICE_RPC_PASSWORD'),
    'wallet_directory'            => base_path(env('WALLET_DIRECTORY', '../wallet')),
    'wallet_filename'             => env('WALLET_FILENAME', 'master.wallet'),
    'wallet_password'             => env('WALLET_PASSWORD'),
];
