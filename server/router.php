<?php
include_once 'server/Handler.php';

function returnHTMLForm($status = 0) {
    if ($status == 0) {
        readfile("public/index.html");
    } else if ($status == 1) {
        readfile("public/error-form.html");
    }
}

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {
    $handler = new Handler();

    if($handler->setFields($_POST)) {
        $handler->pay();
    } else {
        returnHTMLForm(1);
    }
} else {
    returnHTMLForm();
}