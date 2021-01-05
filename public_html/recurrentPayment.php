<?php
require_once("../includes/braintree_init.php");
require_once("email.php");

$amount = $_POST["amount"];
$clientEmail = $_POST["email"];
$upgradedNonce = $_POST["payment_method_nonce"];
$errorString = "";

$resultCreateSubscription = $gateway->subscription()->create([
    'paymentMethodNonce' => $upgradedNonce,
    'planId' => $planId,
    'price' => $amount
]);
  
header('Content-type: application/json');

if (!$resultCreateSubscription->success) {
    foreach($resultCreateSubscription->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    // error_log("Subscription could not be created. " + $errorString);

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
        // error_log("Email could not be sent. ");

        $emailSent = false;
    }

    echo json_encode([
        'success' => true,
        'emailSent' => $emailSent,
        'result' => $resultCreateSubscription
    ]);
}