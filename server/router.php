<?php
include_once 'server/Handler.php';
include_once __DIR__ . '/helpers/HTMLFormReader.php';

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {
    $handler = new Handler();

    if($handler->setFields($_POST)) {
        $handler->pay();
    } else {
        HTMLFormReader::readHTMLForm(1);
    }
} else {
    HTMLFormReader::readHTMLForm();
}