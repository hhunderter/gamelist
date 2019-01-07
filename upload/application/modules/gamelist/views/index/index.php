<?php
$categories = $this->get('categorys');
$games = $this->get('games');
$entrantsMapper = $this->get('entrantsMapper');
$gameMapper = $this->get('gameMapper');
$userMapper = $this->get('userMapper');
?>
<h1><?=$this->getTrans('menuGames') ?></h1>
<?php if (!empty($games)): ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Navigation</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php foreach ($categories as $category):
                        $countGames = count($gameMapper->getEntries(['catid' => $category->getId()]));
                        if ($category->getId() == $this->getRequest()->getParam('catid') OR $category->getId() == $this->get('firstCatId')) {
                            $active = 'class="active"';
                        } else {
                            $active = '';
                        }

                        if ($countGames > 0): ?>
                            <li <?=$active ?>>
                                <a href="<?=$this->getUrl('gamelist/index/index/catid/'.$category->getId()) ?>">
                                    <b><?=$this->escape($category->getTitle()) ?></b>
                                    <span class="badge"><?=$countGames ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="gamelist">
        <?php foreach ($games as $game): ?>
            <?php $entrantsUsers = $entrantsMapper->getEntrantsByGameId($game->getId()); ?>
            <div class="game">
                <div class="image">
                    <?php if (!$game->getVideourl()):?>
                        <img src="<?=(substr($game->getImage(), 0, 11) == 'application') ? $this->getBaseUrl($game->getImage()) : $game->getImage() ?>" alt="<?=$this->escape($game->getTitle()) ?>" title="<?=$this->escape($game->getTitle()) ?>" />
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#videoModal_<?=$game->getId() ?>">
                        <img src="<?=(substr($game->getImage(), 0, 11) == 'application') ? $this->getBaseUrl($game->getImage()) : $game->getImage() ?>" alt="<?=$this->escape($game->getTitle()) ?>" title="<?=$this->escape($game->getTitle()) ?>" />
                        </a>
                        <!-- Video Modal -->
                        <div id="videoModal_<?=$game->getId() ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button id="myStopClickButton" type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><?=$this->escape($game->getTitle()) ?></h4>
                                    </div>
                                    <div class="modal-body" id="youtube_player">
                                        <iframe width="100%" class="yt_player_iframe"  height="250px" src="https://www.youtube-nocookie.com/embed/<?=$game->getVideourl() ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(".modal").on('hidden.bs.modal', function (e) {
                                $(".modal iframe").attr("src", $(".modal iframe").attr("src"));
                            });
                        </script>
                    <?php endif; ?>
                </div>
                <div class="desc text-center">
                    <span><?=$this->escape($game->getTitle()) ?></span>
                    <?php if (count($entrantsUsers) > 0): ?>
                        <a data-toggle="modal" data-target="#entrantsModal_<?=$game->getId() ?>"><?=count($entrantsUsers) ?> <?=$this->getTrans('members') ?></a>
                    <?php else: ?>
                        <?=count($entrantsUsers) ?> <?=$this->getTrans('members') ?>
                    <?php endif; ?>
                </div>
                <?php if (count($entrantsUsers) > 0): ?>
                    <!-- Entrants Modal -->
                    <div id="entrantsModal_<?=$game->getId() ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><?=$this->getTrans('members') ?></h4>
                                </div>
                                <div class="modal-body">
                                    <?php foreach ($entrantsUsers as $user): ?>
                                        <div class="entrants-user">
                                            <?php $entrantsUser = $userMapper->getUserById($user->getUserId()); ?>
                                            <a href="<?=$this->getUrl('user/profil/index/user/'.$entrantsUser->getId()) ?>" class="entrants-user-link">
                                                <img class="thumbnail" src="<?=$this->getStaticUrl().'../'.$this->escape($entrantsUser->getAvatar()) ?>" title="<?=$this->escape($entrantsUser->getName()) ?>">
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
<?php else: ?>
    <ul class="list-group">
        <li class="list-group-item"><?=$this->getTrans('noEntries') ?></li>
    </ul>
<?php endif; ?>

