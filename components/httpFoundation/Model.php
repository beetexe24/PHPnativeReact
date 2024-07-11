<?php
namespace components\httpFoundation;
use components\httpFoundation\Database;

class Model{

	public function __construct(){
		$this->db = new Database();
	}



}