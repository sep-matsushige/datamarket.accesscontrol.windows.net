<?php
function getAccessToken(){
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            "grant_type" => "client_credentials",
            "scope" => "http://api.microsofttranslator.com",
            "client_id" => "xxx",
            "client_secret" => "xxx"
            ))
        ));
    return curl_exec($ch);
}

header('Content-type: application/json');
echo getAccessToken();
