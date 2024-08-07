<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (getLanguageLine('bread_crumb')): ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb blue-bg">

        <li class="breadcrumb-item">
            <a href="/"><?= getLanguageLine('home') ?></a>
        </li>

        <?php if ($this->subDir) : ?>
            <li class="breadcrumb-item">
                <a href="/<?= $this->subDir ?>"><?= getLanguageLine($this->subDir) ?></a>
            </li>
        <?php endif; ?>

        <?php if ($this->method == 'index') : ?>

            <?php if (!$this->isDefaultController) : ?>
                <li  class="breadcrumb-item active">
                    <?= getLanguageLine('bread_crumb') ?>
                </li>
            <?php endif; ?>

        <?php else : ?>

            <?php if (!$this->isDefaultController) : ?>
                <li class="breadcrumb-item">
                    <a href="<?= ($this->subDir) ? '/'.$this->subDir : '' ?>/<?= $this->controller ?>"><?= getLanguageLine('bread_crumb') ?></a>
                </li>
            <?php endif; ?>

            <li  class="breadcrumb-item active">
                <?= getLanguageLine(getLanguageKey('bread_crumb')) ?>
            </li>

        <?php endif; ?>

    </ol>
</nav>

<?php endif; ?>