<?php

namespace App\Model;

class CreateManager extends AbstractManager
{
    public const TABLE = 'meme';

    public function insert(array $meme): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $meme['title'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
