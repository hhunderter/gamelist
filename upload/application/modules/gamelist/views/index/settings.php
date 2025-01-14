<?php

/** @var \Ilch\View $this */

/** @var Modules\Gamelist\Models\Games[] $entries */
$entries = $this->get('entries');

/** @var Modules\User\Models\ProfileField $profileField */
$profileField = $this->get('profileField');
?>
<link href="<?=$this->getStaticUrl('css/bootstrap-choices.css') ?>" rel="stylesheet">
<link href="<?=$this->getStaticUrl('js/choices/build/choices.min.css') ?>" rel="stylesheet">
<link href="<?=$this->getModuleUrl('../user/static/css/user.css') ?>" rel="stylesheet">

<div class="row">
    <div class="col-xl-12 profile">
        <?php include APPLICATION_PATH . '/modules/user/views/panel/navi.php'; ?>

        <div class="profile-content active">
            <h1><?=$this->getTrans('gamesSelection') ?></h1>
            <?php if (!empty($entries)) : ?>
            <form method="POST" action="">
                <?=$this->getTokenField() ?>

                <div class="row mb-3">
                    <label for="assignedGames" class="col-xl-3 col-form-label">
                        <?=$this->getTrans('games') ?>
                    </label>
                    <div class="col-xl-9">
                        <?php if ($profileField->getShow() == 0) : ?>
                            <div class="input-group">
                        <?php endif; ?>
                        <select class="choices-select form-control"
                                id="assignedGames"
                                name="games[]"
                                data-placeholder="<?=$this->getTrans('selectGames') ?>"
                                multiple>
                            <?php foreach ($entries as $game) : ?>
                                <option value="<?=$game->getId() ?>"
                                    <?php
                                    /** @var Modules\Gamelist\Models\Entrants $assignedGame */
                                    foreach ($this->get('gamesEntrants') as $assignedGame) {
                                        if ($game->getId() === $assignedGame->getGameId()) {
                                            echo 'selected="selected"';
                                            break;
                                        }
                                    } ?>>
                                    <?=$this->escape($game->getTitle()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($profileField->getShow() == 0) : ?>
                            <span class="input-group-text" data-bs-toggle="tooltip" data-placement="bottom" title="<?=$this->getTrans('profileFieldHidden') ?>">
                                <span class="fa-regular fa-eye-slash"></span>
                            </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-xl-3 col-xl-9">
                        <input type="submit"
                               name="saveGames"
                               class="btn btn-outline-secondary"
                               value="<?=$this->getTrans('submit') ?>" />
                    </div>
                </div>
            </form>
            <?php else : ?>
                <?=$this->getTrans('noEntries') ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?=$this->getStaticUrl('js/choices/build/choices.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        new Choices('#assignedGames', {
            removeItemButton: true,
            searchEnabled: true,
            shouldSort: false,
            loadingText: '<?=$this->getTranslator()->trans('choicesLoadingText') ?>',
            noResultsText: '<?=$this->getTranslator()->trans('choicesNoResultsText') ?>',
            noChoicesText: '<?=$this->getTranslator()->trans('choicesNoChoicesText') ?>',
            itemSelectText: '<?=$this->getTranslator()->trans('choicesItemSelectText') ?>',
            uniqueItemText: '<?=$this->getTranslator()->trans('choicesUniqueItemText') ?>',
            customAddItemText: '<?=$this->getTranslator()->trans('choicesCustomAddItemText') ?>',
            addItemText: (value) => {
                return '<?=$this->getTranslator()->trans('choicesAddItemText') ?>'.replace(/\${value}/g, value);
            },
            removeItemIconText: '<?=$this->getTranslator()->trans('choicesRemoveItemIconText') ?>',
            removeItemLabelText: (value) => {
                return '<?=$this->getTranslator()->trans('choicesRemoveItemLabelText') ?>'.replace(/\${value}/g, value);
            },
            maxItemCount: (maxItemCount) => {
                return '<?=$this->getTranslator()->trans('choicesMaxItemText') ?>'.replace(/\${maxItemCount}/g, maxItemCount);
            },
        });
    });

    $('[data-toggle="tooltip"]').tooltip()
</script>
