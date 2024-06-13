<?php

namespace App\Controller;

use App\Service\ProductTypeService;
use Exception;

class CategoriesController extends BaseController
{
    /**
     * @var ProductTypeService
     */
    private $productTypeService;

    public function __construct()
    {
        $this->productTypeService = new ProductTypeService;
    }

    public function all()
    {
        $productTypes = $this->productTypeService->all();
        include $this->view('categories');
    }

    public function save()
    {
        $data = $this->postRequest();
        try {
            $data = $this->postRequest();
            $this->productTypeService->salvar($data);
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
            $this->productTypeService->atualizar($data);
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
            $this->productTypeService->deletar($data);
            echo json_encode(['message' => 'Produto deletado com sucesso']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao deletar o produto: ' . $e->getMessage()]);
        }
    }
}