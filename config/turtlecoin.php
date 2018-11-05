<?php

return [
    'daemon_host'                 => env('TC_DAEMON_HOST', 'http://localhost'),
    'daemon_port'                 => env('TC_DAEMON_PORT', 11898),
    'wallet_service_host'         => env('TC_WALLET_SERVICE_HOST', 'http://localhost'),
    'wallet_service_port'         => env('TC_WALLET_SERVICE_PORT', 8070),
    'wallet_service_rpc_password' => env('TC_WALLET_SERVICE_RPC_PASSWORD'),
    'wallet_directory'            => base_path(env('TC_WALLET_DIRECTORY', '../wallet')),
    'wallet_filename'             => env('TC_WALLET_FILENAME', 'master.wallet'),
    'wallet_password'             => env('TC_WALLET_PASSWORD'),
];
