<?php
require_once("../includes/braintree_init.php");

$subscriptionId = $_GET["subscriptionId"];

try {
  $resultCancelSubscription = $gateway->subscription()->cancel($subscriptionId);
  echo json_encode([
    'message' => 'Ati fost dezabonat cu succes de la subscriptia selectata!'
  ]);
} catch (Braintree\Exception\NotFound $e) {
  error_log("Subscription not found. SubscriptionId: " . $subscriptionId);

  echo json_encode([
    'error' => $e->getMessage(),
    'message' =>  'A intervenit o problema. Contactati echipa de support.'
  ]);
}