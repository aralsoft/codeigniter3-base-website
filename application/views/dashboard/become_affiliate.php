
<?= $this->forms->render(); ?>

<?php if ($this->user->isAffiliate()) : ?>
<div class="row">
    <div class="col-md-12">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/dashboard/affiliate">
                    <?= getLanguageLine("affiliate_dashboard") ?>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php endif; ?>