<?php

namespace App\Model;

class MemeManager extends AbstractManager
{
    public const TABLE = 'meme';

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT l.*, m.*, m.id, COUNT(v.legend_id) AS numVotes FROM ' . static::TABLE . ' AS m LEFT JOIN '
        . LegendManager::TABLE . ' AS l ON l.meme_id=m.id LEFT JOIN ' . VoteManager::TABLE . ' v ON v.legend_id=l.id
        GROUP BY m.id, l.id  ORDER BY numVotes DESC';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    public function insert(array $meme): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`date`,  `image`, `category_id`, `user_id`)
        VALUES (NOW(),  :image, :category_id, :user_id)");
        $statement->bindValue('image', $meme['image'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $meme['category'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $meme['user_id'], \PDO::PARAM_INT);
        $statement->execute();
        $meme['meme_id'] = (int)$this->pdo->lastInsertId();

        $legendManager = new LegendManager();
        $newVote = [];
        $newVote['legend_id'] = $legendManager->insert($meme);
        $newVote['user_id'] = $meme['user_id'];

        $voteManager = new VoteManager();
        $voteManager->insert($newVote);

        return $meme['meme_id'];
    }


    public function update(array $meme): bool
    {
        $query = "UPDATE " . self::TABLE .
            " SET
         `category_id`=:category_id, `legend`=:legend";

        if (isset($meme['user_id'])) {
            $query .= ", `user_id`=:user_id";
        }
        $query .= " WHERE `id`=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $meme['id'], \PDO::PARAM_INT);

        if (isset($meme['user_id'])) {
            $statement->bindValue('user_id', $meme['user_id'], \PDO::PARAM_STR);
        }

        $statement->bindValue('category_id', $meme['category_id'], \PDO::PARAM_STR);
        $statement->bindValue('legend', $meme['legend'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
