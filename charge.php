
<?php
  require_once('./config.php');

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
  echo('<script type="text/javascript">');
  require_once('penny.js'); 
  echo('addOneDollar()');
  echo('</script>'); 
?>

<?php
echo('success');
  // header('Location: penny.php');
?>