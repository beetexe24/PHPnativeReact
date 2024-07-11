<?php
namespace app\http\services;

use components\httpFoundation\Session;
use app\http\job\generateToken;
use app\http\job\fetchHubspotdata;
use \DateTime;

class hubspotService{

    public function fetchContacts($request)
    {
        $startdate = $request->var->startDate;
        $enddate = $request->var->endDate;
        $pageNumber = $request->var->pageNumber;
        $filterBy = (strtolower($request->var->filterBy) == 'customer date') ? 'createdate' : 'hs_lifecyclestage_marketingqualifiedlead_date';

        $startdate = DateTime::createFromFormat('Y-m-d', $startdate);
        $startdate = $startdate->format(DateTime::ATOM); // DateTime::ATOM is the same as ISO 8601

        $enddate = DateTime::createFromFormat('Y-m-d', $enddate);
        $enddate = $enddate->format(DateTime::ATOM); // DateTime::ATOM is the same as ISO 8601

        $final_data = array();
        $total_items = 0;
        $total_pages = 0;
        $page_limit = 10;
        $after = ($pageNumber == 1) ? '0' : (($pageNumber - 1) * $page_limit);
        $data = fetchHubspotdata::fetch(Session::get("access_token"), $startdate, $enddate, $pageNumber, $page_limit, $filterBy, $after);
		
        if(isset($data['status']) && strtolower($data['status']) == 'error')
        {
            $access_token = generateToken::generate();
            Session::set("access_token", $access_token);

            $data = fetchHubspotdata::fetch($access_token, $startdate, $enddate, $pageNumber, $page_limit, $filterBy, $after);
        }

        if(isset($data['results']) && count($data['results']))
        {
            $final_data = array_merge($final_data, $data['results']);
            $total_items = count($data['results']);
            $quotient = $data['total'] / $page_limit;
            $total_pages = is_float($quotient) ? intval(($data['total'] / $page_limit) + 1) : $quotient;
        }
        
        return array(
            "success"       => "true",
            "data"          => $data,
            "total_items"   => $total_items,
            "total_pages"   => $total_pages,
            "after"         => $after,
            "token"         => Session::get("access_token")
        );
    }
}