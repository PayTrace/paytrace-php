<?
//PHP Code Sampe for using Secure Checkout

$OrderID = "4420";

//format the parameter string to process a transaction through PayTrace
$parmlist = "parmlist=UN~demo123|PSWD~demo123|TERMS~Y|";
$parmlist .= "ORDERID~" . $OrderID . "|TRANXTYPE~Sale|";
$parmlist .= "AMOUNT~1.00|";

$header = array("MIME-Version: 1.0","Content-type: application/x-www-form-urlencoded","Contenttransfer-encoding: text");

//point the cUrl to PayTrace's servers
$url = "https://paytrace.com/api/validate.pay";

$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);

//Depending on your PHP Host, you may need to specify their proxy server
//curl_setopt ($ch, CURLOPT_PROXY, "http://64.202.165.130:3128");
//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//The proxy information above is for GoDaddy.com

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parmlist);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($ch, CURLOPT_TIMEOUT, 90);

// grab URL and pass it to the browser
$response = curl_exec($ch);

// close curl resource, and free up system resources
curl_close($ch);

//--------------------//--------------------//--------------------
echo("This response, '" . $response . "', was returned.<br><br>");
//--------------------//--------------------//--------------------

//--------------------//--------------------//--------------------
//6.3.2 Parsing a Response to Validate an Order (Image 6.3.2)

//parse through the response.
$responseArr = explode('|', $response);
foreach ($responseArr as $pair ){
  $tmp = explode('~',$pair);
  $vars[$tmp[0]] = $tmp[1];
}

//search through the name/value pairs for the AuthKey
foreach($vars as $key => $value){
  if ( $key == "AUTHKEY" ) {
    if ( $value != "" ) {
      $Authkey = $value;
    }
  }
  elseif ( $key == "ERROR" ) {

    $ErrorMessage .= $value;

  }
}

if ( $ErrorMessage != "" ) {
  echo "The following error occurred when attempting to prepare your order, " . $ErrorMessage . "<br>";
}
else {
  echo "<a href=https://PayTrace.com/api/checkout.pay?parmlist=ORDERID~" . $OrderID . "|AuthKey~" . $Authkey . "|INVOICE~" . $OrderID . "|>Click here to complete your order</a>";
  //you may also use a form button or a redirection
}

?>

