<?php

namespace App\Model;

class VoteManager extends AbstractManager
{
    public const TABLE = 'vote';

    public function insert(array $vote)
    {
        $query = "INSERT INTO " . self::TABLE . " (`user_id`, `legend_id`)
        VALUES (:user_id, :legend_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $vote['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('legend_id', $vote['id'], \PDO::PARAM_INT);
        //@ maybe todo//
        // $statement->bindValue('legend_meme_id', $meme['legend_meme_id'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
