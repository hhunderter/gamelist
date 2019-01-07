<h1><?=($this->get('entry') != '') ? $this->getTrans('edit') : $this->getTrans('add') ?></h1>
<?php if ($this->get('cats') != ''): ?>
    <form class="form-horizontal" method="POST" action="">
        <?=$this->getTokenField() ?>
        <div class="form-group <?=$this->validation()->hasError('catId') ? 'has-error' : '' ?>">
            <label for="catId" class="col-lg-2 control-label">
                <?=$this->getTrans('cat'); ?>:
            </label>
            <div class="col-lg-3">
                <select class="form-control" id="catid" name="catid">
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
        <div class="form-group <?=$this->validation()->hasError('title') ? 'has-error' : '' ?>">
            <label for="title" class="col-lg-2 control-label">
                <?=$this->getTrans('title') ?>:
            </label>
            <div class="col-lg-3">
                <input type="text"
                       class="form-control"
                       name="title"
                       id="title"
                       value="<?=($this->get('entry') != '') ? $this->escape($this->get('entry')->getTitle()) : $this->originalInput('title') ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-lg-2 control-label">
                <?=$this->getTrans('videourl') ?>:
            </label>
            <div class="col-lg-3">
                <input type="text"
                       class="form-control"
                       name="videourl"
                       id="videourl"
                       value="<?=($this->get('entry') != '') ? $this->escape($this->get('entry')->getVideourl()) : $this->originalInput('videourl') ?>">
            </div>
        </div>
        <div class="form-group <?=$this->validation()->hasError('image') ? 'has-error' : '' ?>">
            <label for="selectedImage" class="col-lg-2 control-label">
                <?=$this->getTrans('image') ?>:
            </label>
            <div class="col-lg-3">
                <div class="input-group">
                    <input type="text"
                           class="form-control"
                           id="selectedImage"
                           name="image"
                           placeholder="<?=$this->getTrans('httpOrMedia') ?>"
                           value="<?=($this->get('entry') != '') ? $this->escape($this->get('entry')->getImage()) : $this->originalInput('image') ?>" />
                    <span class="input-group-addon">
                        <span class="fa fa-times"></span>
                    </span>
                    <span class="input-group-addon">
                        <a id="media" href="javascript:media()"><i class="fa fa-picture-o"></i></a>
                    </span>
                </div>
            </div>
        </div>
        <?php if ($this->get('entry') != ''): ?>
            <?=$this->getSaveBar('updateButton') ?>
        <?php else: ?>
            <?=$this->getSaveBar('addButton') ?>
        <?php endif; ?>
    </form>
<?php else: ?>
    <?=$this->getTrans('noCategory') ?>
<?php endif; ?>

<?=$this->getDialog('mediaModal', $this->getTrans('media'), '<iframe frameborder="0"></iframe>'); ?>
<script>
<?=$this->getMedia()
    ->addMediaButton($this->getUrl('admin/media/iframe/index/type/single/'))
    ->addUploadController($this->getUrl('admin/media/index/upload'))
?>
</script>
