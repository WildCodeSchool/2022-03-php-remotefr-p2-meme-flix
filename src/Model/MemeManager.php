<?php

namespace App\Model;

use App\Model\LegendManager;

class MemeManager extends AbstractManager
{
    public const TABLE = 'meme';

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT *, l.id FROM ' . LegendManager::TABLE
            . ' AS l INNER JOIN ' . static::TABLE . ' AS m ON l.meme_id=m.id ' .
            ' INNER JOIN ' . ImageManager::TABLE . 'AS i ON m.image_id=i.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * Insert new meme in database
     */
    public function insert(array $meme): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`date`,  `image`, `category_id`)
        VALUES (NOW(),  :image, :category_id)");
        //@todo add user_id connexion
        //$statement->bindValue('user_id', $meme['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('image', $meme['image'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $meme['category'], \PDO::PARAM_INT);

        $statement->execute();
        $meme['id'] = (int)$this->pdo->lastInsertId();
        $legendManager = new LegendManager();
        $legendManager->insert($meme);
        return $meme['id'];
    }

    /**
     * Update meme in database
     */
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
