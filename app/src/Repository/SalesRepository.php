<?php

namespace App\Repository;

use App\Config\Database;
use Exception;
use Throwable;

class SalesRepository
{
    public static function getSales(): array
    {
        $sql = 'SELECT
            s.id as sale_id,
            s.name as sale_name,
            s.price as total_price,
            s.created_at as sale_date,
            sp.price as product_price,
            p.name as product_name,
            p.product_type as product_type_id,
            pt.percentage as tax_percentage,
            sp.created_at as product_sale_date,
            (sp.price * pt.percentage / 100) as tax_amount,
            (sp.price + (sp.price * pt.percentage / 100)) as total_with_tax
        FROM sales s
        JOIN sales_products sp ON s.id = sp.sale_id
        JOIN products p ON sp.product_id = p.id
        JOIN product_types pt ON p.product_type = pt.id';

        $results = Database::select($sql);

        return $results;
    }

    public static function save(array $data): bool
    {
        try {
            $pdo = Database::getConnection();

            $pdo->beginTransaction();
    
            $saleName = 'sale_' . date('YmdHis');
            $totalPrice = $data['total'] + $data['totalTax'];
    
            $stmt = $pdo->prepare('INSERT INTO sales (name, price) VALUES (?, ?)');
            $stmt->execute([$saleName, $totalPrice]);
            $saleId = $pdo->lastInsertId();
    
            foreach ($data['items'] as $item) {
                $stmt = $pdo->prepare('INSERT INTO sales_products (price, sale_id, product_id) VALUES (?, ?, ?)');
                $stmt->execute([$item['total'], $saleId, $item['id']]);
            }
    
            $pdo->commit();
        } catch (Throwable|Exception $e) {
            $pdo->rollBack();

            return false;
        }

        return true;
    }
}