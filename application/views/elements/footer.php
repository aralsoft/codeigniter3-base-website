<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mt-4 mb-2">
                        <a href="/support/content/contentid/2"><?= getLanguageLine("products") ?></a>
                        &nbsp;&nbsp; | &nbsp;&nbsp;<a href="/support/content/contentid/3"><?= getLanguageLine("faqs") ?></a>
                        &nbsp;&nbsp; | &nbsp;&nbsp;<a href="/support/content/contentid/1"><?= getLanguageLine("about_us") ?></a>
                        &nbsp;&nbsp; | &nbsp;&nbsp;<a href="/support/contact"><?= getLanguageLine("contact_us") ?></a>
                    </p>
                </div>
                <div class="col-12 text-center">
                    <hr>
                    <p class="mb-1">© Copyright <?= date('Y'); ?> <?= getLanguageLine("common_app_name") ?></p>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>

<?php if ($this->isLive && $this->config->item('ga-tracking-id')) : ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $this->config->item("ga-tracking-id") ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?= $this->config->item("ga-tracking-id") ?>');
    </script>
<?php endif; ?>

</body>
</html>
