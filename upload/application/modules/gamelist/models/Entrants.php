<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Models;

class Entrants extends \Ilch\Model
{
    /**
     * The game id.
     *
     * @var int
     */
    protected $gameId = 0;

    /**
     * The user id.
     *
     * @var int
     */
    protected $userId = 0;

    /**
     * Gets the game id.
     *
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
    }

    /**
     * Sets the game id.
     *
     * @param int $gameId
     *
     * @return $this
     */
    public function setGameId(int $gameId): Entrants
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * Gets the user id.
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Sets the user id.
     *
     * @param integer $userId
     *
     * @return $this
     */
    public function setUserId(int $userId): Entrants
    {
        $this->userId = $userId;

        return $this;
    }
}
