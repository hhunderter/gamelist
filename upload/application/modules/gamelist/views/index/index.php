<?php
$entrantsMapper = $this->get('entrantsMapper');
$userMapper = $this->get('userMapper');
?>

<h1><?=$this->getTrans('menuGames') ?></h1>
<?php if ($this->get('entries') != ''): ?>
    <div class="gamelist">
        <?php foreach ($this->get('entries') as $entry) : ?>
            <?php $entrantsUsers = $entrantsMapper->getEntrantsByGameId($entry->getId()); ?>
            <div class="game">
                <div class="image">
                    <?php if (!$entry->getVideourl()):?>
                        <img src="<?=(substr($entry->getImage(), 0, 11) == 'application') ? $this->getBaseUrl($entry->getImage()) : $entry->getImage() ?>" alt="<?=$this->escape($entry->getTitle()) ?>" title="<?=$this->escape($entry->getTitle()) ?>" />
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#videoModal_<?=$entry->getId() ?>">
                            <img src="<?=(substr($entry->getImage(), 0, 11) == 'application') ? $this->getBaseUrl($entry->getImage()) : $entry->getImage() ?>" alt="<?=$this->escape($entry->getTitle()) ?>" title="<?=$this->escape($entry->getTitle()) ?>" />
                        </a>
                        <!-- Video Modal -->
                        <div id="videoModal_<?=$entry->getId() ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><?=$this->escape($entry->getTitle()) ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <iframe width="100%" height="250px" src="https://www.youtube-nocookie.com/embed/<?=$entry->getVideourl() ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="desc">
                    <span><?=$this->escape($entry->getTitle()) ?></span>
                    <?php if (count($entrantsUsers) > 0): ?>
                        <a data-toggle="modal" data-target="#entrantsModal_<?=$entry->getId() ?>"><?=count($entrantsUsers) ?> <?=$this->getTrans('members') ?></a>
                    <?php else: ?>
                        <?=count($entrantsUsers) ?> <?=$this->getTrans('members') ?>
                    <?php endif; ?>
                </div>

                <?php if (count($entrantsUsers) > 0): ?>
                    <!-- Entrants Modal -->
                    <div id="entrantsModal_<?=$entry->getId() ?>" class="modal fade" role="dialog">
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
    <?=$this->getTrans('noEntries') ?>
<?php endif; ?>
