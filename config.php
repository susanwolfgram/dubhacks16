<?php
require_once('init.php');

$stripe = array(
  "secret_key"      => "sk_test_XoQIPeA6WbJQomV7yMJ8K7F8",
  "publishable_key" => "pk_test_6TxN5xUdWFAeyDLbeHyoPJ6Q"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>