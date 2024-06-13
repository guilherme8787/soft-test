<?php

namespace App\Service;

use App\Repository\ProductTypeRepository;
use App\Service\Contracts\ProductTypeServiceContract;
use Exception;

class ProductTypeService implements ProductTypeServiceContract
{
    /**
     * @var ProductTypeRepository
     */
    private $productTypeRepository;

    public function __construct()
    {
        $this->productTypeRepository = new ProductTypeRepository;
    }

    public function all(): array
    {
        try {
            return ProductTypeRepository::getAllTypes();
        } catch (Exception $e) {
            return [];
        }
    }

    public function salvar(array $data): void
    {
        $this->productTypeRepository->salvar($data);
    }

    public function atualizar(array $data): void
    {
        $this->productTypeRepository->atualizar($data);
    }

    public function deletar(array $data): void
    {
        $this->productTypeRepository->deletar($data);
    }
}