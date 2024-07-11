<?php
namespace components\httpFoundation;
use components\httpFoundation\Session;

class Route{

	public static $routesList = array();

	public static function get($url, $controllers, $methods){
		if(strtoupper($_SERVER['REQUEST_METHOD']) == 'GET')
		{
			$data = array(
				'url'			=> $url,
				'controllers'	=> $controllers,
				'methods'		=> $methods,
				'request'		=> 'get'
			);
			self::$routesList[] = $data;
		}
	}

	public static function post($url, $controllers, $methods){
		if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
		{

			$data = array(
				'url'			=> $url,
				'controllers'	=> $controllers,
				'methods'		=> $methods,
				'request'		=> 'post'
			);
			self::$routesList[] = $data;
		}
	}

	public static function put($url, $controllers, $methods){
		$response = null;
		if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['_method']))
		{
				if(strtoupper($_POST['_method']) == 'PUT')
				{
					$whole_url = $_SERVER["HTTP_HOST"] .$_SERVER["REQUEST_URI"];
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $whole_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
					curl_setopt($ch, CURLOPT_POSTFIELDS, "var='hello'");
					$response = curl_exec($ch);
					curl_close($ch);

					Session::set('curl_request', 'put');
				}
		}


		
		if(strtoupper($_SERVER['REQUEST_METHOD']) == 'PUT' || strtoupper(Session::get('curl_request')) == 'PUT')
		{
			$data = array(
				'url'			=> $url,
				'controllers'	=> $controllers,
				'methods'		=> $methods,
				'request'		=> 'put'
			);
			self::$routesList[] = $data;
		}


	}


}