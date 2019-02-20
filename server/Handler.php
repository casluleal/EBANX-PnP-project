<?php

include_once __DIR__ . '/../vendor/autoload.php';
use Ebanx\Benjamin\Models\Configs\Config;

class Handler
{
    const CREDITCARD = 'creditcard';
    const BOLETO = 'boleto';

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
            $isBoleto = $this->info['payment-type'] == self::BOLETO; // Check if the payment type is BOLETO
            $isValid = true;

            /* For each field in $_POST, check if it's not empty.
             * If a credit card field is empty, but the payment type is boleto, ignore it
             */
            foreach ($this->info as $field => $value) {
                if ($isBoleto && substr($field, 0, 10) == self::CREDITCARD)
                    continue; // Ignoring credit card fields if it's a boleto payment

                if (empty($value))
                    return false;
            }

            return $isValid;
        } else {
            return false;
        }
    }
}