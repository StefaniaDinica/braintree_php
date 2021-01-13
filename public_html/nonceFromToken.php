<?php
require_once("../includes/braintree_init.php");
require_once("email.php");

$clientEmail = $_POST["email"];
$nonce = $_POST["payment_method_nonce"];

$resultCreateCustomer = $gateway->customer()->create([
    'email' => $clientEmail,
    'paymentMethodNonce' => $nonce,
    'creditCard' => [
        'options' => [
            'verifyCard' => 'true'
        ],
    ],
]);

$result = $gateway->paymentMethodNonce()->create($resultCreateCustomer->customer->paymentMethods[0]->token);
$nonceFromToken = $result->paymentMethodNonce->nonce;

echo json_encode([
    'nonce' => $nonceFromToken
]);