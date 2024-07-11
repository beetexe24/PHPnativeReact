<?php
use components\httpFoundation\Route;

/*
	FORMAT
	Route::get(URL, CONTROLLER, METHOD)
	Route::post(URL, CONTROLLER, METHOD)
*/


Route::get('/api/fetch', 'api/hubspotController', 'fetch');