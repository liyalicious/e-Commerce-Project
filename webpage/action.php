<?php
//echo "<pre>";print_r($_REQUEST);
/*** mysql hostname ***/

require_once('vendor/autoload.php');
/*echo "<script type="text/javascript" src="https://js.stripe.com/v2/"></script>";

\Stripe\Stripe::setApiKey("sk_test_5UGz5M1VSGnonl2wFS85PsPb");

echo "<script type="text/javascript"> Stripe.setPublishableKey('pk_test_TnBNkzIo8DnEV5CwI1EVLsV3');</script>";

echo "1";*/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'root';

/*** mysql password ***/
$password = 'wampp';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=mysql", $username);
    /*** echo a message saying we have connected ***/
   // echo "Connected to databasen\n";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
  $price = 0;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$name = test_input($_POST["firstname"]) +" "+ test_input($_POST["lastname"]);
  	$email = test_input($_POST["email"]);
  	$birthdate = test_input($_POST["bday"]);
    //$gov_id = test_input($_POST["ID"]);
    $street_address = test_input($_POST["address"]);
    $city = test_input($_POST["city"]);
    $state  = test_input($_POST["state"]);
    $zipcode  = test_input($_POST["zipcode"]);
	  $expiration = test_input($_POST["expiration"]);
    $cvc = test_input($_POST["cvc"]);
    $credit = test_input($_POST["cardnumber"]);
    if (test_input($_POST["cb"])=='on'){
      $price += 20;
    }
    if (test_input($_POST["w"])=='on'){
      $price += 25;
    }
    if (test_input($_POST["lq"])=='on'){
      $price += 30;
    }
    if (test_input($_POST["everyt"])=='on'){
      $price += 40;
    }


    \Stripe\Stripe::setApiKey("sk_test_5UGz5M1VSGnonl2wFS85PsPb");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

$price = $price * 100;

$customer = \Stripe\Customer::create(array(
  "source" => $token,
  "description" => $name+"")
);

// Create the charge on Stripe's servers - this will charge the user's card
try {
  $charge = \Stripe\Charge::create(array(
    "amount" => $price, // amount in cents, again
    "currency" => "usd",
    'customer' => $customer->id,
    "description" => "Charge"
    ));
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}



	}

  

    $sql = "INSERT INTO `test`.`customers` (`id`, `name`, `email`, `birth_date`,  `street_address`, `city`, `state`, `zipcode`) VALUES (NULL, '$name', '$email', '$birthdate', '$street_address', '$city', '$state', '$zipcode');";
    // use exec() because no results are returned
 

    $conn->exec($sql);
    //echo "<script type='text/javascript'>alert('Thank You');</script>";
    //header('Location: http://localhost/monthly_moonshine/Big_Picture/webpage/index.php');
    //echo "New record created successfully\n";
    }
catch(PDOException $e)
    {
    //echo $e->getMessage();
    }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = mysql_real_escape_string($data);
  return $data;
}



//require_once('vendor/autoload.php');

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
//$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
//$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "joeydee93@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "vI4OPbe9Doi3";
//Set who the message is to be sent from
//$mail->setFrom("monthly_moonshine@monthly_moonshine.com", "Monthly Moonshine");
//Set an alternative reply-to address

//Set who the message is to be sent to
$mail->addAddress($email, $name);
//Set the subject line
$mail->Subject = 'Thank You';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//send the message, check for errors
if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    //echo "Message sent!";
}

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://localhost/monthly_moonshine/Big_Picture/webpage/thank_you.html">';    
exit;    
?>