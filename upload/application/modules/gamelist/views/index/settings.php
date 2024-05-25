<link href="<?=$this->getStaticUrl('css/chosen/bootstrap-chosen.css') ?>" rel="stylesheet">
<link href="<?=$this->getVendorUrl('harvesthq/chosen/chosen.min.css') ?>" rel="stylesheet">
<link href="<?=$this->getModuleUrl('../user/static/css/user.css') ?>" rel="stylesheet">

<div class="row">
    <div class="col-xl-12 profile">
        <?php include APPLICATION_PATH.'/modules/user/views/panel/navi.php'; ?>

        <div class="profile-content active">
            <h1><?=$this->getTrans('gamesSelection') ?></h1>
            <?php if (!empty($this->get('entries'))) : ?>
            <form method="POST" action="">
                <?=$this->getTokenField() ?>

                <div class="row mb-3">
                    <label for="assignedGames" class="col-xl-3 col-form-label">
                        <?=$this->getTrans('games') ?>
                    </label>
                    <div class="col-xl-9">
                        <?php if ($this->get('profileField')->getShow() == 0): ?>
                            <div class="input-group">
                        <?php endif; ?>
                        <select class="chosen-select form-control"
                                id="assignedGames"
                                name="games[]"
                                data-placeholder="<?=$this->getTrans('selectGames') ?>"
                                multiple>
                            <?php foreach ($this->get('entries') as $game): ?>
                                <option value="<?=$game->getId() ?>"
                                    <?php foreach ($this->get('gamesEntrants') as $assignedGame) {
                                        if ($game->getId() === $assignedGame->getGameId()) {
                                            echo 'selected="selected"';
                                            break;
                                        }
                                    } ?>>
                                    <?=$this->escape($game->getTitle()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($this->get('profileField')->getShow() == 0): ?>
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

<script src="<?=$this->getVendorUrl('harvesthq/chosen/chosen.jquery.min.js') ?>"></script>
<script>
    $('#assignedGames').chosen();
    $('[data-toggle="tooltip"]').tooltip()
</script>
