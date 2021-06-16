<?php
require_once("../includes/braintree_init.php");

$price = $_POST["price"];
$subscriptionId = $_POST["subscriptionId"];

try {
  $result = $gateway->subscription()->update(
    $subscriptionId,
    [
      'price' => $price
  ]);
  echo json_encode([
    'success' => $result->success,
    'message' => 'Pretul a fost updatat cu succes!'
  ]);
} catch (Braintree\Exception\NotFound $e) {
  echo json_encode([
    'error' => $e->getMessage(),
    'message' =>  'A intervenit o problema. Contactati echipa de support.'
  ]);
}