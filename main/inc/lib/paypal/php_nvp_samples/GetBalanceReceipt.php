<?php
include 'ppsdk_include_path.inc';

require_once 'PayPal.php';
require_once 'PayPal/Profile/Handler/Array.php';
require_once 'PayPal/Profile/API.php';
require_once 'PayPal/Type/DoCaptureRequestType.php';
require_once 'SampleLogger.php';
require_once 'lib/constants.inc.php';

session_start();

$was_submitted = false;

$logger = new SampleLogger('GetBalanceRecipt.php', PEAR_LOG_DEBUG);
$logger->_log('POST variables: '. print_r($_POST, true));

$profile = $_SESSION['APIProfile'];

// Verify that user is logged in
if(! isset($profile)) {
   // Not logged in -- Back to the login page

   $logger->_log('You are not logged in;  return to index.php');
   $location = 'index.php';
   header("Location: $location");
} else {
   $logger->_log('Profile from session: '.print_r($profile, true));
}

// Build our request from $_POST
$getbalance_request =& PayPal::getType('GetBalanceRequestType');
if (PayPal::isError($capture_request)) {
   $logger->_log('Error in request: '. print_r($capture_request, true));
} else {
   $logger->_log('Create request: '. print_r($capture_request, true));
}


$logger->_log('Initial request: '. print_r($capture_request, true));

$caller =& PayPal::getCallerServices($profile);

$response = $caller->GetBalance($getbalance_request);

$ack = $response->getAck();

$logger->_log('Ack='.$ack);

switch($ack) {
   case ACK_SUCCESS:
   case ACK_SUCCESS_WITH_WARNING:
      // Good to break out;
      break;

   default:
      $_SESSION['response'] = $response;
      $logger->_log('GetBalance failed: ' . print_r($response, true));
      $location = "ApiError.php";
      header("Location: $location");
}

// Otherwise, load the HTML response
require_once 'pages/GetBalanceReceipt.html.php';

?>