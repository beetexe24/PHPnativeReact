<?php
use app\http\models\brands;
use components\httpFoundation\Controller;
use components\httpFoundation\Session;
use components\httpFoundation\Request;
use app\http\services\hubspotService;



class hubspotController extends Controller{

	public function __construct()
	{
		parent::__construct();
	}


	/**
	*
	*
	* TO GET REQUESTS PARAMETERS
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


	public function fetch()
	{
		$request = new Request;
		$hubspotService = new hubspotService;
		
		echo json_encode($hubspotService->fetchContacts($request));
		
	}

	public function justpost()
	{
		$request = new Request;
		echo "Hi";
	}
}