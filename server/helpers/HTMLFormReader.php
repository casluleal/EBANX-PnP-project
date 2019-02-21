<?php

class HTMLFormReader {
    public static function readHTMLForm($status = 0) {
        if ($status == 0) {
            readfile("public/index.html");
        } else if ($status == 1) {
            readfile("public/error-form.html");
        }
    }
}