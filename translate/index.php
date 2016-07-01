<?php
include dirname(__FILE__) . '/settings.php';

function getAccessToken($settings){
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            "grant_type" => "client_credentials",
            "scope" => "http://api.microsofttranslator.com",
            "client_id" => $settings->{"client_id"},
            "client_secret" => $settings->{"client_secret"}
            ))
        ));
    return json_decode(curl_exec($ch));
}

function translator($access_token, $params, $oncomplete){
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://api.microsofttranslator.com/v2/Http.svc/Translate?".http_build_query($params),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". $access_token),
        ));
    preg_match('/>(.+?)<\/string>/',curl_exec($ch), $m);
    return $oncomplete.'("' . $m[1] . '");';
}

$access_token = getAccessToken($settings)->access_token;
#echo $_GET["text"];
$params = ['text' => $_GET["text"], 'from' => $_GET["from"], 'to' => $_GET["to"]];

header('Content-type: text/plane; charset=utf-8');
echo translator($access_token, $params, $_GET["oncomplete"]);
