<?php
$plugUser   = 'xxxxxx@xxxxxx.com';
$plugPass   = 'xxxxxxxxxxxxxxx';
$plugDevice = 'xxxx-xxxx-xxxxx-xxxxx';

$plugIsOn = 0;

if ($_GET['plug'] == 'on') {
    $plugIsOn = 1;
}

$xmlData = '<?xml version="1.0" encoding="UTF-8"?><v:Envelope xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns:d="http://www.w3.org/2001/XMLSchema" xmlns:c="http://schemas.xmlsoap.org/soap/encoding/" xmlns:v="http://schemas.xmlsoap.org/soap/envelope/"><v:Header /><v:Body><service xmlns="http://www.thinkhome.com.cn/" id="o0" c:root="1"><json i:type="d:string">{"head":{"code":"120"},"body":{"authentication":{"FUserAccount":"' . $plugUser . '","FPassword":"' . $plugPass . '"},"action":{"FActionType":"5","FActionNo":"' . $plugDevice . '","FKeyNum":"0","FAction":"' . $plugIsOn . '","FValue":""}}}</json></service></v:Body></v:Envelope>';

$Url = "http://m.g-homa.com/wsi/action/ActionWebService.asmx";

$ch = curl_init($Url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xmlData");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

print_r($output);
