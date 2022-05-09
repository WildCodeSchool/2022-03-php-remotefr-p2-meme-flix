<?php

namespace App\Model;


class VoteManager extends AbstractManager
{
    public const TABLE = 'vote';

    public function insert(array $meme)
    {
        $query = "INSERT INTO " . self::TABLE . " (`user_id`, `legend_id`)
        VALUES (:user_id, :legend_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $meme['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('legend_id', $meme['id'], \PDO::PARAM_INT);
        // $statement->bindValue('legend_meme_id', $meme['legend_meme_id'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    // public function addVote(array $addVote): int
    // {
    //     $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`user_id`, `legend_id`)
    //     VALUES (:user_id, :legend_id)");
    //     $statement->bindValue('user_id', $addVote['id'], \PDO::PARAM_INT);
    //     $statement->bindValue('legend_id', $addVote['addVote'], \PDO::PARAM_INT);
    //     $statement->execute();
    //     return (int)$this->pdo->lastInsertId();
    // }



}
