<?php
use components\httpFoundation\Controller;
use components\httpFoundation\Session;

class indexController extends Controller{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	*
	*
	* TO GET POST AND GET REQUESTS PARAMETERS
	* DECLARE use Components\HttpFoundation\Request;
	*
	*
	* INSTANTIATE THE CLASS
	* $request = new Request;
	*
	*
	* THEN ACCESS THE REQUEST VARIABLE
	* $request->var->your_variable_key
	*
	**/


	/**
	*
	* DISPLAY VIEW BY
	* return view('index', compact('firstname', 'middlename', 'lastname'));
	* 
	**/

	public function index()
	{
		$us_endpoint = "https://sellercentral.amazon.com/rcpublic/getadditionalpronductinfo?countryCode=US&asin=$asin&fnsku=&searchType=GENERAL&locale=en-US";
        $uk_endpoint = "https://sellercentral.amazon.co.uk/rcpublic/getadditionalpronductinfo?countryCode=GB&asin=$asin&fnsku=&searchType=GENERAL&locale=en-GB";

        $get_buybox_endpoint = ($marketplace == 'US') ? $us_endpoint : $uk_endpoint;
        $curl = curl_init($get_buybox_endpoint);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, TRUE);


		$token = 'CObI--WJMhIHAAEAQAAAARjwlKQWIIbl5CAo5qDZATIUfuYxVQXtEI-MzdmjAO-4-X5Q2Kw6MAAAAEEAAAAAAAAAAAAAAAAAgAAAAAAAAAAAACAAAAAAAOABAAAAAAAAAAAAAAAQAkIUpqe6r9UeANkL_QhcVyQcPAtsKJdKA25hMVIAWgBgAA';
		$refresh_token = '2a9eef36-59af-477e-bfc3-5946fb55c912';
		$client_id = '6969abc5-2293-4b4d-aa34-1029767d17c1';
		$client_secret = '68060de8-c485-42fc-bdba-2e29271054';
	}


}