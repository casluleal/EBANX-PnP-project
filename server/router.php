<?php
include_once 'server/Handler.php';

function returnHTMLForm($error = 0) {
    if ($error == 0) {
        readfile("public/index.html");
    } else if ($error == 1) {
        readfile("public/error.html");
    }
}

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {
    $handler = new Handler();

    if($handler->setFields($_POST)) {
        $handler->generatePayment();
    } else {
        returnHTMLForm(1);
    }
} else {
    returnHTMLForm();
}