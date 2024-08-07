
<div class="card">

    <div class="card-body">
        <div class="row">

            <div class="col-md-2 col-lg-2">
                <img alt="User Pic" src="<?= $this->user->getImage() ?>" class="img-thumbnail" width="150px" height="150px">
            </div>

            <div class="col-md-10 col-lg-10">

                <table class="table p-table">
                    <tbody>

                        <tr>
                            <td><?= getLanguageLine("email") ?>:</td>
                            <td><strong><?= $this->user->getEmail() ?></strong></td>
                            <td><br/></td>
                        </tr>

                        <tr>
                            <td><?= getLanguageLine("first_name") ?>:</td>
                            <td><strong><?= $this->user->getFirstName() ?></strong></td>
                            <td><br/></td>
                        </tr>

                        <tr>
                            <td><?= getLanguageLine("last_name") ?>:</td>
                            <td><strong><?= $this->user->getLastName() ?></strong></td>
                            <td><br/></td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<br/>
<div class="row">

    <div class="col-md-4">
        <h4><?= getLanguageLine("profile") ?></h4>

        <ul class="navbar-nav">

            <li class="nav-item">
                <a href="/dashboard/update" class="nav-link">
                    <span class="glyphicon glyphicon-edit mr-1"></span>
                    <?= getLanguageLine("update_profile") ?>
                </a>
            </li>

            <li class="nav-item">
                <a href="/dashboard/upload_photo" class="nav-link">
                    <span class="glyphicon glyphicon-picture mr-1"></span>
                    <?= getLanguageLine("change_profile_photo") ?>
                </a>
            </li>

            <li class="nav-item">
                <a href="/dashboard/change_password" class="nav-link">
                    <span class="glyphicon glyphicon-lock mr-1"></span>
                    <?= getLanguageLine("change_password") ?>
                </a>
            </li>

            <li class="nav-item">
                <a href="/account/logout" class="nav-link">
                    <span class="glyphicon glyphicon-log-out mr-1"></span>
                    <?= getLanguageLine("logout") ?>
                </a>
            </li>

        </ul>

    </div>

    <div class="col-md-4">
        <h4><?= getLanguageLine("my_wall") ?></h4>

        <ul class="navbar-nav">

            <li class="nav-item">
                <a href="/dashboard/transactions" class="nav-link">
                    <span class="glyphicon glyphicon-th-list mr-1"></span>
                    <?= getLanguageLine("transactions") ?>
                </a>
            </li>

        </ul>
    </div>

    <div class="col-md-4">
        <h4><?= getLanguageLine("settings") ?></h4>

        <ul class="navbar-nav">

            <li class="nav-item">
                <a href="/dashboard/options" class="nav-link">
                    <span class="glyphicon glyphicon-wrench mr-1"></span>
                    <?= getLanguageLine("options") ?>
                </a>
            </li>

            <li class="nav-item">

                <?php if ($this->user->isAffiliate()) : ?>

                <a href="/dashboard/affiliate" class="nav-link">
                    <span class="glyphicon glyphicon-usd mr-1"></span>
                    <?= getLanguageLine("affiliate_dashboard") ?>
                </a>

                <?php else : ?>

                <a href="/dashboard/become_affiliate" class="nav-link">
                    <span class="glyphicon glyphicon-usd mr-1"></span>
                    <?= getLanguageLine("become_affiliate") ?>
                </a>

                <?php endif; ?>

            </li>

        </ul>
    </div>

</div>