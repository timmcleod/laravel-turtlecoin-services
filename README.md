# TurtleCoin Services for Laravel

TurtleCoin Services is a package that wraps the TurtleCoin JSON-RPC services for Laravel. This package makes it
easy to work with all of the TurtleCoin RPC APIs (TurtleCoind and turtle-services). The wallet services are bundled 
with this package so that you can get started quickly right in your Homestead vagrant box. No need to download the 
entire blockchain, just connect to any of the available public nodes (i.e. node.trtl.io).

---

1) [Install TurtleCoin Services for Laravel](#install-turtlecoin-services-for-laravel)
1) [Examples](#examples)
1) [Docs](#docs)
1) [License](#license)

---

## Install TurtleCoin Services for Laravel

This package requires PHP >=7.1.3.

First, require this package with composer in your Laravel 5.x project:
```
composer require turtlecoin/laravel-turtlecoin-services
```

Then, publish the config file for this package to `config/turtlecoin.php` using:
```
php artisan vendor:publish --tag=turtlecoin
```

Add these to your .env:
```
TC_DAEMON_HOST=http://node.trtl.io
TC_DAEMON_PORT=11898
TC_WALLET_SERVICE_HOST=http://localhost
TC_WALLET_SERVICE_PORT=8070
TC_WALLET_SERVICE_RPC_PASSWORD=rpcpassw0rd
TC_WALLET_DIRECTORY=../wallet
TC_WALLET_FILENAME=master.wallet
TC_WALLET_PASSWORD=walletpassw0rd
```

Configuration notes:
* If you're not running your own TurtleCoin node, you may use any of the available public nodes for `TC_DAEMON_HOST`.
* Change the passwords to stronger passwords in `TC_WALLET_SERVICE_RPC_PASSWORD` and `TC_WALLET_PASSWORD`.
* The wallet service (turtle-services) is bundled with this package. If you want to run the bundled wallet service, set `TC_WALLET_SERVICE_HOST` to `http://localhost`.
* The location of the wallet file in the example above is suggested for development if you're using a Homestead vagrant box. The wallet service may fail to start if the file is located in the directory that your vagrant box shares with your OS (i.e. your project directory).
* Be sure to set your wallet password before starting your wallet service, since the wallet needs to be created before the wallet service runs.

Create a wallet container:
```
php artisan turtlecoin:create-wallet
```

Start the bundled wallet service for your wallet container:
```
php artisan turtlecoin:start-wallet
```

Or you may run it in the background:
```
php artisan turtlecoin:start-wallet --background-process
```

## Examples

All of the TurtleCoin APIs may be accessed through the `TurtleCoin` facade. To call methods exposed through a node 
(TurtleCoind daemon), use `TurtleCoin::node()`. To call methods available through the wallet service (turtle-service),
use `TurtleCoin::wallet()`. Examples below:

#### TurtleCoin Node API Example
```php
echo TurtleCoin::node()->getHeight();

> {"height":948526,"network_height":948526,"status":"OK"}
``` 

#### Wallet API Example
```php
echo TurtleCoin::wallet()->getBalance($walletAddress);

> {"id":0,"jsonrpc":"2.0","result":["availableBalance":100,"lockedAmount":50]}
``` 

Or you may wish to access the `result` field directly as an array:

```php
$response = TurtleCoin::wallet()->getBalance($walletAddress);

// The result field from the RPC response
$response->result();

array:2 [▼
  "availableBalance" => 10000
  "lockedAmount" => 0
]
```

Optionally, you may access other details about the response:

```php
$response = TurtleCoin::wallet()->getBalance($walletAddress);

// Full RPC response as JSON string
$response->toJson();

// Full RPC response as an array
$response->toArray();

// Or other response details
$response->getStatusCode();
$response->getProtocolVersion();
$response->getHeaders();
$response->hasHeader($header);
$response->getHeader($header);
$response->getHeaderLine($header);
$response->getBody();
``` 

## Docs

Documentation of the TurtleCoin RPC API can be found at [api-docs.turtlecoin.lol](https://api-docs.turtlecoin.lol).

## License

TurtleCoin Services for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

[Laravel](http://laravel.com) is a trademark of Taylor Otwell.
