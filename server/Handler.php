<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/helpers/RandomStringGenerator.php';
include_once __DIR__ . '/helpers/HTMLConstructor.php';

use Ebanx\Benjamin\Models\Address;
use Ebanx\Benjamin\Models\Card;
use Ebanx\Benjamin\Models\Configs\Config;
use Ebanx\Benjamin\Models\Configs\CreditCardConfig;
use Ebanx\Benjamin\Models\Country;
use Ebanx\Benjamin\Models\Currency;
use Ebanx\Benjamin\Models\Payment;
use Ebanx\Benjamin\Models\Person;

class Handler {
    const CREDITCARD = 'creditcard';
    const BOLETO = 'boleto';
    const SUCCESS = 'SUCCESS';

    private $fields;
    private $benjamin_config;
    private $ebanx;

    public function __construct() {
        $this->benjamin_config = new Config([
            'sandboxIntegrationKey' => '1231000',
            'isSandbox' => true,
            'baseCurrency' => Currency::BRL
        ]);
    }

    public function setFields($fields): bool {
        $validFields = $this->validateFields($fields);

        if ($validFields) {
            $this->fields = $fields;

            $this->fields['payment-type'] == self::CREDITCARD
                ? $this->ebanx = EBANX($this->benjamin_config, new CreditCardConfig())
                : $this->ebanx = EBANX($this->benjamin_config);
        }

        return $validFields;
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

        if ($result['status'] == self::SUCCESS) {
            if ($this->fields['payment-type'] == self::BOLETO) {
                echo HTMLConstructor::renderSuccessBoletoPayment($result['payment']['boleto_url']);
            } else if ($this->fields['payment-type'] == self::CREDITCARD) {
                echo HTMLConstructor::renderSuccessCreditCardPayment();
            }
        } else {
            var_dump($result);
        }
    }

    private function generatePayment(): Array {
        return $this->ebanx->create($this->returnPaymentInfo());
    }

    private function returnPaymentInfo(): Payment {
        // Filling general data (for both Boleto and Credit Card)
        $pay_parameters = [
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
            'person' => new Person([
                'type' => '',
                'birthdate' => '',
                'document' => $this->fields['document'],
                'email' => $this->fields['email'],
                'ip' => '127.0.0.1',
                'name' => $this->fields['name'],
                'phoneNumber' => $this->fields['phone-number']
            ]),
            'dueDate' => (new DateTime())->modify('+3 days')
        ];

        // If it's a Credit Card payment, should include corresponding data
        if($this->fields['payment-type'] === self::CREDITCARD){
            $pay_parameters['card'] = new Card([
                'cvv' => $this->fields['creditcard-cvv'],
                'dueDate' => \DateTime::createFromFormat('n-Y', str_replace('/', '-', $this->fields['creditcard-duedate'])),
                'name' => $this->fields['creditcard-holder'],
                'number' => $this->fields['creditcard-number'],
            ]);
        }

        return new Payment($pay_parameters);
    }
}