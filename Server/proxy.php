<?php
// Get the url of to be proxied
// Is it a POST or a GET?
$url = $_POST['url'];
$headers = $_POST['headers'];
$mimeType = $_POST['mimeType'];
//Start the Curl session
$session = curl_init($url);

$query_string = "";
if ($_POST) {
  $kv = array();
  foreach ($_POST as $key => $value) {
    if (is_array($value)) {
    	for ($i = 0; $i < count($value); $i++) {
		  $kv[] = "$key" ."[$i]=" . $value[$i];
    	
    	}
    } else {
	    $kv[] = "$key=$value";
	}
  }
  $query_string = join("&", $kv);
}

curl_setopt ($session, CURLOPT_POST, true);
curl_setopt ($session, CURLOPT_POSTFIELDS, $query_string);

// Don't return HTTP headers. Do return the contents of the call
curl_setopt($session, CURLOPT_HEADER, ($headers == "true") ? true : false);
curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Make the call
$response = curl_exec($session);
if ($mimeType != "")
{
	// The web service returns XML. Set the Content-Type appropriately
	header("Content-Type: ".$mimeType);
}
echo $query_string;
echo '\n\n';
echo $response;
curl_close($session);
?>