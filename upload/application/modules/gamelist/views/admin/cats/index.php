<?php $gamesMapper = $this->get('gamesMapper'); ?>

<h1><?=$this->getTrans('menuCats') ?></h1>
<form class="form-horizontal" method="POST" action="">
    <?=$this->getTokenField() ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <colgroup>
                <col class="icon_width">
                <col class="icon_width">
                <col class="icon_width">
                <col class="icon_width">
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th><?=$this->getCheckAllCheckbox('check_cats') ?></th>
                    <th></th>
                    <th></th>
                    <th><?=$this->getTrans('entries') ?></th>
                    <th><?=$this->getTrans('title') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($this->get('cats')): ?>
                    <?php foreach ($this->get('cats') as $cat): ?>
                        <?php $countGames = count($gamesMapper->getEntries(['catid' => $cat->getId()])); ?>
                        <tr>
                            <td><?=$this->getDeleteCheckbox('check_cats', $cat->getId()) ?></td>
                            <td><?=$this->getEditIcon(['action' => 'treat', 'id' => $cat->getId()]) ?></td>
                            <td><?=$this->getDeleteIcon(['action' => 'delcat', 'id' => $cat->getId()]) ?></td>
                            <td align="center"><?=$countGames ?></td>
                            <td><?=$this->escape($cat->getTitle()) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5"><?=$this->getTrans('noCategory') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?=$this->getListBar(['delete' => 'delete']) ?>
</form>
