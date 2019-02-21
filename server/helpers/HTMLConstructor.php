<?php
include __DIR__ . '/IntegrationErrorTranslater.php';

class HTMLConstructor {
    public static function renderSuccessBoletoPayment($integration_response): string {
        return <<<HTML
<div style="display: flex; align-items: center; justify-content: center">
    <img src="https://www.ebanx.com/wp-content/themes/ebanx/images/logo.svg" alt="Logo EBANX" style="max-width: 25%; padding: 1.5em">
</div>
<div style="background-color: #e4ffbf; color: #52a353; font-size: 115%; padding: 1em 1.5em; margin-bottom: 1em; border: 1px solid #52a353">
    <b>Sucesso!</b> Seu boleto foi gerado.
    <br><br>
    <a href="{$integration_response['payment']['boleto_url']}">Clique aqui para pagá-lo e efetivar sua compra.</a>
    
    <h1>Informações sobre sua compra</h1>
    <ul>
        <li><b>Código de barras: </b>{$integration_response['payment']['boleto_barcode']}</li>
        <li><b>Valor: </b>R\${$integration_response['payment']['amount_br']}</li>
        <li><b>Vencimento: </b>{$integration_response['payment']['due_date']}</li>
    </ul>
</div>
HTML;
    }

    public static function renderSuccessCreditCardPayment($integration_response): string {
        return <<<HTML
<div style="display: flex; align-items: center; justify-content: center">
    <img src="https://www.ebanx.com/wp-content/themes/ebanx/images/logo.svg" alt="Logo EBANX" style="max-width: 25%; padding: 1.5em">
</div>
<div style="background-color: #e4ffbf; color: #52a353; font-size: 115%; padding: 1em 1.5em; margin-bottom: 1em; border: 1px solid #52a353">
    <b>Sucesso!</b> Seu pagamento por cartão de crédito foi realizado.
    
    <h1>Informações sobre sua compra</h1>
    <ul>
        <li><b>Valor: </b>R\${$integration_response['payment']['amount_br']}</li>
        <li><b>Parcelas: </b>{$integration_response['payment']['instalments']}</li>
    </ul>
</div>
HTML;
    }

    public static function renderErrorBoletoPayment($integration_response): string {
        $error_message = IntegrationErrorTranslater::translate($integration_response['status_code']);

        return <<<HTML
<div style="display: flex; align-items: center; justify-content: center">
    <img src="https://www.ebanx.com/wp-content/themes/ebanx/images/logo.svg" alt="Logo EBANX" style="max-width: 25%; padding: 1.5em">
</div>
<div style="background-color: #ffbcbc; color: #a33b46; font-size: 115%; padding: 1em 1.5em; margin-bottom: 1em; border: 1px solid #a33b46">
    Ops! Seu boleto não pôde ser gerado.
    <br><br>
    <b>Erro: </b>{$error_message}
</div>
HTML;
    }

    public static function renderErrorCreditCardPayment($integration_response): string {
        $error_message = IntegrationErrorTranslater::translate($integration_response['status_code']);

        return <<<HTML
<div style="display: flex; align-items: center; justify-content: center">
    <img src="https://www.ebanx.com/wp-content/themes/ebanx/images/logo.svg" alt="Logo EBANX" style="max-width: 25%; padding: 1.5em">
</div>
<div style="background-color: #ffbcbc; color: #a33b46; font-size: 115%; padding: 1em 1.5em; margin-bottom: 1em; border: 1px solid #a33b46">
    Ops! Seu pagamento com cartão de crédito não pôde ser realizado.
    <br><br>
    <b>Erro: </b>{$error_message}
</div>
HTML;
    }
}