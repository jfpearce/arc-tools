<?php

require_once('wfutils.php');

class LicenseDAO extends BaseDAO {	
	
public function getLicxocc($stfips, $areatype, $area, $occcode) {
		
		 $link = getDatabaseConnection();
         $query = sprintf(" SELECT * from wid.licxocc x 
                             inner join wid.license l 
                             on l.stfips = x.stfips 
                             and l.licenseid = x.licenseid 
                             where l.stfips = '%s'
                             and l.areatype = '%s'
                             and l.area = '%s'
                             and x.occcode = '%s' ",
    		                 mysql_real_escape_string($stfips),
    	 	                 mysql_real_escape_string($areatype),
    		                 mysql_real_escape_string($area),
    		                 mysql_real_escape_string($occcode));
    		                 
    		                 
    	$list = $this->getResult($query, $link);

         return $list;
		
	}

	
} //PopulationDAO 

/* Tests  
$licdao = new LicenseDAO();
echo json_encode($licdao->getLicxocc("41", "01", "000000", "472111"));
*/	  

?>