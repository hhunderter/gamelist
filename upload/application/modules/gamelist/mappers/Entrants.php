<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Mappers;

use Modules\Gamelist\Models\Entrants as EntrantsModel;

class Entrants extends \Ilch\Mapper
{
    /**
     * Gets the entrants.
     *
     * @param int $gameId
     * @param int $userId
     *
     * @return EntrantsModel|null
     */
    public function getGameEntrants(int $gameId, int $userId): ?EntrantsModel
    {
        $entryRow = $this->db()->select('*')
            ->from('gamelist_entrants')
            ->where(['game_id' => $gameId, 'user_id' => $userId])
            ->execute()
            ->fetchAssoc();

        if (empty($entryRow)) {
            return null;
        }

        $entryModel = new EntrantsModel();
        $entryModel->setGameId($entryRow['game_id'])
            ->setUserId($entryRow['user_id']);

        return $entryModel;
    }

    /**
     * Gets the count of entrants of an entry with given game id.
     *
     * @param int $gameId
     *
     * @return int
     */
    public function getCountEntrans(int $gameId): int
    {
        return $this->db()->select('COUNT(*)', 'gamelist_entrants')
            ->where(['game_id' => $gameId])
            ->execute()
            ->fetchCell();
    }

    /**
     * Gets the entrants with given game id.
     *
     * @param int $gameId
     *
     * @return EntrantsModel[]|array
     */
    public function getEntrantsByGameId(int $gameId): array
    {
        $entryArray = $this->db()->select('*')
            ->from('gamelist_entrants')
            ->where(['game_id' => $gameId])
            ->execute()
            ->fetchRows();

        if (empty($entryArray)) {
            return [];
        }

        $entry = [];
        foreach ($entryArray as $entries) {
            $entryModel = new EntrantsModel();
            $entryModel->setUserId($entries['user_id']);
            $entry[] = $entryModel;
        }

        return $entry;
    }

    /**
     * Gets the entrants with given user id.
     *
     * @param int $userId
     *
     * @return EntrantsModel[]|array
     */
    public function getEntrantsByUserId(int $userId): array
    {
        $entryArray = $this->db()->select('*')
            ->from('gamelist_entrants')
            ->where(['user_id' => $userId])
            ->execute()
            ->fetchRows();

        if (empty($entryArray)) {
            return [];
        }

        $entry = [];
        foreach ($entryArray as $entries) {
            $entryModel = new EntrantsModel();
            $entryModel->setGameId($entries['game_id']);
            $entry[] = $entryModel;
        }

        return $entry;
    }

    /**
     * Inserts user to a game.
     *
     * @param EntrantsModel $game
     */
    public function save(EntrantsModel $game)
    {
        $fields = [
            'game_id' => $game->getGameId(),
            'user_id' => $game->getUserId()
        ];

        $userId = (int) $this->db()->select('*')
            ->from('gamelist_entrants')
            ->where(['game_id' => $game->getGameId(), 'user_id' => $game->getUserId()])
            ->execute()
            ->fetchCell();

        if (!$userId) {
            $this->db()->insert('gamelist_entrants')
                ->values($fields)
                ->execute();
        }
    }

    /**
     * Deletes user from game with given game id and user id.
     *
     * @param int $gameId
     * @param int $userId
     */
    public function deleteUserFromGame(int $gameId, int $userId)
    {
        $this->db()->delete('gamelist_entrants')
            ->where(['game_id' => $gameId, 'user_id' => $userId])
            ->execute();
    }

    /**
     * Deletes user from game with given user id.
     *
     * @param int $userId
     */
    public function deleteByUserId(int $userId)
    {
        $this->db()->delete('gamelist_entrants')
            ->where(['user_id' => $userId])
            ->execute();
    }
}
