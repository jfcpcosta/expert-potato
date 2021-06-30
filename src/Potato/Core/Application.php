<?php namespace Potato\Core;

use Potato\Http\Errors\HttpException;
use Potato\Http\Errors\InternalServerErrorException;
use Potato\Router\Model\Route;
use Potato\Router\Router;
use ReflectionClass;
use ReflectionException;

class Application {

    private $defaultRoute = '/';
    private $router;

    public function __construct() {
        $this->router = new Router();
    }

    public function start(): void {
        $uri = $this->getUri();

        try {
            $route = $this->router->get($uri);
            $this->invoke($route);
        } catch (HttpException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();

            header("HTTP/1.1 $code $message");
            die($code . " " . $message);
        }
    }

    private function invoke(Route $route): void {
        try {
            $reflector = new ReflectionClass($route->getController());

            if ($reflector->isInstantiable()) {
                $instance = $reflector->newInstance();
                $method = $reflector->getMethod($route->getAction());

                if ($route->hasData()) {
                    $method->invokeArgs($instance, $route->getData());
                } else {
                    $method->invoke($instance);
                }

                return;
            }
        } catch (ReflectionException $e) {
            throw new InternalServerErrorException($e->getMessage());
        }
    } 

    public function getUri(): string {
        return isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $this->defaultRoute;
    }
}