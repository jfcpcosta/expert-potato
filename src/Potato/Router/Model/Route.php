<?php namespace Potato\Router\Model;

class Route {

    private $route;
    private $controller;
    private $action;
    private $data;

    public function __construct(string $route, array $data = [])
    {
        $this->route = $route;
        $this->data = $data;
        $this->parse();
    }

    private function parse(): void {
        $parts = explode('::', $this->route);
        $this->controller = $parts[0];
        $this->action = $parts[1];
    }

    public function getController(): string {
        return $this->controller;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function hasData(): bool {
        return count($this->data) > 0;
    }

    public function getData(): array {
        return $this->data;
    }
}