<?php

namespace TurtleCoin;

class TurtleCoinServices
{
    /** @var TurtleService */
    protected $walletService;

    /** @var TurtleCoind */
    protected $turtlecoind;

    /**
     * TurtleCoinServices constructor.
     *
     * @param string $walletServiceHost
     * @param int $walletServicePort
     * @param string $walletServiceRpcPassword
     * @param string $daemonHost
     * @param int $daemonPort
     */
    public function __construct(
        $walletServiceHost,
        $walletServicePort,
        $walletServiceRpcPassword,
        $daemonHost,
        $daemonPort
    ) {
        $this->walletService = new TurtleService([
            'rpcHost'     => $walletServiceHost,
            'rpcPort'     => $walletServicePort,
            'rpcPassword' => $walletServiceRpcPassword,
        ]);

        $this->turtlecoind = new TurtleCoind([
            'rpcHost' => $daemonHost,
            'rpcPort' => $daemonPort,
        ]);
    }

    /**
     * @return TurtleService
     */
    public function wallet()
    {
        return $this->walletService;
    }

    /**
     * @return TurtleCoind
     */
    public function node()
    {
        return $this->turtlecoind;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->node()->{$name}(...$arguments);
    }
}