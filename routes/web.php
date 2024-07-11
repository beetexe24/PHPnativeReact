<?php
use Components\HttpFoundation\Route;

/*
	FORMAT
	Route::get(URL, CONTROLLER, METHOD)
	Route::post(URL, CONTROLLER, METHOD)
*/


Route::get('/', 'indexController', 'index');