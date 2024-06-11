<?php

/** @var \Ilch\View $this */

/** @var Modules\Gamelist\Models\Games $entry */
$entry = $this->get('entry');

/** @var Modules\Gamelist\Models\Category $cats */
$cats = $this->get('cats');
?>
<h1><?=$this->getTrans($entry->getId() ? 'edit' : 'add') ?></h1>
<?php if ($cats) : ?>
    <form method="POST" action="">
        <?=$this->getTokenField() ?>
        <div class="row mb-3<?=$this->validation()->hasError('catId') ? ' has-error' : '' ?>">
            <label for="catid" class="col-xl-2 col-form-label">
                <?=$this->getTrans('cat') ?>:
            </label>
            <div class="col-xl-3">
                <select class="form-select" id="catid" name="catid">
                    <?php
                    foreach ($cats as $model) {
                        $selected = '';

                        if ($this->originalInput('catid', $entry->getCatId()) == $model->getId()) {
                            $selected = 'selected="selected"';
                        } elseif ($this->getRequest()->getParam('catid') != '' && $this->getRequest()->getParam('catid') == $model->getId()) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option ' . $selected . ' value="' . $model->getId() . '">' . $this->escape($model->getTitle()) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3<?=$this->validation()->hasError('title') ? ' has-error' : '' ?>">
            <label for="title" class="col-xl-2 col-form-label">
                <?=$this->getTrans('title') ?>:
            </label>
            <div class="col-xl-3">
                <input type="text"
                       class="form-control"
                       name="title"
                       id="title"
                       value="<?=$this->escape($this->originalInput('title', $entry->getTitle())) ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="videourl" class="col-xl-2 col-form-label">
                <?=$this->getTrans('videourl') ?>:
            </label>
            <div class="col-xl-3">
                <input type="text"
                       class="form-control"
                       name="videourl"
                       id="videourl"
                       value="<?=$this->escape($this->originalInput('videourl', $entry->getVideourl())) ?>">
            </div>
        </div>
        <div class="row mb-3<?=$this->validation()->hasError('image') ? ' has-error' : '' ?>">
            <label for="selectedImage" class="col-xl-2 col-form-label">
                <?=$this->getTrans('image') ?>:
            </label>
            <div class="col-xl-3">
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           id="selectedImage"
                           name="image"
                           placeholder="<?=$this->getTrans('httpOrMedia') ?>"
                           value="<?=$this->escape($this->originalInput('image', $entry->getImage())) ?>" />
                    <span class="input-group-text">
                        <span class="fa-solid fa-xmark"></span>
                    </span>
                    <span class="input-group-text">
                        <a id="media" href="javascript:media()"><i class="fa-regular fa-image"></i></a>
                    </span>
                </div>
            </div>
        </div>

        <div class="row mb-3 <?=$this->validation()->hasError('show') ? 'has-error' : '' ?>">
            <div class="col-xl-2 col-form-label">
                <?=$this->getTrans('show') ?>
            </div>
            <div class="col-xl-4">
                <div class="flipswitch">
                    <input type="radio" class="flipswitch-input" id="show-yes" name="show" value="1" <?=($this->originalInput('show', ($entry->getShow()))) ? 'checked="checked"' : '' ?> />
                    <label for="show-yes" class="flipswitch-label flipswitch-label-on"><?=$this->getTrans('on') ?></label>
                    <input type="radio" class="flipswitch-input" id="show-no" name="show" value="0"  <?=(!$this->originalInput('show', ($entry->getShow()))) ? 'checked="checked"' : '' ?> />
                    <label for="show-no" class="flipswitch-label flipswitch-label-off"><?=$this->getTrans('off') ?></label>
                    <span class="flipswitch-selection"></span>
                </div>
            </div>
        </div>
        <?=$this->getSaveBar($entry->getId() ? 'updateButton' : 'addButton') ?>
    </form>
<?php else : ?>
    <?=$this->getTrans('treatCatBefore') ?>
<?php endif; ?>

<?=$this->getDialog('mediaModal', $this->getTrans('media'), '<iframe frameborder="0"></iframe>'); ?>
<script>
<?=$this->getMedia()
    ->addMediaButton($this->getUrl('admin/media/iframe/index/type/single/'))
    ->addUploadController($this->getUrl('admin/media/index/upload'))
?>
</script>
