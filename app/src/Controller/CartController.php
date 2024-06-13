<?php

namespace App\Controller;

use App\Service\ProductService;
use App\Service\SalesService;
use Exception;

class CartController extends BaseController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var SalesService
     */
    private $salesService;

    public function __construct()
    {
        $this->productService = new ProductService;
        $this->salesService = new SalesService;
    }

    public function checkout()
    {
        $productTypes = $this->productService->getTaxes();
        include $this->view('cart');
    }

    public function finish()
    {
        try {
            $data = $this->postRequest();
            $this->salesService->saveSale($data);
            echo json_encode(['message' => 'Venda finalizada com sucesso']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao processar a venda: ' . $e->getMessage()]);
        }
    }
}