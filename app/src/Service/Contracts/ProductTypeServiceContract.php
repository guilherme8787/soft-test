<?php

namespace App\Service\Contracts;

interface ProductTypeServiceContract
{
    public function all(): array;
    public function salvar(array $data): void;
    public function atualizar(array $data): void;
    public function deletar(array $data): void;
}