<?php

namespace App\Repository;

use App\Config\Database;
use App\Entity\Entity;

class BaseRepository
{
    /**
     * @throws Exception
     */
    public function save(Entity $entity) {
        $data = array_filter($entity->toArray());
        $keys = array_keys($data);
        $values = array_filter(array_values($data));
        $placeholders = array_fill(0, count($keys), '?');

        return Database::insert(
            "INSERT INTO {$entity->table} (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $placeholders) . ")",
            $values
        );
    }

    /**
     * @throws Exception
     */
    public function update(Entity $entity) {
        $data = $entity->toArray();
        $id = $entity->getId();
        $keys = array_keys($data);
        $values = array_values($data);
        $setParts = [];

        foreach ($keys as $key) {
            if ($key != 'id') {
                $setParts[] = "$key = ?";
            }
        }

        $values = array_filter($values, function($value, $key) use ($keys) {
                return $keys[$key] != 'id';
            }, ARRAY_FILTER_USE_BOTH);

        $values[] = $id;
    
        $sql = "UPDATE {$entity->table} SET " . implode(', ', $setParts) . " WHERE id = ?";
    
        return Database::update($sql, $values);
    }
}