<?php

namespace App\Model;

class CategoryManager extends AbstractManager
{
    public const TABLE = 'category';

    public function selectDistinctAll(): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        return $this->pdo->query($query)->fetchAll();
    }
}
