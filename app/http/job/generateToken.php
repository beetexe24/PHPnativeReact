<?php
namespace app\http\job;

class generateToken{

    public static function generate()
    {
        $token = 'CObI--WJMhIHAAEAQAAAARjwlKQWIIbl5CAo5qDZATIUfuYxVQXtEI-MzdmjAO-4-X5Q2Kw6MAAAAEEAAAAAAAAAAAAAAAAAgAAAAAAAAAAAACAAAAAAAOABAAAAAAAAAAAAAAAQAkIUpqe6r9UeANkL_QhcVyQcPAtsKJdKA25hMVIAWgBgAA';
		$refresh_token = '2a9eef36-59af-477e-bfc3-5946fb55c912';
		$client_id = '6969abc5-2293-4b4d-aa34-1029767d17c1';
		$client_secret = '68060de8-c485-42fc-bdba-2e292710542b';

        $fields = [
            "grant_type" => "refresh_token",
            "client_id"  => $client_id,
            "client_secret" => $client_secret,
            "refresh_token" => $refresh_token
        ];
          

        $url = 'https://api.hubapi.com/oauth/v1/token';

        $fields_string = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        return $responseData['access_token'];
    }
}