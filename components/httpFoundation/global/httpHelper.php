<?php
use components\httpFoundation\Route;
use components\httpFoundation\Session;

function numCheck($string){
	return (preg_match('~[0-9]+~', $string)) ? true : false;
}

function checkIFhasSpecial_char($string){
	return (preg_match('/[\'^£$%&*()@#~?><>,|=+¬-]/', $string)) ? true : false;
}

function checkFirstString_if_num($string){
	return (is_numeric(substr($string, 0, 1))) ? true : false;
}

function ifhasOpenbracket($string){
	return (substr_count($string, "{") == 1) ? true : false;
}

function ifhasClosebracket($string){
	return (substr_count($string, "}") == 1) ? true : false;
}

function checkFirstString_if_openBracket($string){
	return (substr($string, 0, 1) === '{') ? true : false;
}

function checkLastString_if_closeBracket($string){
	return (substr($string, strlen($string) - 1, 1) === '}') ? true : false;
}

function checkSecondAfterBracket_if_valid($string){
	return (ctype_alpha(substr($string, 1, 1))) ? true : false;
}

function checkFirstString_if_slash($string){
	return (substr($string, 0, 1) === '/') ? true : false;
}

function checkIFhasQuestionMark_char($string){
	return (preg_match("/['?']/", $string)) ? true : false;
}


function callController($route_controller){
	// EXECUTE THE METHOD DECLARED IN ROUTE
	$controller_exp = explode('/', $route_controller);
	$actual_controller = $controller_exp[count($controller_exp) - 1];
	$current_controller = 'app/http/controllers/'.$route_controller.'.php';

	require_once $current_controller;
	$controller = new $actual_controller;

	return $controller;
}

function detectCurrentRoute_and_url($current_url, $api = null)
{
	$success = false;
	$controller = null;
	$method = null;


	foreach(Route::$routesList as $route)
		{
			$current_route = (object)$route;

			$route_url = $current_route->url;
			$route_controller = $current_route->controllers;




			// IF URL IS FROM API
			//if($api) $route_url = '/api'.$route_url;


			

			if($current_url == $route_url)
				$success = true;
			else
			{
				$route_url_exp = explode('/', $route_url);
				$current_url_exp = explode('/', $current_url);



				if(count($route_url_exp) == count($current_url_exp))
				{
					for($i = 0; $i < count($current_url_exp); $i++)
					{
						
						if($route_url_exp[$i] == $current_url_exp[$i])
							$success = true;
						else
							//  CHECK IF VARIABLE IN ROUTE URL
							if(ifhasOpenbracket($route_url_exp[$i]))
								$success = true;
							else
							{
								// CHECK IF LAST STRING IS PARAMETER SIGN (?)
								//$position_of_sign = strpos($current_url_exp,"?");

								if($i == (count($current_url_exp) - 1))
								{
									if(checkIFhasQuestionMark_char($current_url_exp[$i]) && strtoupper($current_route->request) == 'GET')
									{
										$position_of_sign = strpos($current_url_exp[$i], "?");
										$removed_questionmark = substr($current_url_exp[$i], 0, $position_of_sign);

										if($route_url_exp[$i] == $current_url_exp[$i])
											$success = true;
									}
									else
									{
										$success = false;
										break;
									}
									
								}

								
								
							}
					}
				}

			}


			if($success)
			{

				$controller = callController($route_controller);
				//call_user_func(array($controller, $current_route->methods));

				$controller = $controller;
				$method = $current_route->methods;
				$request = $current_route->request;

				// STORE THE RIGHT ROUTE FOR THE CURRENT URL
				Session::set("route_url", $route_url);
				Session::set("current_url", $current_url);
				Session::set("current_request", $request);
				Session::set("route_request", $api);
				break;
			}

		}

	

		$array = (object)array(
			'error'			=> ($success == false) ? 'Route not found' : '',
			'controller'	=> $controller,
			'method'		=> $method,
			'success'		=> $success
		);

		
		return $array;

}