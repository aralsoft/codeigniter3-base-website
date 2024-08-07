<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dropdown">
    &nbsp;&nbsp;&nbsp;
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="/img/flags/flag-<?= $this->config->item('language') ?>.png"> <?= ucwords($this->config->item('language')) ?>
        <span class="caret"></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">

        <?php $languages = $this->config->item('languages'); ?>
        <?php foreach ($languages as $language): ?>
            <a class="dropdown-item" href="<?= $this->config->item('base_url') ?>welcome/change_language/<?= $language ?>">
                <img src="/img/flags/flag-<?= $language ?>.png" alt="<?= $language ?>"> <?= ucwords($language) ?>
            </a>
        <?php endforeach; ?>

    </div>
    &nbsp;&nbsp;&nbsp;
</div>        