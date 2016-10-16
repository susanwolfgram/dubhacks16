
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
  echo('<script type="text/javascript" src="penny.js"></script>'); 
  echo '<script type="text/javascript">',
     'addOneDollar();',
     '</script>'
  ;
?>

<?php
  header('Location: penny.php');
?>