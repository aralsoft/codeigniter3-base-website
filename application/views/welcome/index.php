<!-- Main -->
<div class="jumbotron">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <h2><?= getLanguageLine("hero_h1") ?></h2>

                <?php if ($this->user->isLoggedIn()) : ?>
                    <p><?= getLanguageLine("hero_logged_in") ?></p>
                    <p><a class="btn btn-primary btn-lg" href="/wall" role="button"><?= getLanguageLine("hero_logged_in_button") ?></a></p>
                <?php else: ?>
                    <p><?= getLanguageLine("hero_logged_out") ?></p>
                    <p><a class="btn btn-primary btn-lg" href="/account/register" role="button"><?= getLanguageLine("hero_logged_out_button") ?></a></p>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <img src="/img/home/hero-img.png" />
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">

    <?php for ($i = 1; $i < 4; $i++) : ?>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="media">
                <img alt="Join" src="/img/home/<?= getLanguageLine('column_'.$i.'_image') ?>">
                <div class="media-body ml-3">
                    <h3><?= getLanguageLine('column_'.$i.'_title') ?></h3>
                    <p><?= getLanguageLine('column_'.$i.'_text') ?></p>
                    <p><a class="btn btn-primary" href="/account" role="button"><?= getLanguageLine("register_button") ?></a></p>
                </div>
            </div>
        </div>
    <?php endfor; ?>

    </div>
</div>