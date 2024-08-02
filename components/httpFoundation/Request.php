<?php
namespace components\httpFoundation;
use components\httpFoundation\Session;

class Request{

	public $var;

	public function __construct(array $var = [])
	{
		$this->initialize($var);
	}

	public function initialize(array $var = [])
	{
		$this->var = $this->storeVariable_from_route_url(
			Session::get('route_url'),
			Session::get('current_url'),
			Session::get('current_request'),
			Session::get('route_request')
		);

		Session::unset('route_url');
		Session::unset('current_url');
		Session::unset('current_request');
		Session::unset('route_request');

	}


	public function storeVariable_from_route_url($route_url, $current_url, $httpRequest, $routeRequest)
	{
		$route_url_exp = explode('/', $route_url);
		$current_url_exp = explode('/', $current_url);
		$converted_array = array();
		$var = null;


		// ADD VARIABLES FROM HTTP REQUEST


		
		if(strtoupper($httpRequest) == 'GET')
			$converted_array = array_merge($converted_array, $this->storeGetRequest());
		elseif(strtoupper($httpRequest) == 'POST')
			$converted_array = array_merge($converted_array, $this->storePostRequest($routeRequest));
		elseif(strtoupper($httpRequest) == 'PUT')
			$converted_array = array_merge($converted_array, $this->storePutRequest($routeRequest));




		// ADD VARIABLES FROM URL
		for($i = 0; $i < count($route_url_exp); $i++)
		{
			if(checkFirstString_if_openBracket($route_url_exp[$i]))
			{
				$var = str_replace('{', '', $route_url_exp[$i]);
				$var = str_replace('}', '', $var);


				//EXPLODE THE URL SO YOU CANNOT GET THE ?
				$var_exp = explode('?', $current_url_exp[$i]);
				
				//$_{$httpRequest}[$var] = $current_url_exp[$i];
				$converted_array = array_merge($converted_array, [
					"$var" => $var_exp[0]
				]);


			}
		}


		return (object)$converted_array;	
	}

	private function storeGetRequest()
	{
		$array = array();
		foreach($_GET as $key => $value)
			$array = array_merge($array, [$key => $value]);

		return $array;
	}

	private function storePostRequest($routeRequest)
	{
		$array = array();

		foreach($_POST as $key => $value)
		{
			if(strtolower($key) !== '_method')
				$array = array_merge($array, [$key => $value]);
		}

		if(strtolower($routeRequest) == 'api')
		{
			$data = json_decode(file_get_contents('php://input'));
			
			if($data)
			{
				foreach($data as $key => $value)
					$array = array_merge($array, [$key => $value]);
			}
			
		}
		return $array;
	}

	private function storePutRequest($routeRequest)
	{
		$array = array();

		foreach($_POST as $key => $value)
		{
			if(strtolower($key) !== '_method')
				$array = array_merge($array, [$key => $value]);
		}

		if(strtolower($routeRequest) == 'api')
		{
			$data = json_decode(file_get_contents("php://input"));

			if($data)
			{
				foreach($data as $key => $value)
				{
					$array = array_merge($array, [$key => $value]);
				}
			}
			
		}
		return $array;
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