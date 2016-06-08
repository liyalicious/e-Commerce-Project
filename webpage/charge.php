
<?php
  require_once('./config.php');

  \Stripe\Stripe::setApiKey("sk_test_5UGz5M1VSGnonl2wFS85PsPb");

  $token  = $_POST['stripeToken'];
  $customer = \Stripe\Customer::create(array(
      'email' => 'customer@example.com',
      'card'  => $token
  ));
  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd'
  ));
  //echo '<h1>Successfully charged $5!</h1>';
  header('Location: http://localhost/monthly_moonshine/Big_Picture/webpage/thank_you.html');

?>