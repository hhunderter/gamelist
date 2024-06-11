<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Mappers;

use Modules\Gamelist\Models\Games as GamesModel;

class Games extends \Ilch\Mapper
{
    /**
     * Gets the entries.
     *
     * @param array $where
     * @return GamesModel[]|array
     */
    public function getEntries(array $where = []): array
    {
        $array = $this->db()->select('*')
            ->from('gamelist')
            ->where($where)
            ->order(['title' => 'ASC'])
            ->execute()
            ->fetchRows();

        if (empty($array)) {
            return [];
        }

        $entries = [];
        foreach ($array as $entry) {
            $model = new GamesModel();
            $model->setId($entry['id'])
                ->setCatId($entry['catid'])
                ->setTitle($entry['title'])
                ->setVideourl($entry['videourl'])
                ->setImage($entry['image'])
                ->setShow($entry['show']);
            $entries[] = $model;
        }

        return $entries;
    }

    /**
     * Gets entry by given id.
     *
     * @param int $id
     * @return GamesModel|null
     */
    public function getEntryById(int $id): ?GamesModel
    {
        $row = $this->db()->select('*')
            ->from('gamelist')
            ->where(['id' => $id])
            ->execute()
            ->fetchAssoc();

        if (empty($row)) {
            return null;
        }

        $model = new GamesModel();
        $model->setId($row['id'])
            ->setCatId($row['catid'])
            ->setTitle($row['title'])
            ->setVideourl($row['videourl'])
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
            'catid' => $entry->getCatId(),
            'title' => $entry->getTitle(),
            'videourl' => $entry->getVideourl(),
            'image' => $entry->getImage(),
            'show' => $entry->getShow()
        ];

        if ($entry->getId()) {
            $this->db()->update('gamelist')
                ->values($fields)
                ->where(['id' => $entry->getId()])
                ->execute();
        } else {
            $this->db()->insert('gamelist')
                ->values($fields)
                ->execute();
        }
    }

    /**
     * Updates entry with given id.
     *
     * @param int $id
     */
    public function update(int $id)
    {
        $show = (int) $this->db()->select('show')
            ->from('gamelist')
            ->where(['id' => $id])
            ->execute()
            ->fetchCell();

        if ($show == 1) {
            $this->db()->update('gamelist')
                ->values(['show' => 0])
                ->where(['id' => $id])
                ->execute();
        } else {
            $this->db()->update('gamelist')
                ->values(['show' => 1])
                ->where(['id' => $id])
                ->execute();
        }
    }

    /**
     * Deletes entry with given id.
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->db()->delete('gamelist')
            ->where(['id' => $id])
            ->execute();

        $this->db()->delete('gamelist_entrants')
            ->where(['game_id' => $id])
            ->execute();
    }
}
