<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Models;

class Category extends \Ilch\Mapper
{
    /**
     * The id of the category.
     *
     * @var int
     */
    private $id = 0;

    /**
     * The parentId of the category.
     *
     * @var int
     */
    private $parentId = 0;

    /**
     * The parentId of the category.
     *
     * @var int
     */
    private $childId = 0;

    /**
     * The title of the category.
     *
     * @var string
     */
    private $title = '';

    /**
     * The text of the category.
     *
     * @var string
     */
    private $text = '';

    /**
     * Gets the category id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the id of the category.
     *
     * @param int $id
     * @return $this
     */
    public function setId(int $id): Category
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the category parentId.
     *
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * Sets the parentId of the category.
     *
     * @param int $parentId
     * @return $this
     */
    public function setParentId(int $parentId): Category
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Gets the category parentId.
     *
     * @return int
     */
    public function getChildId(): int
    {
        return $this->childId;
    }

    /**
     * Sets the parentId of the category.
     *
     * @param int $childId
     * @return $this
     */
    public function setChildId(int $childId): Category
    {
        $this->childId = $childId;

        return $this;
    }

    /**
     * Gets the title of the category.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title of the category.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Category
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the text of the category.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets the text of the category.
     *
     * @param string $text
     * @return $this
     */
    public function setText(string $text): Category
    {
        $this->text = $text;

        return $this;
    }
}
