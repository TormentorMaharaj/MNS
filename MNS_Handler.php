<?php
$file = "mns_log.txt";
date_default_timezone_set("Pacific/Auckland");
$time = date("Y-m-d H:i:s") . " \n";
file_put_contents($file, $time, FILE_APPEND);
file_put_contents($file, "The contents of the MNS POST are below: \n", FILE_APPEND);
foreach ($_POST as $key => $val) {
$log_line = $key . " = " . $val . "\n";
file_put_contents($file, $log_line, FILE_APPEND);
}
$ch = curl_init();
$enc_url = str_replace('+', '%20', http_build_query($_POST)); // spaces to be encoded as %20
$enc_url = $enc_url . "&cmd=_xverify-transaction";
curl_setopt($ch, CURLOPT_URL, "https://secure.flo2cash.co.nz/web2pay/MNSHandler.aspx");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $enc_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close($ch);
Fetch terms and conditions apply. Fetch is only available for business banking purposes. The Kiwibank
“Fetch” name, logos and related trademarks and service marks are owned by Kiwibank Limited.
© Kiwibank Limited, 2013.
file_put_contents($file, "The encoded URL posted to the MNS Handler: " . $enc_url . "\n", FILE_APPEND);
if ($server_output == "VERIFIED") {
file_put_contents($file, "\n MNS response VERIFIED \n", FILE_APPEND);
} else {
file_put_contents($file, "\n MNS response REJECTED \n", FILE_APPEND);
}
file_put_contents($file, "- - - - - - - - - Transaction complete - - - - - - - - - \n", FILE_APPEND);
?>