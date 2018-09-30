<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Games\Models;

class Entrants extends \Ilch\Model
{
    /**
     * The game id.
     *
     * @var int
     */
    protected $gameId;

    /**
     * The user id.
     *
     * @var int
     */
    protected $userId;

    /**
     * Gets the game id.
     *
     * @return int
     */
    public function getGameId()
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
    public function setGameId($gameId)
    {
        $this->gameId = (int)$gameId;

        return $this;
    }

    /**
     * Gets the user id.
     *
     * @return integer
     */
    public function getUserId()
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
    public function setUserId($userId)
    {
        $this->userId = (int)$userId;

        return $this;
    }
}
