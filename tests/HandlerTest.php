<?php
require_once __DIR__ . '/../server/Handler.php';

class HandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testValidateBoletoFields(): void {
        $_POST['value'] = 10.50;
        $_POST['name'] = 'Carlos de Oliveira';
        $_POST['document'] = '062.965.419-02';
        $_POST['email'] = 'carlos.oliveira@ebanx.com';
        $_POST['phone-number'] = '41999998765';
        $_POST['zipcode'] = '82510180';
        $_POST['state'] = 'Paraná';
        $_POST['city'] = 'Curitiba';
        $_POST['street'] = 'Rua Marechal Deodoro';
        $_POST['address-number'] = '650';
        $_POST['payment-type'] = 'boleto';

        $handler = new Handler($_POST);
        $this->assertTrue($handler->validateFields());
    }

    public function testValidateBoletoFieldsShouldFail(): void {
        $_POST['value'] = 10.50;
        $_POST['name'] = '';
        $_POST['document'] = '062.965.419-02';
        $_POST['email'] = 'carlos.oliveira@ebanx.com';
        $_POST['phone-number'] = '41999998765';
        $_POST['zipcode'] = '82510180';
        $_POST['state'] = 'Paraná';
        $_POST['city'] = 'Curitiba';
        $_POST['street'] = 'Rua Marechal Deodoro';
        $_POST['address-number'] = '650';
        $_POST['payment-type'] = 'boleto';

        $handler = new Handler($_POST);
        $this->assertFalse($handler->validateFields());
    }
}