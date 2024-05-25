<h1><?=($this->get('cat')) ? $this->getTrans('edit') : $this->getTrans('add') ?></h1>
<form method="POST" action="">
    <?=$this->getTokenField(); ?>
    <div class="row mb-3">
        <label for="title" class="col-xl-2 col-form-label">
            <?=$this->getTrans('title') ?>:
        </label>
        <div class="col-xl-3">
            <input type="text"
                   class="form-control"
                   id="title"
                   name="title"
                   value="<?=($this->get('cat')) ? $this->escape($this->get('cat')->getTitle()) : '' ?>" />
        </div>
    </div>
    <?=($this->get('cat')) ? $this->getSaveBar('updateButton') : $this->getSaveBar('addButton') ?>
</form>
