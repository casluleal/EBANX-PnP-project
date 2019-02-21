<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/RandomStringGenerator.php';
include_once __DIR__ . '/HTMLConstructor.php';

use Ebanx\Benjamin\Models\Address;
use Ebanx\Benjamin\Models\Configs\Config;
use Ebanx\Benjamin\Models\Country;
use Ebanx\Benjamin\Models\Currency;
use Ebanx\Benjamin\Models\Payment;
use Ebanx\Benjamin\Models\Person;


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

    public function pay() {
        $result = $this->generatePayment();

        if ($result['status'] == 'SUCCESS' && $this->fields['payment-type'] == self::BOLETO) {
            echo HTMLConstructor::renderSuccessBoletoPayment($result['payment']['boleto_url']);
        }
    }

    private function generatePayment(): Array {
        return $this->ebanx->create($this->returnPaymentInfo());
    }

    private function returnPaymentInfo():Payment {

        return new Payment([
            'type' => $this->fields['payment-type'],
            'address' => new Address([
                'address' => $this->fields['street'],
                'city' => $this->fields['city'],
                'country' => Country::BRAZIL,
                'state' => $this->fields['state'],
                'streetComplement' => '',
                'streetNumber' => $this->fields['address-number'],
                'zipcode' => $this->fields['zipcode']
            ]),
            'amountTotal' => $this->fields['value'],
            'deviceId' => '',
            'merchantPaymentCode' => RandomStringGenerator::generate(),
            //'note' => 'Example payment.',
            'person' => new Person([
                'type' => '',
                'birthdate' => '', //new \DateTime('1978-03-29 08:15:51.000000 UTC'),
                'document' => $this->fields['document'],
                'email' => $this->fields['email'],
                'ip' => '127.0.0.1',
                'name' => $this->fields['name'],
                'phoneNumber' => $this->fields['phone-number']
            ]),
            'items' => [],
            'responsible' => [],
            'dueDate' => (new DateTime())->modify('+2 days')
        ]);
    }
}