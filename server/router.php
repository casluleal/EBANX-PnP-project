<?php
include_once 'server/Handler.php';

function returnHTMLForm($status = 0) {
    if ($status == 0) {
        readfile("public/index.html");
    } else if ($status == 1) {
        readfile("public/error-form.html");
    } else if ($status == 2) {
        readfile("public/success-payment.php");
    } else if ($status == 3) {
        readfile("public/error-payment.html");
    }
}

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {
    $handler = new Handler();

    if($handler->setFields($_POST)) {
        $result = $handler->generatePayment();

        if ($result) {
            returnHTMLForm(2);
        } else {
            returnHTMLForm(3);
        }
    } else {
        returnHTMLForm(1);
    }
} else {
    returnHTMLForm();
}