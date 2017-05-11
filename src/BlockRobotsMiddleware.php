<?php

namespace PhpMiddleware\BlockRobots;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use PhpMiddleware\DoublePassCompatibilityTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class BlockRobotsMiddleware implements MiddlewareInterface
{
    use DoublePassCompatibilityTrait;

    const ROBOTS_HEADER = 'X-Robots-Tag';

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($this->isRobotsTxt($request)) {
            return $this->createRobotsTxtResponse();
        }

        $response = $delegate->process($request);

        return $this->attachRobotsHeaderTo($response);
    }

    private function createRobotsTxtResponse()
    {
        $response = new Response('php://memory', 200, ['Content-Type' => 'text/plain']);
        $response->getBody()->write("User-Agent: *\nDisallow: /");

        return $response;
    }

    private function isRobotsTxt(ServerRequestInterface $request)
    {
        return $request->getUri()->getPath() === '/robots.txt';
    }

    private function attachRobotsHeaderTo(ResponseInterface $response)
    {
        return $response->withHeader(self::ROBOTS_HEADER, 'noindex, nofollow');
    }
}
