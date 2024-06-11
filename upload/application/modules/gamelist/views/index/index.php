<?php

/** @var \Ilch\View $this */

/** @var Modules\Gamelist\Models\Category[] $categories */
$categories = $this->get('categorys');
/** @var Modules\Gamelist\Models\Games[] $games */
$games = $this->get('games');

/** @var Modules\Gamelist\Mappers\Entrants $entrantsMapper */
$entrantsMapper = $this->get('entrantsMapper');
/** @var Modules\Gamelist\Mappers\Games $gameMapper */
$gameMapper = $this->get('gameMapper');
/** @var Modules\User\Mappers\User $userMapper */
$userMapper = $this->get('userMapper');
?>
<h1><?=$this->getTrans('menuGames') ?></h1>
<?php if (!empty($games)) : ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3 border rounded">
        <div class="container-fluid">
              <a class="navbar-brand"><?=$this->getTrans('navigation') ?></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?=$this->getTrans('tooglenavigation') ?>">
                <span class="navbar-toggler-icon"></span>
              </button>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php foreach ($categories as $category) :
                        $countGames = count($gameMapper->getEntries(['catid' => $category->getId(), 'show' => 1]));
                        if ($category->getId() == $this->getRequest()->getParam('catid') or $category->getId() == $this->get('firstCatId')) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }

                        if ($countGames > 0) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?=$active ?>" href="<?=$this->getUrl('gamelist/index/index/catid/' . $category->getId()) ?>">
                                    <b><?=$this->escape($category->getTitle()) ?></b>
                                    <span class="badge rounded-pill bg-secondary"><?=$countGames ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="gamelist">
        <?php foreach ($games as $game) : ?>
            <?php $entrantsUsers = $entrantsMapper->getEntrantsByGameId($game->getId()); ?>
            <div class="game">
                <div class="image">
                    <?php if (!$game->getVideourl()) :?>
                        <img src="<?=(substr($game->getImage(), 0, 11) == 'application') ? $this->getBaseUrl($game->getImage()) : $game->getImage() ?>" alt="<?=$this->escape($game->getTitle()) ?>" title="<?=$this->escape($game->getTitle()) ?>" />
                    <?php else : ?>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal_<?=$game->getId() ?>">
                        <img src="<?=(substr($game->getImage(), 0, 11) == 'application') ? $this->getBaseUrl($game->getImage()) : $game->getImage() ?>" alt="<?=$this->escape($game->getTitle()) ?>" title="<?=$this->escape($game->getTitle()) ?>" />
                        </a>
                        <!-- Video Modal -->
                        <div id="videoModal_<?=$game->getId() ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?=$this->escape($game->getTitle()) ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe id="videoGame_<?=$game->getId() ?>" width="100%" height="250px" src="https://www.youtube-nocookie.com/embed/<?=$game->getVideourl() ?>" style="border:0;" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="desc text-center">
                    <span><?=$this->escape($game->getTitle()) ?></span>
                    <?php if (count($entrantsUsers) > 0) : ?>
                        <a data-bs-toggle="modal" data-bs-target="#entrantsModal_<?=$game->getId() ?>"><?=count($entrantsUsers) ?> <?=$this->getTrans('members') ?></a>
                    <?php else : ?>
                        0 <?=$this->getTrans('members') ?>
                    <?php endif; ?>
                </div>
                <?php if (count($entrantsUsers) > 0) : ?>
                    <!-- Entrants Modal -->
                    <div id="entrantsModal_<?=$game->getId() ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?=$this->getTrans('members') ?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <?php foreach ($entrantsUsers as $user) : ?>
                                        <div class="entrants-user">
                                            <?php $entrantsUser = $userMapper->getUserById($user->getUserId()); ?>
                                            <a href="<?=$this->getUrl('user/profil/index/user/' . $entrantsUser->getId()) ?>" class="entrants-user-link">
                                                <img class="thumbnail" src="<?=$this->getStaticUrl() . '../' . $this->escape($entrantsUser->getAvatar()) ?>" title="<?=$this->escape($entrantsUser->getName()) ?>" alt="">
                                                <?=$this->escape($entrantsUser->getName()) ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <ul class="list-group">
        <li class="list-group-item"><?=$this->getTrans('noEntries') ?></li>
    </ul>
<?php endif; ?>

<script>
    $(".modal").on('hidden.bs.modal', function () {
        let videoSRC = $(this).find('iframe').attr("src");
        $(this).find('iframe').attr("src", videoSRC);
    });
</script>
