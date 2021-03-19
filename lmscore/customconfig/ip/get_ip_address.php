<?php

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

echo "x-for".$_SERVER['HTTP_X_FORWARDED_FOR']."<br>";

$ip =  get_client_ip();
//$ip = "2405:204:16:f885:6586:449d:f1bf:3317";
echo "ip address ".$ip;

$details = json_decode(file_get_contents("https://ipinfo.io/{$ip}"));
echo "<pre>"; print_r($details);

if($details)
{
    echo $details->country;
}


///*
echo "<br> 1 HTTP_CLIENT_IP - ".$_SERVER['HTTP_CLIENT_IP'];
echo "<br> 2 HTTP_X_FORWARDED_FOR - ".$_SERVER['HTTP_X_FORWARDED_FOR'];
echo "<br> 3 HTTP_X_FORWARDED - ".$_SERVER['HTTP_X_FORWARDED'];
echo "<br> 4 HTTP_FORWARDED_FOR - ".$_SERVER['HTTP_FORWARDED_FOR'];
echo "<br> 5 HTTP_FORWARDED - ".$_SERVER['HTTP_FORWARDED'];
echo "<br> 6 REMOTE_ADDR - ".$_SERVER['REMOTE_ADDR'];
echo "<br> 7 X-Forwarded-For - ".$_SERVER['X-Forwarded-For'];

$headers = apache_request_headers(); echo"headers -"; print_r($headers);
$real_client_ip = $headers["X-Forwarded-For"];
echo "client ip".$real_client_ip;

//*/

/*
// To check whether remote address is in IPv6 or IPv4.

if(strstr($_SERVER['REMOTE_ADDR'],":"))
    $IP = "IPv6";
else
    $IP = "IPv4";

echo '<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>IPv4 / IPv6 address</title>
  </head>
<body>';

if ("$IP" == "IPv6") {
        echo 'default:<strong>IPv6</strong><br />
IPv6:<strong>',$_SERVER['REMOTE_ADDR'],'</strong>';
}
else {
        echo 'default:<strong>IPv4</strong><br />
IPv4:<strong>',$_SERVER['REMOTE_ADDR'],'</strong><br />';
}

echo '</body>
</html>';

*/

?>




