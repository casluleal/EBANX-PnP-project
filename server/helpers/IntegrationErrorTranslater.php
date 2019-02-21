<?php
/**
 * Created by PhpStorm.
 * User: lucas.silva
 * Date: 2019-02-21
 * Time: 16:20
 */

class IntegrationErrorTranslater {
    public static function translate($status_code): string {
        if ($status_code === 'BP-ZIP-1')
            return 'você esqueceu de nos informar seu CEP.';
        else if ($status_code === 'BP-DR-49')
            return 'você esqueceu de nos informar o numero do seu cartão de crédito.';
        else if ($status_code === 'BP-DR-51')
            return 'você esqueceu de preencher o nome do titular do cartão de crédito.';
        else if ($status_code === 'BP-DR-54')
            return 'faltou o CCV do seu cartão de crédito.';
        else if ($status_code === 'BP-DR-56')
            return 'faltou o número do seu cartão de crédito.';
        else if ($status_code === 'BP-DR-13')
            return 'você se esqueceu de nos dizer seu nome.';
        else if ($status_code === 'BP-DR-15')
            return 'faltou preencher o seu email.';
        else
            return 'verifique suas informações e tente novamente.';
    }
}