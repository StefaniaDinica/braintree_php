<?php
require_once("../includes/braintree_init.php");

$data = [token => $gateway->ClientToken()->generate()];
echo json_encode($data);