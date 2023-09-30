<?php
$CN = mysqli_connect("localhost","root","");
$db =mysqli_select_db($CN,"mentheal");

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData,true);

$Username = $DecodedData['Username'];
$Email = $DecodedData['Email'];
$Phone = $DecodedData['Phone'];
$Password = $DecodedData['Password'];

$IQ = "INSERT INTO users(Username,Email,Phone,Password)VALUES('$Username','$Email',$Phone,'$Password')";
$R = mysqli_query($CN,$IQ);

if($R){
	$Message = "Student saved succesfully";
}
else{
	$Message = "please try later";
}

$Response[] =array("Message"=>$Message);

 echo json_encode($Response);
?>