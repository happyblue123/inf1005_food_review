<?php
class Router {
    private $routes = [];

    public function add($route, $controller, $method) {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public function run() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        if (array_key_exists($uri, $this->routes)) {
            $controllerName = $this->routes[$uri]['controller'];
            $methodName = $this->routes[$uri]['method'];

            // Include controller and call method
            require_once __DIR__ . "/../controllers/$controllerName.php";
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            echo "404 - Route Not Found";
        }
    }
}

?>
