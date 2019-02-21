<?php
/**
 * Created by PhpStorm.
 * User: lucas.silva
 * Date: 2019-02-21
 * Time: 11:17
 */

class HTMLConstructor
{
    public static function renderSuccessBoletoPayment($url): string {
        return '<div style="background-color: #e4ffbf;
                color: #52a353; font-size: 115%; padding: 1em 1.5em; 
                margin-bottom: 1em; border: 1px solid #52a353">
                    <b>Sucesso!</b> Seu pagamento foi confirmado.
                    <br>
                    <a href="' . $url . '">Clique aqui para pagar seu boleto.</a>
                </div>';
    }
}