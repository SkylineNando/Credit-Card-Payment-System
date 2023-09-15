# Credit-Card-Payment-System
Sistema de pagamento com cartão de credito

Para implementar um sistema de pagamento com cartão de crédito usando o PagSeguro e PHP, você pode seguir os passos abaixo:

### Passo 1: Criar uma conta no PagSeguro

1. Acesse o site do [PagSeguro](https://pagseguro.uol.com.br/) e crie uma conta ou faça login se já tiver uma.

2. No painel de controle do PagSeguro, obtenha as credenciais necessárias (Token de Produção, Token de Sandbox, e Email de Vendedor).

### Passo 2: Configurar o ambiente PHP

1. Certifique-se de que você tem o PHP instalado no seu servidor.

2. Se você não tiver o Composer instalado, faça o download e instale a partir do site oficial: [Composer](https://getcomposer.org/).

3. Crie um novo diretório para o seu projeto e dentro dele, crie um arquivo `composer.json` com o seguinte conteúdo:

```json
{
    "require": {
        "pagseguro/pagseguro-php-sdk": "dev-main"
    }
}
```

4. No terminal, dentro do diretório do seu projeto, execute o comando `composer install` para instalar a biblioteca do PagSeguro.

### Passo 3: Criar a página de pagamento

1. Crie um arquivo PHP (por exemplo, `checkout.php`) para a página de pagamento.

2. No início do arquivo, inclua a biblioteca do PagSeguro:

```php
require_once 'vendor/autoload.php';
```

3. No corpo do arquivo, crie um formulário com os campos necessários para a transação (número do cartão, data de validade, código CVV, etc.).

4. No script de processamento do formulário, utilize o código PHP para criar uma transação no PagSeguro:

```php
$paymentData = [
    'email' => 'SEU_EMAIL_DE_VENDEDOR',
    'token' => 'SEU_TOKEN_DE_PRODUCAO',
    'paymentMode' => 'default',
    'paymentMethod' => 'creditCard',
    'receiverEmail' => 'SEU_EMAIL_DE_VENDEDOR',
    'currency' => 'BRL',
    'itemId1' => '1',
    'itemDescription1' => 'Produto de Exemplo',
    'itemAmount1' => '10.00',
    'itemQuantity1' => '1',
    'notificationURL' => 'URL_PARA_NOTIFICACAO_DE_PAGAMENTO',
    'reference' => 'REF1234', // Referência única para a transação
    'senderName' => $_POST['senderName'],
    'senderAreaCode' => $_POST['senderAreaCode'],
    'senderPhone' => $_POST['senderPhone'],
    'senderEmail' => $_POST['senderEmail'],
    'senderCPF' => $_POST['senderCPF'],
    'installmentQuantity' => '1',
    'installmentValue' => '10.00',
    'creditCardToken' => $_POST['creditCardToken'],
    'billingAddressStreet' => $_POST['billingAddressStreet'],
    'billingAddressNumber' => $_POST['billingAddressNumber'],
    'billingAddressComplement' => $_POST['billingAddressComplement'],
    'billingAddressDistrict' => $_POST['billingAddressDistrict'],
    'billingAddressPostalCode' => $_POST['billingAddressPostalCode'],
    'billingAddressCity' => $_POST['billingAddressCity'],
    'billingAddressState' => $_POST['billingAddressState'],
    'billingAddressCountry' => 'BRA'
];

$credentials = new \PagSeguroAccountCredentials($paymentData['email'], $paymentData['token']);
$payment = new \PagSeguroPaymentRequest($credentials);
$payment->setCurrency($paymentData['currency']);
$payment->setReference($paymentData['reference']);
$payment->addItem(
    $paymentData['itemId1'],
    $paymentData['itemDescription1'],
    $paymentData['itemQuantity1'],
    $paymentData['itemAmount1']
);

$payment->setSender(
    $_POST['senderName'],
    $_POST['senderEmail'],
    $_POST['senderAreaCode'],
    $_POST['senderPhone']
);

$payment->setShippingAddress(
    $_POST['billingAddressStreet'],
    $_POST['billingAddressNumber'],
    $_POST['billingAddressComplement'],
    $_POST['billingAddressDistrict'],
    $_POST['billingAddressCity'],
    $_POST['billingAddressState'],
    $_POST['billingAddressPostalCode'],
    'BRA'
);

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
```

### Passo 4: Testar o sistema

Agora, você deve ser capaz de testar o sistema de pagamento com cartão de crédito usando o PagSeguro. Lembre-se de que isso é apenas um exemplo básico e que existem muitos aspectos de segurança e validação que você deve considerar em uma implementação real.

Além disso, é importante ler a documentação do PagSeguro e entender completamente como lidar com pagamentos de forma segura e em conformidade com as regulamentações locais.
