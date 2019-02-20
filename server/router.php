<?php
include_once 'server/Handler.php';

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {
    $handler = new Handler($_POST);

} else {
    readfile("public/index.html");
}
?>