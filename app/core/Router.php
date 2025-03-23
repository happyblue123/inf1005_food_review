<?php
class Router {
    private $routes = [];

    // Add route to routes array (can be static or dynamic)
    public function add($route, $controller, $method) {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    // Run the router and match URI
    public function run() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        
        // First, check for static routes (exact match)
        if (array_key_exists($uri, $this->routes)) {
            $this->dispatch($uri);
            return;
        }

        // Check for dynamic routes (regular expressions)
        foreach ($this->routes as $route => $handler) {
            // Check for dynamic route match using preg_match
            $pattern = $this->convertRouteToPattern($route);
            if (preg_match($pattern, $uri, $matches)) {
                // Capture dynamic segments like :any
                array_shift($matches); // Remove full match, leave only dynamic parts
                $this->dispatchDynamic($handler, $matches);
                return;
            }
        }

        // If no route matches, show a 404 error
        echo "404 - Route Not Found";
    }

    // Dispatch controller and method for static routes
    private function dispatch($uri) {
        $controllerName = $this->routes[$uri]['controller'];
        $methodName = $this->routes[$uri]['method'];

        // Include the controller and call the method
        require_once __DIR__ . "/../controllers/$controllerName.php";
        $controller = new $controllerName();
        $controller->$methodName();
    }

    // Dispatch controller and method for dynamic routes
    private function dispatchDynamic($handler, $matches) {
        $controllerName = $handler['controller'];
        $methodName = $handler['method'];

        // Include the controller and call the method
        require_once __DIR__ . "/../controllers/$controllerName.php";
        $controller = new $controllerName();

        // Pass dynamic parameters to the controller method
        $controller->$methodName(...$matches);
    }

    // Convert a route like search/(:any) to a regex pattern
    private function convertRouteToPattern($route) {
        // Replace (:any) with regex for dynamic segments
        // return '#^' . preg_replace('/(:any)/', '([^/]+)', $route) . '$#';
        return '#^' . preg_replace('/(:any)/', '(.+)', $route) . '$#';
    }
}


?>
