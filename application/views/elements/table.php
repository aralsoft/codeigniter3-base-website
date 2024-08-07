
<div class="row">
    <div class="col-md-12">
        <?= $this->tables->render(); ?>
    </div>
</div>

<?php if (isset($pages) && $pages) : ?>
    <div class="row">
        <div class="col-md-12">
            <?= $pages ?>
        </div>
    </div>
<?php endif; ?>
