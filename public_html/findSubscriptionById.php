<?php
require_once("../includes/braintree_init.php");

$id = $_POST["id"];

try {
  $subscription = $gateway->subscription()->find($id);
  echo json_encode([
    'paymentMethodToken' => $subscription->paymentMethodToken
  ]);
} catch (Braintree\Exception\NotFound $e) {
  echo json_encode(['error' => $e->getMessage()]);
}