<?php

namespace PhpMiddleware\BlockRobots;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlockRobotsMiddleware
{
    const ROBOTS_HEADER = 'X-Robots-Tag';

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        if ($request->getUri()->getPath() === '/robots.txt') {
            $response->getBody()->write('Disallow: /');
            return $response->withHeader('Content-Type', 'text/plain');
        }
        /* @var $out ResponseInterface */
        $response = $out === null ? $response : $out($request, $response);

        return $response->withHeader(self::ROBOTS_HEADER, 'noindex, nofollow');
    }
}
