<?php
namespace components\httpFoundation;
use components\httpFoundation\Session;

class Headers{

    public function __construct()
    {
		if(strtoupper(Session::get('route_request')) == 'API')
		{
			$this->declareHeader(Session::get('current_request'));
		}
    }

    private function declareHeader($current_request)
	{
		if(strtoupper($current_request) == 'GET')
		{
			header("Access-Control-Allow-Origin: *");
			header("Content-Type: application/json; charset=UTF-8");
		}else
		{
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Credentials: true");
			header("Content-Type: application/json; charset=UTF-8");
			header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
			header("Access-Control-Max-Age: 3600");
			header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		}
	}

}