<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Controllers;

use Modules\Gamelist\Mappers\Games as GamesMapper;
use Modules\Gamelist\Mappers\Category as CategoryMapper;
use Modules\Gamelist\Mappers\Entrants as EntrantsMapper;
use Modules\Gamelist\Models\Entrants as EntrantsModel;
use Modules\User\Mappers\User as UserMapper;
use Modules\User\Mappers\Usermenu as UserMenuMapper;
use Modules\User\Mappers\ProfileFields as ProfileFieldsMapper;
use Modules\User\Mappers\ProfileFieldsContent as ProfileFieldsContentMapper;
use Modules\User\Models\ProfileFieldContent as ProfileFieldContentModel;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $gamesMapper = new GamesMapper();
        $entrantsMapper = new EntrantsMapper();
        $userMapper = new UserMapper();
        $categoryMapper = new CategoryMapper();
        $this->getLayout()->header()->css('static/css/gamelist.css');
        $this->getLayout()->getTitle()->add($this->getTranslator()->trans('menuGames'));
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('menuGames'), ['action' => 'index']);
        if ($this->getRequest()->getParam('catid')) {
            $category = $categoryMapper->getCategoryById($this->getRequest()->getParam('catid'));
            if (!$category) {
                $this->redirect(['action' => 'index']);
            }

            $this->getLayout()->getHmenu()
                ->add($this->getTranslator()->trans('menuGames'), ['action' => 'index'])
                ->add($category->getTitle(), ['action' => 'index', 'catid' => $category->getId()]);
            $games = $gamesMapper->getEntries(['catid' => $this->getRequest()->getParam('catid'), 'show' => 1]);
        } else {
            $catId = $categoryMapper->getCategoryMinId();
            if ($catId != '') {
                $category = $categoryMapper->getCategoryById($catId->getId());
                $this->getLayout()->getHmenu()
                    ->add($this->getTranslator()->trans('menuGames'), ['action' => 'index'])
                    ->add($category->getTitle(), ['action' => 'index', 'catid' => $category->getId()]);
                $games = $gamesMapper->getEntries(['catid' => $catId->getId(), 'show' => 1]);
                $this->getView()->set('firstCatId', $catId->getId());
            } else {
                $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('menuGames'), ['action' => 'index']);
                $games = $gamesMapper->getEntries(['show' => 1]);
            }
        }

        $this->getView()->set('entrantsMapper', $entrantsMapper)
            ->set('userMapper', $userMapper)
            ->set('gameMapper', $gamesMapper)
            ->set('games', $games)
            ->set('categorys', $categoryMapper->getCategories())
            ->set('entries', $gamesMapper->getEntries(['show' => 1]));
    }

    public function settingsAction()
    {
        $gamesMapper = new GamesMapper();
        $entrantsMapper = new EntrantsMapper();
        $entrantsModel = new EntrantsModel();
        $userMapper = new UserMapper();
        $UserMenuMapper = new UserMenuMapper();
        $profileFieldsMapper = new ProfileFieldsMapper();
        $profileFieldsContentMapper = new ProfileFieldsContentMapper();
        $profileField = $profileFieldsMapper->getProfileFieldIdByKey('gamelist_games');
        $this->getLayout()->getTitle()
            ->add($this->getTranslator()->trans('menuPanel'))
            ->add($this->getTranslator()->trans('menuSettings'))
            ->add($this->getTranslator()->trans('gamesSelection'));
        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuPanel'), ['module' => 'user', 'controller' => 'panel', 'action' => 'index'])
            ->add($this->getTranslator()->trans('menuSettings'), ['module' => 'user', 'controller' => 'panel', 'action' => 'settings'])
            ->add($this->getTranslator()->trans('gamesSelection'), ['controller' => 'index', 'action' => 'settings']);
        if ($this->getRequest()->getPost('saveGames')) {
            $entrantsMapper->deleteByUserId($this->getUser()->getId());

            $games = [];
            foreach ($this->getRequest()->getPost('games') ?? [] as $gameId) {
                $game = $gamesMapper->getEntryById($gameId);

                if ($game) {
                    $entrantsModel->setGameId($game->getId())
                        ->setUserId($this->getUser()->getId());
                    $entrantsMapper->save($entrantsModel);

                    $games[] = $game->getTitle();
                }
            }

            $games = implode(", ", $games);
            $profileFieldsContent = new ProfileFieldContentModel();
            $profileFieldsContent->setFieldId($profileField->getId())
                ->setUserId($this->getUser()->getId())
                ->setValue($games);
            $profileFieldsContentMapper->save($profileFieldsContent);
            $this->redirect()
                ->withMessage('saveSuccess')
                ->to(['action' => 'settings']);
        }

        $this->getView()->set('gamesEntrants', $entrantsMapper->getEntrantsByUserId($this->getUser()->getId()))
            ->set('entries', $gamesMapper->getEntries(['show' => 1]))
            ->set('usermenu', $UserMenuMapper->getUserMenu())
            ->set('profileField', $profileField)
            ->set('profil', $userMapper->getUserById($this->getUser()->getId()))
            ->set('galleryAllowed', $this->getConfig()->get('usergallery_allowed'));
    }
}
