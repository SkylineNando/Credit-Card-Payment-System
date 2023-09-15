<?php
require_once 'vendor/autoload.php';

$paymentData = [
    'email' => 'SEU_EMAIL_DE_VENDEDOR',
    'token' => 'SEU_TOKEN_DE_PRODUCAO',
    // Resto dos campos de pagamento aqui...
];

$credentials = new \PagSeguroAccountCredentials($paymentData['email'], $paymentData['token']);
$payment = new \PagSeguroPaymentRequest($credentials);
// Configurar os detalhes do pagamento com base nos dados do formulário

try {
    $credentials->authorize(
        new \PagSeguroApplicationCredentials(),
        \PagSeguroConfig::getAccountCredentials()
    );

    $transaction = \PagSeguroTransactionService::createTransaction($credentials, $payment);

    if ($transaction) {
        // A transação foi criada com sucesso
        echo 'Pagamento bem-sucedido!';
    } else {
        // Falha ao criar a transação
        echo 'Ocorreu um erro ao processar o pagamento.';
    }
} catch (\Exception $e) {
    echo 'Ocorreu um erro: ' . $e->getMessage();
}
?>
