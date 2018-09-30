<link href="<?=$this->getStaticUrl('css/chosen/bootstrap-chosen.css') ?>" rel="stylesheet">
<link href="<?=$this->getStaticUrl('css/chosen/chosen.css') ?>" rel="stylesheet">
<link href="<?=$this->getModuleUrl('../user/static/css/user.css') ?>" rel="stylesheet">

<div class="row">
    <div class="col-lg-12 profile">
        <?php include APPLICATION_PATH.'/modules/user/views/panel/navi.php'; ?>

        <div class="profile-content active">
            <h1><?=$this->getTrans('gamesSelection') ?></h1>
            <form class="form-horizontal" method="POST" action="">
                <?=$this->getTokenField() ?>

                <div class="form-group">
                    <label for="assignedGames" class="col-lg-3 control-label">
                        <?=$this->getTrans('games') ?>
                    </label>
                    <div class="col-lg-9">
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-offset-3 col-lg-9">
                        <input type="submit"
                               name="saveGames"
                               class="btn"
                               value="<?=$this->getTrans('submit') ?>" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?=$this->getStaticUrl('js/chosen/chosen.jquery.min.js') ?>"></script>
<script>
    $('#assignedGames').chosen();
</script>
