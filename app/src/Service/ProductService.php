<?php

namespace App\Service;

use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use App\Service\Contracts\ProductServiceContract;
use Exception;

class ProductService implements ProductServiceContract
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
    }

    public function getProducts(): array
    {
        try {
            return ProductRepository::getAllProducts();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getTaxes(): array
    {
        try {
            return ProductTypeRepository::getAllTypes();
        } catch (Exception $e) {
            return [];
        }
    }

    public function salvar(array $data): void
    {
        $this->productRepository->salvar($data);
    }

    public function atualizar(array $data): void
    {
        $this->productRepository->atualizar($data);
    }

    public function deletar(array $data): void
    {
        $this->productRepository->deletar($data);
    }
}