<?php

use PHPUnit\Framework\TestCase;
use App\Core\Request;
use App\Core\Router;

class RouterTest extends TestCase
{
    public function testRutaBasica(): void
    {
        $router = new Router();

        $router->get('/ping', function (Request $request) {
            echo 'pong';
        });

        $request = Request::blank();
        $request->method = 'GET';
        $request->uri = '/ping';

        ob_start();
        $router->dispatch($request);
        $output = ob_get_clean();

        $this->assertEquals('pong', $output);
    }
}