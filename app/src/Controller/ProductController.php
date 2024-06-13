<?php

namespace App\Controller;

use App\Service\ProductService;
use Exception;

class ProductController extends BaseController
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }

    public function all()
    {
        $products = $this->productService->getProducts();
        $productTypes = $this->productService->getTaxes();
        include $this->view('product');
    }

    public function save()
    {
        $data = $this->postRequest();
        try {
            $data = $this->postRequest();
            $this->productService->salvar($data);
            echo json_encode(['message' => 'Produto salvo com sucesso']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao salvar o produto: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
        $data = $this->postRequest();
        try {
            $data = $this->postRequest();
            $this->productService->atualizar($data);
            echo json_encode(['message' => 'Produto salvo com sucesso']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao salvar o produto: ' . $e->getMessage()]);
        }
    }

    public function delete()
    {
        $data = $this->postRequest();
        try {
            $data = $this->postRequest();
            $this->productService->deletar($data);
            echo json_encode(['message' => 'Produto deletado com sucesso']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao deletar o produto: ' . $e->getMessage()]);
        }
    }
}