<?php

use classes\User;

$pageTitle = 'Sign In';

require_once 'templates/header.php';

$user = new User();

if ($user->isLoggedIn()) {
    header("Location: member.php");
}

require 'templates/forms/login_form.html';

require 'templates/footer.php';
