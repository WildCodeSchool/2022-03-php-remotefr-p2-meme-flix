<?php

namespace App\Model;

use App\Model\MemeManager;
use App\Model\VoteManager;

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

    public function insertLegendId(array $legendId)
    {
        $query = "INSERT INTO " . VoteManager::TABLE . " (`legend_id`, legend_meme_id) VALUES (:legend_id, :legend_meme_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('legend_id', $legendId['legend_id'], \PDO::PARAM_INT);
        $statement->bindValue('legend_meme_id', $legendId['legend_meme_id'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneByIdAndVotes()
    {
        $query = "SELECT *, COUNT(vote.legend_id) AS numVote FROM " . self::TABLE .
        " JOIN " . VoteManager::TABLE . " ON vote.legend_id=legend.id JOIN " .
        MemeManager::TABLE . " ON legend.meme_id=meme.id
        WHERE legend.id=:legend.id
        GROUP BY vote.legend_id";

        return $this->pdo->query($query)->fetchAll();

    }

}
