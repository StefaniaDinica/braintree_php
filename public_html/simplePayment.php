<?php
require_once("../includes/braintree_init.php");

$amount = $_POST["amount"];
$nonce = $_POST["payment_method_nonce"];
$email = $_POST["email"];

$result = $gateway->transaction()->sale([
    'amount' => $amount,
    'paymentMethodNonce' => $nonce,
    'options' => [
        'submitForSettlement' => true
    ],
    'customer' => [
        'email' => $email
    ],
]);

if (!$result->success) {
    $errorString = "";

    foreach($result->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    error_log("Transaction could not be created. " + $errorString);

    echo json_encode([
        'success' => false,
        'errorString' => $errorString
    ]);
} else {
    echo json_encode(['success' => true]);
}
