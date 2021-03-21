<?php
require_once("../includes/braintree_init.php");

$newPaymentMethodNonce = $_POST["newPaymentMethodNonce"];
$oldPaymentMethodToken = $_POST["oldPaymentMethodToken"];

try {
  $result = $gateway->paymentMethod()->update(
    $oldPaymentMethodToken,
    [
      'paymentMethodNonce' => $newPaymentMethodNonce
  ]);

  echo json_encode([
    'result' => $result,
    'success' => $result->success,
    'message' => 'Cardul a fost updatat cu succes!'
  ]);
} catch (Braintree\Exception\NotFound $e) {
  echo json_encode([
    'error' => $e->getMessage(),
    'message' =>  'A intervenit o problema. Contactati echipa de support.'
  ]);
}

