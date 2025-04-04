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
        header('Location: /error');
        exit;
        // echo "404 - Route Not Found";
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

    private function dispatchDynamic($handler, $matches) {
        $controllerName = $handler['controller'];
        $methodName = $handler['method'];
    
        // Extract the full route (the URL being matched)
        $fullRoute = $_SERVER['REQUEST_URI'];  // This gives the full URL requested
    
        // Include the controller
        require_once __DIR__ . "/../controllers/$controllerName.php";
        $controller = new $controllerName();
    
        // Pass both the full route and dynamic parameters to the controller method
        $controller->$methodName($fullRoute, ...$matches);  // Spread the dynamic segments into the method
    }
    

    private function convertRouteToPattern($route) {
        // Replace (:any) with regex for dynamic segments
        // \([^/]+\) matches a segment of the URL that is not a slash
        $pattern = preg_replace('/(:any)/', '([^/]+)', $route);
        // Add start (^) and end ($) anchors to ensure it's a full match
        return '#^' . $pattern . '$#';
    }
    
}

// Add the /privacy route to your router
$router = new Router();
$router->add('/privacy', 'PrivacyController', 'showPrivacyPage');


?>
