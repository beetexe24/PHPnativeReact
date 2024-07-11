<?php


function view($file, $var = null)
{
	$path = __ROOT__.'/views/'.$file.'.php';

	try{
		if($var)
		{
			foreach($var as $key => $value)
			{
				${$key} = $value;
			}
		}
		
		require_once $path;
	} catch(\Exception $ex){
		echo $ex->getMessage();
	}
	
}