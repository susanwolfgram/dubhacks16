<?php
  require_once('./config.php');
  if (isset($_POST['stripeToken'])) {
  $token  = $_POST['stripeToken'];

  $customer = \Stripe\Customer::create(array(
      'email' => 'customer@example.com',
      'source'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 100,
      'currency' => 'usd'
  ));
}
echo('success');
//header('Location: penny.php?dollar=true');
?>