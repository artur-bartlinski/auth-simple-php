<?php

include 'database.php';

$random = filter_input(INPUT_GET, 'random', FILTER_SANITIZE_NUMBER_INT);

if ($random) {
    $connect = dbConnect();
    activateUserAccount($connect, $random);   
    
} else {
    exit("Data is not present or is wrong!!");
}