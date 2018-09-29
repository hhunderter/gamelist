<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Games\Controllers;

use Modules\Games\Mappers\Games as GamesMapper;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $gamesMapper = new GamesMapper();

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuGames'), ['action' => 'index']);

        $this->getView()->set('entries', $gamesMapper->getEntries());
    }
}
