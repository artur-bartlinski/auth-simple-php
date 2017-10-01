<?php

use classes\Database;
use classes\User;

require_once 'templates/header.php';

$random = filter_input(INPUT_GET, 'random', FILTER_SANITIZE_NUMBER_INT);

if ($random) {

    $db = new Database();
    $user = new User();

    $connect = $db->dbConnect();
    $user->activateUserAccount($connect, $random);
} else {
    exit("Data is not present or is wrong!!");
}
