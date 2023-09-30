<?php
$CN = mysqli_connect("localhost","root","");
$db =mysqli_select_db($CN,"mentheal");

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData,true);

$Username = $DecodedData['Username'];
$Email = $DecodedData['Email'];
$Phone = $DecodedData['Phone'];
$UEmail = $DecodedData['Useremail'];

$IQ = "INSERT INTO bookings(Username,Email,UserEmail,Phone)VALUES('$Username','$Email','$UEmail',$Phone)";
$R = mysqli_query($CN,$IQ);

if($R){
  $Message = "Booking successfull";
}
else{
  $Message = "please try later";
}

$Response[] =array("Message"=>$Message);

 echo json_encode($Response);
?>