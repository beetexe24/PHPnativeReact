<?php
namespace app\http\models;


use components\httpFoundation\Model;
use \PDO;


class brands extends Model{

	public function __construct()
	{
		parent::__construct();
	}


	/****
	* 
	* UPDATING RECORDS IN DATABASE
	*
	* $query = $this->db->prepare("UPDATE BRANDS SET IS_ACTIVE = :IS_ACTIVE WHERE BRAND_NAME = :BRAND_NAME");
	* $query->bindParam(':IS_ACTIVE', $is_active);
	* $query->execute();
	*
	* return $query->rowCount();
	*
	****/


	/**
	* 
	* RETRIEVING RECORDS IN DATABASE
	*
	* $query = $this->db->prepare("SELECT * FROM BRANDS WHERE IS_ACTIVE = :IS_ACTIVE");
	* $query->bindParam(':IS_ACTIVE', $is_active);
	* $result = $query->fetchAll(PDO::FETCH_OBJ);
	*
	* return $result;
	**/

	public function retrieve()
	{
    	$query = $this->db->prepare("select * FROM brands where is_active = 1");
    	$query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public function updateBrandStatus($is_active, $brand)
	{
		$query = $this->db->prepare("select * from brands WHERE brand = :brand");
	    $query->bindParam(':brand', $brand);
	    $query->execute();
	    $result = $query->fetchAll(PDO::FETCH_OBJ);
	   	
	   
	    if($result)
	    {
	    	try{
				$query = $this->db->prepare("update brands set is_active = :is_active WHERE brand = :brand");
		    	$query->bindParam(':is_active', $is_active);
		    	$query->bindParam(':brand', $brand);
		    	$query->execute();

		    	// IF SUCCEEDED
		    	return 1;
		    	
			} catch(\Exception $ex){
				// IF ERROR
				return 0;
			}
	    }
	    else
	    {
	    	// IF BRAND NOT FOUND
	    	return 2;
	    }
    }

    
}