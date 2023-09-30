<?php
header('Content-Type: application/json');

// Check if all required parameters are provided
if (
    isset($_POST['phone']) &&
    isset($_POST['name']) &&
    isset($_POST['amount'])
) {
    date_default_timezone_set('Africa/Nairobi');

    // Access token
    $consumerKey = 'nk16Y74eSbTaGQgc9WF8j6FigApqOMWr'; // Fill with your app Consumer Key
    $consumerSecret = '40fD1vRXCq90XFaU'; // Fill with your app Secret

    // Define the variables
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $PartyA = $_POST['phone']; // This is your phone number
    $AccountReference = $_POST['name']; // Sender's name
    $TransactionDesc = 'Test Payment';
    $Amount = $_POST['amount'];

    // Get the timestamp, format YYYYmmddhms -> 20181004151020
    $Timestamp = date('YmdHis');

    // Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    // M-PESA endpoint URLs
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    // Callback URL
    $CallBackURL = 'https://morning-basin-87523.herokuapp.com/callback_url.php';

    // Get access token
    $headers = ['Content-Type: application/json; charset=utf8'];

    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    $access_token = $result->access_token;
    curl_close($curl);

    // Initiate the transaction
    $stkheader = ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);

    $curl_post_data = [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    ];

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_code === 200) {
        // Transaction initiated successfully
        $response = [
            'success' => true,
            'message' => 'STK push initiated successfully.'
        ];
    } else {
        // Failed to initiate transaction
        $response = [
            'success' => false,
            'message' => 'Failed to initiate STK push.'
        ];
    }

    curl_close($curl);

    // Return the response as JSON
    echo json_encode($response);
} else {
    // Missing required parameters
    $response = [
        'success' => false,
        'message' => 'Missing required parameters.'
    ];

    // Return the response as JSON
    echo json_encode($response);
}
?>
