<?php
require_once("../includes/braintree_init.php");

$subscriptionId = $_GET["subscriptionId"];

try {
  $resultCancelSubscription = $gateway->subscription()->cancel($subscriptionId);
  if (!$resultCancelSubscription->success) {
    foreach($resultCancelSubscription->errors->deepAll() as $error) {
        if ($error->code == 81905) {
          $cancelSubscriptionMessage = "Ati fost deja dezabonat de la aceasta subscriptie.";
          return;
        } else {
          $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }
    }

    error_log($errorString . " SubscriptionId: " . $subscriptionId);

    $cancelSubscriptionMessage = "A intervenit o problema. Contactati echipa de support.";
  } else {
    $cancelSubscriptionMessage = "Ati fost dezabonat cu succes!";
  }
} catch (Braintree_Exception_NotFound $e) {
  error_log("Subscription not found. SubscriptionId: " . $subscriptionId);

  $cancelSubscriptionMessage = "A intervenit o problema. Contactati echipa de support.";
}