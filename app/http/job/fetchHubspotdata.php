<?php
namespace app\http\job;

class fetchHubspotdata{
    
    public static function fetch($access_token, $startdate, $enddate, $pageNumber, $page_limit, $filterBy, $after)
    {
        
        $url = 'https://api.hubapi.com/crm/v3/objects/contacts/search';

        $data = [
            "limit"     => $page_limit,
            "after"     => $after,
            "properties" => ["email", "hs_lifecyclestage_marketingqualifiedlead_date", "createdate", "firstname", "lastname"],
            "filterGroups" => [
                [
                    "filters" => [
                        [
                            "propertyName" => $filterBy,
                            "operator" => "BETWEEN",
                            "highValue" => $enddate,
                            "value" => $startdate
                        ]
                    ]
                ]
            ]
        ];

        $data_json = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token
        ]);

        $response = curl_exec($ch);
        $responseData = json_decode($response, true);
        curl_close($ch);


        return $responseData;

    }
}