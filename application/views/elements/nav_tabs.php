<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($navTabParams) && is_array($navTabParams) && count($navTabParams)) : ?>

    <br />
    <ul class="nav nav-pills">

        <?php
        foreach ($navTabParams as $key => $value) :
            $itemAttrs = '';
            if ($this->method == $key) :
                $itemAttrs = ' active';
            endif;
            ?>
            <li class="nav-item<?= $itemAttrs ?>">
                <a class="nav-link" href="<?= $value['link'] ?>">
                    <?= getLanguageLine('navtabs_' . $value['label']) ?>
                </a>
            </li>
        <?php endforeach; ?>

    </ul>
    <br />

<?php endif;