<?php

include_once __DIR__ . '/../vendor/autoload.php';
use Ebanx\Benjamin\Models\Configs\Config;
use Ebanx\Benjamin\Models\Currency;

class Handler
{
    const CREDITCARD = 'creditcard';
    const BOLETO = 'boleto';

    private $fields;
    private $benjamin_config;
    private $ebanx;

    public function __construct()
    {
        $this->benjamin_config = new Config([
            'sandboxIntegrationKey' => '1231000',
            'isSandbox' => true,
            'baseCurrency' => Currency::BRL
        ]);

        $this->ebanx = EBANX($this->benjamin_config);
    }

    public function setFields($fields): bool {
        if ($this->validateFields($fields)) {
            $this->fields = $fields;
            return true;
        } else {
            return false;
        }
    }

    private function validateFields($fields): bool {
        if (isset($fields['payment-type'])) {
            $isBoleto = $fields['payment-type'] == self::BOLETO; // Check if the payment type is BOLETO
            $isValid = true;

            /* For each field in $_POST, check if it's not empty.
             * If a credit card field is empty, but the payment type is boleto, ignore it
             */
            foreach ($fields as $field => $value) {
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

    public function generatePayment()
    {
        echo 'hello';
    }
}