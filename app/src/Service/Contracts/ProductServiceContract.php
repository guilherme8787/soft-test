<?php

namespace App\Service\Contracts;

interface ProductServiceContract
{
    public function getProducts(): array;
    public function getTaxes(): array;
    public function salvar(array $data): void;
    public function atualizar(array $data): void;
    public function deletar(array $data): void;
}