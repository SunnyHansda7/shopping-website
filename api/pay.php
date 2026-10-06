<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$product_name=$_POST['product_name'];
$amount=$_POST['product_price'];
$name=isset($_POST['first_name']) ? $_POST['first_name'] . ' ' . $_POST['last_name'] : (isset($_POST['name']) ? $_POST['name'] : 'Customer');
$phone=$_POST['phone'];
$email=$_POST['email'];
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'online';

if ($payment_method == 'cod') {
    // Send email receipt for COD
    $subject = "Order Confirmation - " . $product_name;
    $message = "Hello $name,\n\nThank you for placing your order with us!\n\nOrder Details:\nProduct: $product_name\nTotal Amount: Rs. $amount\nPayment Method: Cash on Delivery\n\nYour order is confirmed and will be shipped to your address shortly.\n\nThank you for shopping with us!";
    $headers = "From: noreply@shoppingwebsite.com\r\n";
    @mail($email, $subject, $message, $headers);

    // Redirect to thank you page
    header("Location: thankyou.php");
    exit();
}
include("Instamojo/Instamojo.php");

$api_key = getenv("INSTAMOJO_API_KEY") ?: "dee7d6f10ac09cff054fc59287f41a87";
$auth_token = getenv("INSTAMOJO_AUTH_TOKEN") ?: "d067b0a81f7aa9dfff0e13e843b138b0";
$api = new Instamojo\Instamojo($api_key, $auth_token, 'https://www.instamojo.com/api/1.1/');
try {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $redirect_url = $protocol . '://' . $host . '/thankyou.php';

    $response = $api->paymentRequestCreate(array(
        "purpose" => $product_name,
        "amount" => $amount,
        "send_email" => true,
        "email" => $email,
		"buyer_name"=>$name,
		"phone"=>$phone,
		"send_sms"=>true,
		
		"allow_repeated_payments"=>false,
        "redirect_url" => $redirect_url,
		
        ));
    
	$pay_url=$response['longurl'];
	echo "<script>window.location.href='$pay_url'</script>";
}
catch (Exception $e) {
    echo '<div style="color:red; font-family:sans-serif; text-align:center; margin-top:50px;">';
    echo '<h2>Payment Gateway Error</h2>';
    print('<p>' . $e->getMessage() . '</p>');
    echo '<button onclick="window.history.back()">Go Back</button>';
    echo '</div>';
}
?>
