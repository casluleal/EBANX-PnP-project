<?php

include_once __DIR__ . '/../vendor/autoload.php';
use Ebanx\Benjamin\Models\Configs\Config;

class Handler
{
    private $benjamin_config;
    private $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function printInfo(): void {
        foreach ($this->info as $field) {
            echo $field . '<br>';
        }
    }

    public function validateFields(): bool {
        if (isset($this->info['payment-type'])) {
            $boleto = $this->info['payment-type'] == 'boleto';
            $isValid = true;

            foreach ($this->info as $key => $field) {
                $isValid = !empty($field);

                if ($boleto && !$isValid && substr($key, 0, 10) == 'creditcard') {
                    $isValid = true;
                }

                if(!$isValid)
                    return false;
            }

            return $isValid;
        } else {
            return false;
        }
    }
}