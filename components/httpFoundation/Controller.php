<?php

namespace components\httpFoundation;
use components\httpFoundation\Session;


class Controller {

	public function __construct(){
		Session::init();
	}

}

?>