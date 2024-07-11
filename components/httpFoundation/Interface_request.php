<?php
namespace components\httpFoundation;

interface Interface_request{

	public function validateURL($url);
	public function validateControllers($controller);
	public function validateMethods($controller, $method);
	public function loadWebCurrentURL($current_url);
	public function loadApiCurrentURL($current_url);
}