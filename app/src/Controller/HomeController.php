<?php

namespace App\Controller;

use App\Service\ProductService;

class HomeController extends BaseController
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }

    public function panel()
    {
        $products = $this->productService->getProducts();
        include $this->view('panel');
    }
}