<?php

namespace TurtleCoin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;

class StartWalletService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turtlecoin:start-wallet {--background-process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts wallet service.';

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->config = $this->laravel->make('config');
        $this->files = $this->laravel['files'];

        $walletService = __DIR__ . '/../../../../services/turtlecoin-v0.8.4/turtle-service';
        $walletDir = $this->config->get('turtlecoin.wallet_directory');
        $walletFilename = $this->config->get('turtlecoin.wallet_filename');
        $walletPassword = $this->config->get('turtlecoin.wallet_password');
        $rpcPassword = $this->config->get('turtlecoin.wallet_service_rpc_password');
        $daemonHost = $this->config->get('turtlecoin.daemon_host');
        $daemonPort = $this->config->get('turtlecoin.daemon_port');

        if (empty($walletPassword) || empty($rpcPassword))
        {
            $this->error('You must specify both WALLET_PASSWORD and WALLET_SERVICE_RPC_PASSWORD.');
            return;
        }

        if (!$this->files->exists("$walletDir/$walletFilename"))
        {
            $this->error('You must create a wallet before starting the wallet service.');
            $this->info('Create a new wallet using: php artisan turtlecoin:create-wallet');
        }

        $this->info("Starting wallet service...");

        $this->info(
            "████████╗██╗  ██╗██████╗ ████████╗██╗    ██████╗ █████╗ █████╗ ██╗███╗   ██╗" . PHP_EOL .
            "╚══██╔══╝██║  ██║██╔══██╗╚══██╔══╝██║    ██╔═══╝██╔═══╝██╔══██╗██║████╗  ██║" . PHP_EOL .
            "   ██║   ██║  ██║██████╔╝   ██║   ██║    ████╗  ██║    ██║  ██║██║██╔██╗ ██║" . PHP_EOL .
            "   ██║   ██║  ██║██╔══██╗   ██║   ██║    ██╔═╝  ██║    ██║  ██║██║██║╚██╗██║" . PHP_EOL .
            "   ██║   ╚█████╔╝██║  ██║   ██║   ██████╗██████╗╚█████╗╚█████╔╝██║██║ ╚████║" . PHP_EOL .
            "   ╚═╝    ╚════╝ ╚═╝  ╚═╝   ╚═╝   ╚═════╝╚═════╝ ╚════╝ ╚════╝ ╚═╝╚═╝  ╚═══╝" . PHP_EOL
        );

        $cmd = "$walletService -w $walletDir/$walletFilename -p $walletPassword -l $walletDir/service.log" .
            " --rpc-password $rpcPassword --daemon-address=$daemonHost --daemon-port=$daemonPort";

        if ($this->option('background-process')) $cmd .= " > /dev/null 2>/dev/null &";

        $this->info(shell_exec($cmd));
    }
}
