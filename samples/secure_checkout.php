<?

//PHP Code Sample for using Secure Checkout

if ($_GET["parmList"] != "") {
  $parmList = $_GET["parmList"];
}
else {
  $parmList = $_POST["parmList"];
}

//parse through the response.
$responseArr = explode('|', $parmList);
foreach ($responseArr as $pair ){
  $tmp = explode('~',$pair);
  $vars[$tmp[0]] = $tmp[1];
}

$approved = False;

//search through the name/value pairs for the APCODE
foreach($vars as $key => $value){
  if ( $key == "ORDERID" ) {
    if ( $value != "" ) {
      $OrderID = $value;
    }
  }
  elseif ( $key == "AMOUNT" ) {
    $Amount = $value;
  }
  elseif ( $key == "DESCRIPTION" ) {
    $Description = $value;
  }
  elseif ( $key == "APPCODE") {
    $ApprovalCode = $value;
  }

  //You can add as many 'elseif' sections are necessary to check for and collect additional data values.

} // end for loop


if ( $Description != "" ) {
  echo "Your transaction description was, " . $Description . "<br>";
}

echo "Your transaction order id was, " . $OrderID . "<br>";
echo "Your transaction amount was, " . $Amount . "<br>";

?>
