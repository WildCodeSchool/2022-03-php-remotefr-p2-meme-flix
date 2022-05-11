<?php

namespace App\Model;

class LegendManager extends AbstractManager
{
    public const TABLE = 'legend';

    public function insert(array $meme)
    {
        $query = "INSERT INTO " . self::TABLE . " (`meme_id`, `legend`, `user_id`) VALUES (:meme_id, :legend, :user_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('meme_id', $meme['meme_id'], \PDO::PARAM_INT);
        $statement->bindValue('legend', $meme['legend'], \PDO::PARAM_STR);
        $statement->bindValue('user_id', $meme['user_id'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }


    public function selectAllAndVotesByMemeId(int $memeId): array|false
    {
        $query = "SELECT *, COUNT(vote.legend_id) AS numVote, legend.id AS legendId FROM " . self::TABLE .
        " LEFT JOIN " . VoteManager::TABLE . " ON vote.legend_id=legend.id JOIN " .
        MemeManager::TABLE . " ON legend.meme_id=meme.id
        WHERE meme.id=:meme_id GROUP BY vote.legend_id ORDER BY numVote DESC";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('meme_id', $memeId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}