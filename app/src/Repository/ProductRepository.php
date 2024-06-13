<?php

namespace App\Repository;

use App\Config\Database;
use App\Entity\Product;
use Exception;

class ProductRepository extends BaseRepository
{
    public static function getAllProducts(): array
    {
        $sql = '
            SELECT 
                p.id AS id,
                p.name AS produto,
                p.price AS valor,
                pt.name AS tipo
            FROM 
                products p
            JOIN 
                product_types pt ON p.product_type = pt.id;
        ';

        $results = Database::select($sql);

        return $results;
    }

    public function salvar(array $data): void
    {
        $product = new Product(
            $data['name'],
            $data['price'],
            $data['product_type']
        );

        $this->save($product);
    }

    public function atualizar(array $data): void
    {
        $product = new Product(
            $data['name'],
            $data['price'],
            $data['product_type']
        );

        $product->setId($data['id']);

        $this->update($product);
    }

    /**
     * @throws Exception
     */
    public function deletar(array $data): void
    {
        $id = $data['id'] ?? null;

        if (! $id) {
            throw new Exception('Id não informado.');
        }

        $sql = 'DELETE FROM PRODUCTS WHERE ID = ?';

        Database::delete($sql, [$id]);
    }
}