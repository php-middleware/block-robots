# block-robots middleware [![Build Status](https://travis-ci.org/php-middleware/block-robots.svg?branch=master)](https://travis-ci.org/php-middleware/block-robots)
PSR-15 middleware to avoid search engine indexing with PSR-7

This middleware provide framework-agnostic possibility to preventing your site from being indexed.

## How it works?

* Add `X-Robots-Tag` header with `noindex, nofollow` value.
* Add `robots.txt` "file" with `User-Agent: * Disallow: /` body

## Installation

```bash
composer require php-middleware/block-robots
```

```php
$blockRobotsMiddleware = new PhpMiddleware\BlockRobots\BlockRobotsMiddleware();

$app = new MiddlewareRunner();
$app->add($blockRobotsMiddleware);
$app->run($request, $response);
```

## It's just works with any modern php framework!

Middleware tested on:
* [Expressive](https://github.com/zendframework/zend-expressive)

Middleware should works with:
* [Slim 3.x](https://github.com/slimphp/Slim)

And any other modern framework [supported middlewares and PSR-7](https://mwop.net/blog/2015-01-08-on-http-middleware-and-psr-7.html).
