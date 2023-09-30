<?php
$CN = mysqli_connect("localhost","root","");
$db =mysqli_select_db($CN,"react");

$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData,true);

$RollNo = $DecodedData['RollNo'];
$StudentName = $DecodedData['StudentName'];
$Course = $DecodedData['Course'];

$IQ = "INSERT INTO studentmaster(RollNo,StudentName,Course)VALUES($RollNo,'$StudentName','$Course')";
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