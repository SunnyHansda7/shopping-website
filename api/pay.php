<?php


echo $product_name=$_POST['product_name'];;
echo $amount=$_POST['product_price'];;
echo $name=$_POST['name'];
echo $phone=$_POST['phone'];
echo $email=$_POST['email'];


		
			
	 

include("Instamojo/Instamojo.php");


//$api = new Instamojo\Instamojo("37c6a2f05a9fdf909c0597bc765f404e", "b337706c11a8a1351146d342466a7242", 'https://www.instamojo.com/api/1.1/');
// only key change karna yha url ye hi rahega 

//$api = new Instamojo\Instamojo('private api key', 'private aut token','https://www.instamojo.com/api/1.1/');
$api = new Instamojo\Instamojo('6eadb9f056aa4b2fb83217c1e50cb06f', '587e0ea84f93ed9ddc08395b542a333b','https://test.instamojo.com/api/1.1/');

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
		// yha par domai url dal ke check kar lo ok dear ok bro bye  
        "redirect_url" => $redirect_url,
		
        ));
    //print_r($response);
	$pay_url=$response['longurl'];
	//header("location:$pay_url");
	echo "<script>window.location.href='$pay_url'</script>";
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}
?>