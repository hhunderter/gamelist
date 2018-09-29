<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Games\Mappers;

use Modules\Games\Models\Games as GamesModel;

class Games extends \Ilch\Mapper
{
    /**
     * Gets the entries.
     *
     * @param array $where
     * @return GamesModel[]|array
     */
    public function getEntries($where = [])
    {
        $array = $this->db()->select('*')
            ->from('games')
            ->where($where)
            ->order(['title' => 'DESC'])
            ->execute()
            ->fetchRows();

        if (empty($array)) {
            return null;
        }

        $entries = [];
        foreach ($array as $entry) {
            $model = new GamesModel();
            $model->setId($entry['id'])
                ->setTitle($entry['title'])
                ->setImage($entry['image'])
                ->setShow($entry['show']);
            $entries[] = $model;
        }

        return $entries;
    }

    /**
     * Gets entry by given id.
     *
     * @param integer $id
     * @return GamesModel|null
     */
    public function getEntryById($id)
    {
        $row = $this->db()->select('*')
            ->from('games')
            ->where(['id' => $id])
            ->execute()
            ->fetchAssoc();

        if (empty($row)) {
            return null;
        }

        $model = new GamesModel();
        $model->setId($row['id'])
            ->setTitle($row['title'])
            ->setImage($row['image'])
            ->setShow($row['show']);

        return $model;
    }

    /**
     * Inserts or updates model.
     *
     * @param GamesModel $entry
     */
    public function save(GamesModel $entry)
    {
        $fields = [
            'title' => $entry->getTitle(),
            'image' => $entry->getImage(),
            'show' => $entry->getShow()
        ];

        if ($entry->getId()) {
            $this->db()->update('games')
                ->values($fields)
                ->where(['id' => $entry->getId()])
                ->execute();
        } else {
            $this->db()->insert('games')
                ->values($fields)
                ->execute();
        }
    }

    /**
     * Deletes entry with given id.
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->db()->delete('games')
            ->where(['id' => $id])
            ->execute();
    }
}
