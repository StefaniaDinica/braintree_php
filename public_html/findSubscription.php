<?php
require_once("../includes/braintree_init.php");

$email = $_POST["email"];

$customers = $gateway->customer()->search([
  Braintree\CustomerSearch::email()->is("$email")
]);

$subscriptions = array();
$counter = 0;

foreach($customers as $customer) {
  foreach($customer->creditCards as $creditCard) {
    if (count($creditCard->subscriptions) > 0) {
      foreach($creditCard->subscriptions as $subscription) {
        $subscriptions[$counter++] = [
          "id" => $subscription->id,
          "status" => $subscription->status,
          "createdAt" => $subscription->createdAt,
          "price" => $subscription->price,
          "transactions" => $subscription->transactions
        ];
      }
    }
  }
}

echo json_encode([
  'subscriptions' => $subscriptions
]);