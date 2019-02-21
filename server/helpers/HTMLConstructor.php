<?php

class HTMLConstructor {
    public static function renderSuccessBoletoPayment($url): string {
        return <<<HTML
<div style="background-color: #e4ffbf; color: #52a353; font-size: 115%; padding: 1em 1.5em; margin-bottom: 1em; border: 1px solid #52a353">
    <b>Sucesso!</b> Seu boleto foi gerado.
    <br>
    <a href="{$url}">Clique aqui para pagá-lo e efetivar sua compra.</a>
</div>
HTML;
    }

    public static function renderSuccessCreditCardPayment(): string {
        return <<<HTML
<div style="background-color: #e4ffbf; color: #52a353; font-size: 115%; padding: 1em 1.5em; margin-bottom: 1em; border: 1px solid #52a353">
    <b>Sucesso!</b> Seu pagamento por cartão de crédito foi realizado.
    <br>
</div>
HTML;
    }
}