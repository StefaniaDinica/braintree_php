<?php
require_once("../includes/braintree_init.php");

$amount = $_POST["amount"];
$nonce = $_POST["payment_method_nonce"];

$resultCreateCustomer = $gateway->customer()->create([
    'paymentMethodNonce' => $nonce
]);

if ($resultCreateCustomer->success) {
    $resultCreateSubscription = $gateway->subscription()->create([
        'paymentMethodToken' => $resultCreateCustomer->customer->paymentMethods[0]->token,
        'planId' => $planId,
        'price' => $amount
    ]);
}

header('Content-type: application/json');

if ($resultCreateSubscription->success) {
    $data = ['success' => true];
    echo json_encode( $data );
} else {
    $errorString = "";

    foreach($resultCreateSubscription->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    $data = ['success' => false, 'errorString' => $errorString];
    echo json_encode( $data );
}
