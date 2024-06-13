<?php

require_once 'vendor/autoload.php';

function route($controller, $method)
{
    $controllerClass = 'App\\Controller\\' . ucfirst(strtolower($controller)) . 'Controller';
    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();
        if (method_exists($controllerInstance, $method)) {
            call_user_func([$controllerInstance, $method]);
        } else {
            http_response_code(404);
        }
    } else {
        http_response_code(404);
    }
}

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$controller = !empty($requestUri[0]) ? $requestUri[0] : null;
$method = !empty($requestUri[1]) ? $requestUri[1] : null;


if ($controller && $method) {
    route($controller, $method);
} else {
    header('Location: /home/panel', true, 302);
}