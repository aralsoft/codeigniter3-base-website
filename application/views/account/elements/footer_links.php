<div class="row">
    <div class="col-sm-12"><br /></div>
</div>

<?php

$register = '<div class="row">
    <div class="col-sm-12">
        <p class="text-center">'.getLanguageLine("do_not_have_account").' <a href="/account/register">'.getLanguageLine('register').'</a>.</p>
    </div>
</div>';

$login = '<div class="row">
    <div class="col-sm-12">
        <p class="text-center">'.getLanguageLine("already_member").' <a href="/account">'.getLanguageLine("login").'</a>.</p>
    </div>
</div>';

$forgot_password = '<div class="row">
    <div class="col-sm-12">
        <p class="text-center"><a href="/account/forgot_password">'.getLanguageLine("forgot_password").'</a></p>
    </div>
</div>';

switch ($this->method)
{
    case 'index' :

        echo $forgot_password;
        echo $register;

        break;

    case 'register' :

        echo $login;
        echo $forgot_password;

        break;

    default :

        echo $register;
        echo $login;
}

?>