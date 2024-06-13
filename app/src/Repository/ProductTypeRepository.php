<?php

namespace App\Repository;

use App\Config\Database;
use App\Entity\ProductType;
use Exception;

class ProductTypeRepository extends BaseRepository
{
    public static function getAllTypes(): array
    {
        $sql = '
            SELECT 
                *
            FROM 
                product_types p;
        ';

        $results = Database::select($sql);

        return $results;
    }

    public function salvar(array $data): void
    {
        $productType = new ProductType(
            $data['name'],
            $data['percentage']
        );

        $this->save($productType);
    }

    public function atualizar(array $data): void
    {
        $productType = new ProductType(
            $data['name'],
            $data['percentage']
        );

        $productType->setId($data['id']);

        $this->update($productType);
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

        $sql = 'DELETE FROM PRODUCT_TYPES WHERE ID = ?';

        Database::delete($sql, [$id]);
    }
}