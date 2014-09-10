<?php
require_once('wfutils.php');

class EducationDAO extends BaseDAO {
	
	public function getSocCips($soccode) {
     
  	     $link = getDatabaseConnection();
         $query = sprintf(" SELECT * from wid.cipcode c 
                            inner join wid.socxcip s on s.cipcode = c.cipcode
                            where soccode = '%s'",
    		                 mysql_real_escape_string($soccode));
    	 $list = $this->getResult($query, $link);

         return $list;
       
  } //getSocCips
  
}



?>