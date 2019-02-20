<?php
include_once 'server/Handler.php';

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {
    new Handler();
} else {
    readfile("public/index.html");
}
?>