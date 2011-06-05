<?php
/*
 * AEsoap client example
 *
 * a simple example how to invoke commands using SOAP
 */

$username = 'HYPERIONGM';
$password = 'PDPFER56DF5';
$host = "valkyrie-wow.com";
$soapport = 7878;
$command = "server info";

$client = new SoapClient(NULL,
array(
    "location" => "http://$host:$soapport/",
    "uri" => "urn:Mangos",
    "style" => SOAP_RPC,
    'login' => $username,
    'password' => $password,
    'trace' => true,
));

try {
    $result = $client->executeCommand(new SoapParam($command, "command"));

    echo "Command succeeded! Output:<br />\n";
    echo $result;
}
catch (Exception $e)
{
    echo "Command failed! Reason:<br />\n";
    echo $e->getMessage();
}
echo $client->__getLastRequest();
echo "<br />";
echo $client->__getLastRequestHeaders();
