<?php

include_once __DIR__ . '/../vendor/autoload.php';
use Ebanx\Benjamin\Models\Configs\Config;

class Handler
{
    private $benjamin_config;

    public function __construct() {
//        $this->benjamin_config = new Config();
        echo 'Handler instanciado';
    }
}