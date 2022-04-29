<?php

namespace App\Model;

class LegendManager extends AbstractManager
{
    public const TABLE = 'legend';

    public function insert(array $meme)
    {
        $query = "INSERT INTO " . self::TABLE . " (`meme_id`, `legend`) VALUES (:meme_id, :legend)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('meme_id', $meme['id'], \PDO::PARAM_INT);
        $statement->bindValue('legend', $meme['legend'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
