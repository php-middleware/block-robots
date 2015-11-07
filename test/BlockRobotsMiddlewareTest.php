<?php

namespace PhpMiddlewareTest\BlockRobots;

use PhpMiddleware\BlockRobots\BlockRobotsMiddleware;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class BlockRobotsMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    protected $middleware;

    protected function setUp()
    {
        $this->middleware = new BlockRobotsMiddleware();
    }

    public function testNoIndexHeader()
    {
        $request = new ServerRequest();
        $response = new Response();
        $calledOut = false;

        $outFunction = function ($request, $response) use (&$calledOut) {
            $calledOut = true;

            return $response;
        };

        /* @var $result ResponseInterface */
        $result = call_user_func($this->middleware, $request, $response, $outFunction);

        $this->assertTrue($calledOut, 'Out was not called');
        $this->assertNotSame($response, $result);
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals('noindex, nofollow', $result->getHeaderLine(BlockRobotsMiddleware::ROBOTS_HEADER));
    }

    public function testRobots()
    {
        $uri = new Uri('http://foo/robots.txt');
        $request = new ServerRequest([], [], $uri);
        $response = new Response();
        $calledOut = false;

        $outFunction = function ($request, $response) use (&$calledOut) {
            $calledOut = true;

            return $response;
        };

        /* @var $result ResponseInterface */
        $result = call_user_func($this->middleware, $request, $response, $outFunction);

        $this->assertFalse($calledOut, 'Out was called');
        $this->assertNotSame($response, $result);
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertFalse($result->hasHeader(BlockRobotsMiddleware::ROBOTS_HEADER));
        $this->assertSame("User-Agent: *\nDisallow: /", (string) $result->getBody());
        $this->assertSame('text/plain', $result->getHeaderLine('Content-Type'));
    }
}
