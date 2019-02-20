<?php
/**
 * Created by PhpStorm.
 * User: ana.magnoni
 * Date: 2019-02-20
 * Time: 11:02
 */

if (preg_match('/payment/', $_SERVER["REQUEST_URI"])) {

} else {
    readfile("public/index.html");
}
?>