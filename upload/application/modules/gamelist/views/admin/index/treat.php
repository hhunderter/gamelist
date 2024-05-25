<h1><?=($this->get('entry') != '') ? $this->getTrans('edit') : $this->getTrans('add') ?></h1>
<?php if ($this->get('cats')): ?>
    <form method="POST" action="">
        <?=$this->getTokenField() ?>
        <div class="row mb-3<?=$this->validation()->hasError('catId') ? ' has-error' : '' ?>">
            <label for="catId" class="col-xl-2 col-form-label">
                <?=$this->getTrans('cat') ?>:
            </label>
            <div class="col-xl-3">
                <select class="form-select" id="catid" name="catid">
                    <?php foreach ($this->get('cats') as $model) {
                        $selected = '';

                        if ($this->get('entry') != '' && $this->get('entry')->getCatId() == $model->getId()) {
                            $selected = 'selected="selected"';
                        } elseif ($this->getRequest()->getParam('catid') != '' && $this->getRequest()->getParam('catid') == $model->getId()) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option '.$selected.' value="'.$model->getId().'">'.$this->escape($model->getTitle()).'</option>';
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
                       value="<?=($this->get('entry') != '') ? $this->escape($this->get('entry')->getTitle()) : $this->originalInput('title') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="title" class="col-xl-2 col-form-label">
                <?=$this->getTrans('videourl') ?>:
            </label>
            <div class="col-xl-3">
                <input type="text"
                       class="form-control"
                       name="videourl"
                       id="videourl"
                       value="<?=($this->get('entry') != '') ? $this->escape($this->get('entry')->getVideourl()) : $this->originalInput('videourl') ?>">
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
                           value="<?=($this->get('entry') != '') ? $this->escape($this->get('entry')->getImage()) : $this->originalInput('image') ?>" />
                    <span class="input-group-text">
                        <span class="fa-solid fa-xmark"></span>
                    </span>
                    <span class="input-group-text">
                        <a id="media" href="javascript:media()"><i class="fa-regular fa-image"></i></a>
                    </span>
                </div>
            </div>
        </div>
        <?=($this->get('entry')) ? $this->getSaveBar('updateButton') : $this->getSaveBar('addButton') ?>
    </form>
<?php else: ?>
    <?=$this->getTrans('treatCatBefore') ?>
<?php endif; ?>

<?=$this->getDialog('mediaModal', $this->getTrans('media'), '<iframe frameborder="0"></iframe>'); ?>
<script>
<?=$this->getMedia()
    ->addMediaButton($this->getUrl('admin/media/iframe/index/type/single/'))
    ->addUploadController($this->getUrl('admin/media/index/upload'))
?>
</script>
