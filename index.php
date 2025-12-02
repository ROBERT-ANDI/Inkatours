<?php
session_start();

// Autoloader for classes
spl_autoload_register(function ($class_name) {
    $class_file = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    if (file_exists('core/' . $class_file)) {
        require_once 'core/' . $class_file;
    } elseif (file_exists('controllers/' . $class_file)) {
        require_once 'controllers/' . $class_file;
    } elseif (file_exists('models/' . $class_file)) {
        require_once 'models/' . $class_file;
    }
});

// Basic routing
$request_uri = urldecode($_SERVER['REQUEST_URI']); // URL-decode the request URI
$base_path = '/mi proyecto';
$route = str_replace($base_path, '', $request_uri);
$route = trim(parse_url($route, PHP_URL_PATH), '/');
$route_parts = explode('/', $route);

$controller_name = !empty($route_parts[0]) ? ucfirst($route_parts[0]) . 'Controller' : 'HomeController';
$method_name = isset($route_parts[1]) && !empty($route_parts[1]) ? $route_parts[1] : 'index';
$params = array_slice($route_parts, 2);

// Default to HomeController if the requested controller doesn't exist
if (!class_exists($controller_name)) {
    $controller_name = 'HomeController';
}

$controller = new $controller_name;

if (!method_exists($controller, $method_name)) {
    $params = [$method_name];
    $method_name = 'index';
}

if (!method_exists($controller, $method_name)) {
    // Fallback to HomeController if 'index' method doesn't exist in the requested controller
    $controller_name = 'HomeController';
    $controller = new $controller_name;
    $method_name = 'index';
    $params = [];
}

call_user_func_array([$controller, $method_name], $params);

?>