<?php
require_once("../includes/braintree_init.php");
require_once("email.php");

$amount = $_POST["amount"];
$clientEmail = $_POST["email"];
$nonce = $_POST["payment_method_nonce"];
$errorString = "";

$resultCreateCustomer = $gateway->customer()->create([
    'email' => $clientEmail,
    'paymentMethodNonce' => $nonce
]);

if (!$resultCreateCustomer->success) {
    foreach($resultCreateCustomer->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    error_log("Customer could not be created. " + $errorString);

    echo json_encode([
        'success' => false,
        'errorString' => $errorString
    ]);

    return;
} else {
    $resultCreateSubscription = $gateway->subscription()->create([
        'paymentMethodToken' => $resultCreateCustomer->customer->paymentMethods[0]->token,
        'planId' => $planId,
        'price' => $amount
    ]);
}

header('Content-type: application/json');

if (!$resultCreateSubscription->success) {
    foreach($resultCreateSubscription->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    error_log("Subscription could not be created. " + $errorString);

    echo json_encode([
        'success' => false,
        'errorString' => $errorString
    ]);
} else {
    $numEmailsSent = sendEmail(
        $clientEmail, 
        $baseUrl . "/subscriptionCanceled.php?subscriptionId=" . $resultCreateSubscription->subscription->id
    );

    $emailSent = true;
    if ($numEmailsSent == 0) {
        error_log("Email could not be sent. ");

        $emailSent = false;
    }

    echo json_encode([
        'success' => true,
        'emailSent' => $emailSent,
        'result' => $resultCreateSubscription
    ]);
}
