<?php

/** @var \Ilch\View $this */

/** @var Modules\Gamelist\Models\Category $cat */
$cat = $this->get('cat');
?>
<h1><?=$this->getTrans($cat->getId() ? 'edit' : 'add') ?></h1>
<form method="POST" action="">
    <?=$this->getTokenField(); ?>
    <div class="row mb-3<?=$this->validation()->hasError('title') ? ' has-error' : '' ?>">
        <label for="title" class="col-xl-2 col-form-label">
            <?=$this->getTrans('title') ?>:
        </label>
        <div class="col-xl-3">
            <input type="text"
                   class="form-control"
                   id="title"
                   name="title"
                   value="<?=$this->escape($this->originalInput('title', $cat->getTitle())) ?>" />
        </div>
    </div>
    <?=$this->getSaveBar($cat->getId() ? 'updateButton' : 'addButton') ?>
</form>
