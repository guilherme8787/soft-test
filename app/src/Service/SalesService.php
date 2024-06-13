<?php

namespace App\Service;

use App\Repository\SalesRepository;
use App\Service\Contracts\SalesServiceContract;
use Exception;

class SalesService implements SalesServiceContract
{
    public function saveSale(array $data): void
    {
        $sale = SalesRepository::save($data);

        if (! $sale) {
            throw new Exception('Erro ao tentar salvar a venda.');
        }
    }

    public function getSales(): array
    {
        $sales = SalesRepository::getSales();

        $groupedSales = [];
        
        foreach ($sales as $sale) {
            $groupedSales[$sale['sale_id']]['sale_info'] = [
                'sale_id' => $sale['sale_id'],
                'sale_name' => $sale['sale_name'],
                'total_price' => $sale['total_price'],
                'sale_date' => $sale['sale_date']
            ];
            $groupedSales[$sale['sale_id']]['products'][] = [
                'product_name' => $sale['product_name'],
                'product_price' => $sale['product_price'],
                'tax_percentage' => $sale['tax_percentage'],
                'tax_amount' => $sale['tax_amount'],
                'total_with_tax' => $sale['total_with_tax'],
                'product_sale_date' => $sale['product_sale_date']
            ];
        }

        return $groupedSales;
    }
}