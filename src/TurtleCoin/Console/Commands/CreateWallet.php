<?php

namespace TurtleCoin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;

class CreateWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turtlecoin:create-wallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new wallet file.';

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

        if (empty($walletPassword))
        {
            $this->error('You must specify both WALLET_PASSWORD.');
            return;
        }

        if (!$this->files->exists($walletDir))
        {
            $this->info(shell_exec("mkdir $walletDir"));
        }

        if (!$this->files->exists("$walletDir/$walletFilename"))
        {
            $this->info("Generating wallet container...");
            $this->info(shell_exec("$walletService -w $walletDir/$walletFilename -p $walletPassword -l $walletDir/service.log -g"));
            $this->info("Wallet container has been created.");
        }
    }
}
