<?php

namespace App\Service\Contracts;

interface SalesServiceContract
{
    public function saveSale(array $data): void;
}