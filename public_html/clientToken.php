<?php
require_once("../includes/braintree_init.php");

echo json_encode([
  'token' => $gateway->ClientToken()->generate()
]);