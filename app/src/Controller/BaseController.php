<?php

namespace App\Controller;

class BaseController
{
    public function view(string $view): string
    {
        return __DIR__ . '/../View/' . ucfirst(strtolower($view)) . 'View.php';
    }

    public function postRequest(): array
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("HTTP/1.1 400 Bad Request", true, 400);
            exit;
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (! $data) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            exit;
        }

        return $data;
    }

    public function dd(mixed $var): void
    {
        var_dump($var);
        die;
    }
}