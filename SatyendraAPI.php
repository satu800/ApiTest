<?php

$url="http://sms.paragalaxy.com/smpp_api/sms";
	$to=9717399645;
	$token="7caab167db42fb832cf6ca9f68eebae6";
	$text="Hello This is API Test";
	
	$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://sms.paragalaxy.com/smpp_api/sms".
    "?token=".$token.
    "&To=".$to.
    "&Text=".urlencode($text),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HEADER => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_SSL_VERIFYHOST => false
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	//echo $response;
	
	$getData=json_decode($response,true);
	
	//print_r($getData);
	if(!empty($getData)){
	$ref_id=$getData['refId'];
	$status=$getData['status'];
	$MessageCount=$getData['MessageCount'];
	
	
	$servername = "localhost";
	$database = "smsdb";
	$username = "root";
	$password = "";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
	}
	 
	echo "Connected successfully";
	 
	$sql="INSERT INTO smstbl (mobile_no,message,refId, sent_status, msg_count) VALUES ('".$to."', '".$text."','".$ref_id."', '".$status."', $MessageCount)";
	if (mysqli_query($conn, $sql)) {
		  echo "New record created successfully";
	} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	mysqli_close($conn);



	
	}
}
?>
