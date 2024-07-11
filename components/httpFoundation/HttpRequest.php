<?php
namespace components\httpFoundation;
use components\httpFoundation\Route;
use components\httpFoundation\Interface_request;
use components\httpFoundation\Request;


class HttpRequest implements Interface_request{

	public function __construct(){
		$breakloop = false;
		$result = null;
		$current_route = null;
		$error_on = null;


		
		$current_url = (isset($_SERVER['REQUEST_URI'])) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';
		$current_url_exp = explode('/', $current_url);

		if(isset($current_url_exp[1]))
		{
			if(strtolower($current_url_exp[1]) === 'api')
				require __ROOT__.'/routes/api.php';
			else
				require __ROOT__.'/routes/web.php';
		}
		else
		{
			require __ROOT__.'/routes/web.php';
		}
		

	

		
		foreach(Route::$routesList as $route)
		{
			$current_route = (object)$route;


			$result = $this->validateURL($current_route->url);
			if($result->success == false)
			{
				$breakloop = true;
				$error_on = "Route::".$current_route->request."('"
							.$current_route->url."', '"
							.$current_route->controllers."', '"
							.$current_route->methods."'".
							")";
				break;
			}
			$result = $this->validateControllers($current_route->controllers);
			if($result->success == false)
			{
				$breakloop = true;
				$error_on = "Route::".$current_route->request."('"
							.$current_route->url."', '"
							.$current_route->controllers."', '"
							.$current_route->methods."'".
							")";
				break;
			}
		
			$result = $this->validateMethods($current_route->controllers, $current_route->methods);
			if($result->success == false)
			{
				$breakloop = true;
				$error_on = "Route::".$current_route->request."('"
							.$current_route->url."', '"
							.$current_route->controllers."', '"
							.$current_route->methods."'".
							")";
				break;
			}
		}


		if($breakloop)
		{
			echo "Invalid route: ". $result->error." <span style='color: red'> &nbsp;".$error_on."</span>";
		}
		else
		{
			// DISPLAY CURRENT ROUTE HERE

		
			
			$current_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '/';
			$current_url_exp = explode('/', $current_url);


			if(isset($current_url_exp[1]))
			{
				if(strtolower($current_url_exp[1]) === 'api')
					$this->loadApiCurrentURL($current_url);
				else
					$this->loadWebCurrentURL($current_url);
			}
			else
			{
				$this->loadWebCurrentURL($current_url);
			}
			
			
		}
	}

	public function validateURL($url)
	{
		$success = true;
		$error = null;

		if($url !== '/')
		{
			$url_exp = explode('/', $url);
	
			for($i = 0; $i < count($url_exp); $i++)
			{
				/*
				CHECK IF THE URL CONTAINS VARIABLES
						IF THE URL CONTAINS VARIABLE {id} THEN
								CHECK IF VARIABLE IS IN RIGHT FORMAT
								THE FIRST CHARACTER SHOULD BE {
								THE LAST CHARACTER SHOULD BE }
									THE MIDDLE CHARACTER SHOULD START WITH STRING
				CHECK IF THE URL IS JUST A WORD
				SPECIAL CHARACTERS WOULD BE DISALLOWED
				*/


				
				/*******************************************
				*	THIS CONDITION IS APPLIED TO ALL URLS
				********************************************/

				// INTEGER IS NOT ALLOWED IN FIRST CHARACTER
				if(checkFirstString_if_num($url_exp[$i]))
				{
					$success = false;
					$error = 'Integer should not be the first char when declaring route or variable';
					break;
				}
				// SPECIAL CHARACTERS IS NOT ALLOWED
				if(checkIFhasSpecial_char($url_exp[$i]))
				{
					$success = false;
					$error = 'Special character is not allowed';
					
					break;
				}

				/*******************************************
				*	                END
				********************************************/


				
				if(count($url_exp) == 1)
				{

					// VARIABLES IS NOT ALLOWED IF IT DOESNT HAVE '/' IN A SINGLE URL
					// VALID IS /{id}
					// NOT ALLOWED {id}
					if(ifhasOpenbracket($url_exp[$i]) == true || ifhasClosebracket($url_exp[$i]) == true)
					{
						$error = 'Missing / in url';
						$success = false;
						break;
					}

				}
				elseif(count($url_exp) > 1)
				{
					if(strlen($url_exp[$i]) > 0)
					{
						/* 
						IF STRING CONTAINS OPEN AND CLOSE BRACKET
						IF FIRST STRING IS { THEN
						THE LAST STRING SHOULD BE }
						*/
						if(checkFirstString_if_openBracket($url_exp[$i]))
						{
							if(ifhasClosebracket($url_exp[$i]) == false)
							{
								$error = 'Missing } in url';
								$success = false;
								break;
							}
							else
							{
								// THE LAST STRING SHOULD BE CLOSE BRACKET
								if(checkLastString_if_closeBracket($url_exp[$i]) == false)
								{
									$error = 'Invalid character at the end of url';
									$success = false;
									break;
								}
							}
						}



						if(checkLastString_if_closeBracket($url_exp[$i]))
						{

							if(ifhasOpenbracket($url_exp[$i]) == false)
							{
								$error = 'Missing { in url';
								$success = false;
								break;
							}
							else
							{
								// THE FIRST STRING SHOULD BE OPEN BRACKET
								if(checkFirstString_if_openBracket($url_exp[$i]) == false)
								{
									$error = 'Invalid character at the end of url';
									$success = false;
									break;
								}
							}
						}

						if(checkFirstString_if_openBracket($url_exp[$i]) == true && checkLastString_if_closeBracket($url_exp[$i]) == true)
						{
							// AFTER {, THE CHARACTER SHOULD BE STRING
							if(checkSecondAfterBracket_if_valid($url_exp[$i]) == false)
							{
								$error = 'Invalid declaration of variable in URL';
								$success = false;
								break;
							}
						}
					}
				}



				
			}

			
		}
		
		return (object)array(
			"error"		=> $error,
			"success"	=> $success
		);
		
	}

	public function validateControllers($controller)
	{
		$success = true;
		$error = null;
		$fileName = __ROOT__.'/app/http/controllers/'.$controller.'.php';



		$lowerfile = strtolower($fileName);
	

		if(count(glob(dirname($fileName))) == 1)
		{
			foreach (glob(dirname($fileName) . '/*')  as $file)
			{
				// CASE SENSITIVE CHECKER
			    if (strtolower($file) == $lowerfile)
			    {
			    	if(($file === $fileName) == 0)
			    	{
			    		$success = false;
			    		$error = 'controller does not exist';
			    	}

			    }
			}

		}
		else
		{
			$success = false;
			$error = 'controller does not exist';
		}
		


		return (object)array(
			"error" 	=> $error,
			"success"	=> $success
		);



	}

	public function validateMethods($controller, $method)
	{
		$success = true;
		$error = null;
		$controller_exp = explode('/', $controller);
		$actual_controller = $controller_exp[count($controller_exp) - 1];
		$current_controller = __ROOT__.'/app/http/controllers/'.$controller.'.php';

		require_once $current_controller;

		$current_controller = new $actual_controller;


		if(!method_exists($current_controller, $method))
		{
			$success = false;
			$error = 'method does not exist in the controller';
		}

		return (object)array(
			"error"		=> $error,
			"success"	=> $success
		);
	}

	public function loadWebCurrentURL($current_url)
	{
		$result = detectCurrentRoute_and_url($current_url);

		if($result->success)
			call_user_func(array($result->controller, $result->method));
		else
			echo $result->error;
	}


	public function loadApiCurrentURL($current_url)
	{
		$result = detectCurrentRoute_and_url($current_url, 'api');

		if($result->success)
			call_user_func(array($result->controller, $result->method));
		else
			echo $result->error;
	}
}