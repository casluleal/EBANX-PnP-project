<?php
require_once __DIR__ . '/../server/Handler.php';

class HandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testSetFieldsWithCorrectValues_Boleto(): void {
        $_POST = $this->returnCorrectBoletoPaymentFields();

        $handler = new Handler();
        $this->assertTrue($handler->setFields($_POST));
    }

    public function testSetFieldsWithEmptyName_Boleto_ShouldFail(): void {
        $_POST = $this->returnWrongBoletoPaymentFields();

        $handler = new Handler();
        $this->assertFalse($handler->setFields($_POST));
    }

    public function testSetFieldsWithCorrectValues_CreditCard(): void {
        $_POST = $this->returnCorrectCreditCardPaymentFields();

        $handler = new Handler();
        $this->assertTrue($handler->setFields($_POST));
    }

    public function testSetFieldsWithEmptyFields_CreditCard_ShouldFail(): void {
        $_POST = $this->returnWrongCreditCardPaymentFields();

        $handler = new Handler();
        $this->assertFalse($handler->setFields($_POST));
    }

//    public function testPaymentCreationWithCorrectFields(): void {
//
//    }

    private function returnCorrectBoletoPaymentFields(): array {
        $arr = array();
        $arr['value'] = 10.50;
        $arr['name'] = 'Carlos de Oliveira';
        $arr['document'] = '062.965.419-02';
        $arr['email'] = 'carlos.oliveira@ebanx.com';
        $arr['phone-number'] = '41999998765';
        $arr['zipcode'] = '82510180';
        $arr['state'] = 'Paraná';
        $arr['city'] = 'Curitiba';
        $arr['street'] = 'Rua Marechal Deodoro';
        $arr['address-number'] = '650';
        $arr['payment-type'] = 'boleto';

        return $arr;
    }

    private function returnWrongBoletoPaymentFields(): array {
        $arr = array();
        $arr['value'] = 10.50;
        $arr['name'] = '';
        $arr['document'] = '';
        $arr['email'] = '';
        $arr['phone-number'] = '41999998765';
        $arr['zipcode'] = '82510180';
        $arr['state'] = 'Paraná';
        $arr['city'] = 'Curitiba';
        $arr['street'] = 'Rua Marechal Deodoro';
        $arr['address-number'] = '650';
        $arr['payment-type'] = 'boleto';

        return $arr;
    }

    private function returnCorrectCreditCardPaymentFields(): array {
        $arr = array();
        $arr['value'] = 10.50;
        $arr['name'] = 'Carlos de Oliveira';
        $arr['document'] = '062.965.419-02';
        $arr['email'] = 'carlos.oliveira@ebanx.com';
        $arr['phone-number'] = '41999998765';
        $arr['zipcode'] = '82510180';
        $arr['state'] = 'Paraná';
        $arr['city'] = 'Curitiba';
        $arr['street'] = 'Rua Marechal Deodoro';
        $arr['address-number'] = '650';
        $arr['payment-type'] = 'creditcard';
        $arr['creditcard-holder'] = 'CARLOS DE OLIVEIRA';
        $arr['creditcard-number'] = '4111111111111111';
        $arr['creditcard-duedate'] = '11/30';
        $arr['creditcard-duedate'] = '123';

        return $arr;
    }

    private function returnWrongCreditCardPaymentFields(): array {
        $arr = array();
        $arr['value'] = 10.50;
        $arr['name'] = 'Carlos de Oliveira';
        $arr['document'] = '062.965.419-02';
        $arr['email'] = 'carlos.oliveira@ebanx.com';
        $arr['phone-number'] = '41999998765';
        $arr['zipcode'] = '82510180';
        $arr['state'] = 'Paraná';
        $arr['city'] = 'Curitiba';
        $arr['street'] = 'Rua Marechal Deodoro';
        $arr['address-number'] = '650';
        $arr['payment-type'] = 'creditcard';
        $arr['creditcard-holder'] = '';
        $arr['creditcard-number'] = '';
        $arr['creditcard-duedate'] = '';
        $arr['creditcard-duedate'] = '';

        return $arr;
    }
}