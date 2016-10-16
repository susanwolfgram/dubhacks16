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
  echo('<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script type="text/javascript">');
  include_once('penny.js'); 
  echo('addOneDollar();');
  echo('</script>'); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Set meta properties -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penny-fyt</title>
    
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>



    <!-- AngularFire -->
    <script src="https://cdn.firebase.com/libs/angularfire/2.0.2/angularfire.min.js"></script>
    
    <!-- Scripts -->
    <link href="penny.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="penny.js"></script>

<script src="https://www.gstatic.com/firebasejs/3.5.0/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
  apiKey: "AIzaSyDeKkdADM8ybE_etN7XwiyrA-tfSWVozi4",
  authDomain: "penny-fyt-123.firebaseapp.com",
  databaseURL: "https://penny-fyt-123.firebaseio.com",
  storageBucket: "penny-fyt-123.appspot.com",
  messagingSenderId: "370933887602"
  };
  firebase.initializeApp(config);
  addOneDollar(); 
</script>
<!-- <script src="https://www.gstatic.com/firebasejs/3.5.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.5.0/firebase-auth.js"></script> -->

  </head>
</html>
<?php
echo('success');
  // header('Location: penny.php');
?>