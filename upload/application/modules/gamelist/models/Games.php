<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Models;

class Games extends \Ilch\Model
{
    /**
     * The id.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The catid.
     *
     * @var int
     */
    protected $catid = 0;

    /**
     * The title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * The Videourl.
     *
     * @var string
     */
    protected $videourl = '';

    /**
     * The image.
     *
     * @var string
     */
    protected $image = '';

    /**
     * The show status.
     *
     * @var int
     */
    protected $show = 0;

    /**
     * Gets the id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the id.
     *
     * @param int $id
     * @return $this
     */
    public function setId(int $id): Games
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the catid.
     *
     * @return int
     */
    public function getCatId(): int
    {
        return $this->catid;
    }

    /**
     * Sets the catid.
     *
     * @param int $catid
     * @return $this
     */
    public function setCatId(int $catid): Games
    {
        $this->catid = $catid;

        return $this;
    }

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Games
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the image.
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Sets the image.
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): Games
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Gets the show status.
     *
     * @return int
     */
    public function getShow(): int
    {
        return $this->show;
    }

    /**
     * Sets the typ status.
     *
     * @param int $show
     * @return $this
     */
    public function setShow(int $show): Games
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Gets the videourl.
     *
     * @return string
     */
    public function getVideourl(): string
    {
        return $this->videourl;
    }

    /**
     * Sets the videourl.
     *
     * @param string $videourl
     * @return $this
     */
    public function setVideourl(string $videourl): Games
    {
        $this->videourl = $videourl;

        return $this;
    }
}
