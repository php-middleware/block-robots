# block-robots middleware [![Build Status](https://travis-ci.org/php-middleware/block-robots.svg)](https://travis-ci.org/php-middleware/block-robots)
Middleware to avoid search engine indexing

This middleware provide framework-agnostic possibility to preventing your site from being indexed.

## How it works?

* Add `X-Robots-Tag` with `noindex, nofollow` value.
* Add `robots.txt` with `Disallow: /` body

## Installation

```json
{
    "require": {
        "php-middleware/block-robots": "^1.0.0"
    }
}
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
