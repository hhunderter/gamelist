<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gamelist\Controllers\Admin;

use Ilch\Validation;
use Modules\Gamelist\Mappers\Category as CategoryMapper;
use Modules\Gamelist\Models\Category as CategoryModel;
use Modules\Gamelist\Mappers\Games as GamesMapper;

class Cats extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'manage',
                'active' => false,
                'icon' => 'fa-solid fa-table-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index'])
            ],
            [
                'name' => 'menuCats',
                'active' => false,
                'icon' => 'fa-solid fa-table-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'cats', 'action' => 'index']),
                [
                    'name' => 'add',
                    'active' => false,
                    'icon' => 'fa-solid fa-circle-plus',
                    'url' => $this->getLayout()->getUrl(['controller' => 'cats', 'action' => 'treat'])
                ]
            ]
        ];

        if ($this->getRequest()->getActionName() == 'treat') {
            $items[1][0]['active'] = true;
        } else {
            $items[1]['active'] = true;
        }

        $this->getLayout()->addMenu(
            'menuCats',
            $items
        );
    }

    public function indexAction()
    {
        $categoryMapper = new CategoryMapper();
        $gamesMapper = new GamesMapper();

        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('menuGames'), ['controller' => 'index', 'action' => 'index'])
            ->add($this->getTranslator()->trans('menuCats'), ['action' => 'index']);

        if ($this->getRequest()->getPost('action') === 'delete') {
            foreach ($this->getRequest()->getPost('check_cats') as $catId) {
                $categoryMapper->delete($catId);
            }
            $this->addMessage('deleteSuccess');

            $this->redirect(['action' => 'index']);
        }

        $this->getView()->set('gamesMapper', $gamesMapper);
        $this->getView()->set('cats', $categoryMapper->getCategories());
    }

    public function treatAction()
    {
        $categoryMapper = new CategoryMapper();

        $model = new CategoryModel();
        if ($this->getRequest()->getParam('id')) {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('menuGames'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('menuCats'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('edit'), ['action' => 'treat']);

            $model = $categoryMapper->getCategoryById($this->getRequest()->getParam('id'));

            if (!$model) {
                $this->redirect()
                    ->withMessage('notfound', 'danger')
                    ->to(['action' => 'index']);
            }
        } else {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('menuGames'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('menuCats'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('add'), ['action' => 'treat']);
        }
        $this->getView()->set('cat', $model);

        if ($this->getRequest()->isPost()) {
            $post['title'] = trim($this->getRequest()->getPost('title'));

            $validation = Validation::create($post, [
                'title'  => 'required',
            ]);

            if ($validation->isValid()) {
                $model->setTitle($post['title']);
                $categoryMapper->save($model);

                $this->addMessage('saveSuccess');

                $this->redirect(['action' => 'index']);
            }
            $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
            $this->redirect()
                ->withInput()
                ->withErrors($validation->getErrorBag())
                ->to(array_merge(['action' => 'treat'], $model->getId() ? ['id' => $model->getId()] : []));
        }
    }

    public function delCatAction()
    {
        $gamesMapper = new GamesMapper();
        $countGames = count($gamesMapper->getEntries(['catid' => $this->getRequest()->getParam('id')]));

        if ($countGames == 0) {
            if ($this->getRequest()->isSecure()) {
                $categoryMapper = new CategoryMapper();
                $categoryMapper->delete($this->getRequest()->getParam('id'));

                $this->addMessage('deleteSuccess');
            }
        } else {
            $this->addMessage('deleteFailed', 'danger');
        }

        $this->redirect(['action' => 'index']);
    }
}
