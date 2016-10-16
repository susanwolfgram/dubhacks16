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
  const DEFAULT_URL = 'https://penny-fyt-123.firebaseio.com';
  const DEFAULT_TOKEN = 'AIzaSyDeKkdADM8ybE_etN7XwiyrA-tfSWVozi4';
  const DEFAULT_PATH = '/firebase/example';
  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
  $test = array(
    "foo" => "bar",
    "i_love" => "lamp",
    "id" => 42
);
$dateTime = new DateTime();
$firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);
?>

<?php
echo('success');
  // header('Location: penny.php');
?>