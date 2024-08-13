<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?= getLanguageLine("meta_title") ?></title>
        <meta name="description" content="<?= getLanguageLine("meta_description") ?>">

        <link href="/img/favicon.png" rel="shortcut icon" />

        <link href="/bootstrap4-glyphicons/css/bootstrap-glyphicons.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/css/main.css" rel="stylesheet" type="text/css">

        <?php if ($this->isLive && $this->config->item('g-recaptcha-sitekey')) : ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <?php endif; ?>

    </head>

    <body>
        
    <script src="/js/jquery-3.7.1.min.js"></script>

    <div class="position-relative overflow-hidden">

        <!-- header -->
        <nav class="navbar navbar-expand-lg">
            <div class="container d-flex justify-content-between">

                <h1>
                    <a href="/"><?= getLanguageLine("common_app_name") ?></a>
                </h1>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="ChangeToggle">
                    <span id="navbar-hamburger" class="show">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </span>
                    <span id="navbar-close" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mr-0">

                        <?php if ($this->user->isLoggedIn()) : ?>

                        <li class="nav-item mr-4">
                            <a href="/dashboard">
                                <span class="glyphicon glyphicon-user"></span>
                                <?= $this->user->getFullName() ?>
                            </a>
                        </li>

                        <li class="nav-item mr-4">
                            <a href="/wall/index">
                                <span class="glyphicon glyphicon-apple"></span>
                                <?= getLanguageLine("my_wall") ?>
                            </a>
                        </li>

                        <li class="nav-item mr-4">
                            <a href="/account/logout">
                                <span class="glyphicon glyphicon-log-out"></span>
                                <?= getLanguageLine("logout") ?>
                            </a>
                        </li>

                        <?php else : ?>

                        <li class="nav-item mr-4">
                            <a href="/account/">
                                <span class="glyphicon glyphicon-log-in"></span>
                                <?= getLanguageLine("login") ?>
                            </a>
                        </li>

                        <li class="nav-item mr-4">
                            <a href="/account/register">
                                <span class="glyphicon glyphicon-user"></span>
                                <?= getLanguageLine("register") ?>
                            </a>
                        </li>

                        <?php endif; ?>

                        <li class="nav-item mr-4">
                            <a href="/support">
                                <span class="glyphicon glyphicon-question-sign"></span>
                                <?= getLanguageLine("help") ?>
                            </a>
                        </li>

                        <?php if ($this->countryCode) : ?>
                        <li class="nav-item mr-4">
                            <span class="nav-link"><span><img src="/img/icon/globe.svg" class="img-fluid" alt="<?= $this->countryCode ?>"></span><?= $this->countryCode ?></span>
                        </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <?php include(APPPATH."views/elements/language_select.php"); ?>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
