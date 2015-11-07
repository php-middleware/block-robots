<?php

namespace PhpMiddleware\BlockRobots;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class BlockRobotsMiddleware
{
    const ROBOTS_HEADER = 'X-Robots-Tag';

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        if ($request->getUri()->getPath() === '/robots.txt') {
            $newReponse = new Response('php://memory', 200, ['Content-Type' => 'text/plain']);
            $newReponse->getBody()->write("User-Agent: *\nDisallow: /");

            return $newReponse;
        }
        /* @var $out ResponseInterface */
        $response = $out === null ? $response : $out($request, $response);

        return $response->withHeader(self::ROBOTS_HEADER, 'noindex, nofollow');
    }
}
