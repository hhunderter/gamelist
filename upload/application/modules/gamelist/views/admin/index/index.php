<h1><?=$this->getTrans('manage') ?></h1>
<?php if ($this->get('entries') != ''): ?>
    <form class="form-horizontal" method="POST" action="">
        <?=$this->getTokenField() ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <colgroup>
                    <col class="icon_width" />
                    <col class="icon_width" />
                    <col class="icon_width" />
                    <col class="icon_width" />
                    <col />
                </colgroup>
                <thead>
                    <tr>
                        <th><?=$this->getCheckAllCheckbox('check_entries') ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?=$this->getTrans('title') ?></th>
                        <th><?=$this->getTrans('videourl') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($this->get('entries')): ?>
                        <?php foreach ($this->get('entries') as $entry) : ?>
                            <tr>
                                <td><?=$this->getDeleteCheckbox('check_entries', $entry->getId()) ?></td>
                                <td><?=$this->getEditIcon(['action' => 'treat', 'id' => $entry->getId()]) ?></td>
                                <td><?=$this->getDeleteIcon(['action' => 'del', 'id' => $entry->getId()]) ?></td>
                                <td>
                                    <?php if ($entry->getShow() == 1): ?>
                                        <a href="<?=$this->getUrl(['action' => 'update', 'id' => $entry->getId()], null, true) ?>">
                                            <span class="fa fa-check-square-o text-info"></span>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?=$this->getUrl(['action' => 'update', 'id' => $entry->getId()], null, true) ?>">
                                            <span class="fa fa-square-o text-info"></span>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?=$this->escape($entry->getTitle()) ?></td>
                                <td><?=$this->escape($entry->getVideourl()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6"><?=$this->getTrans('noEntries') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?=$this->getListBar(['delete' => 'delete']) ?>
    </form>
<?php else: ?>
    <?=$this->getTrans('noEntries') ?>
<?php endif; ?>