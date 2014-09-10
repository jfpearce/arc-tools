<?php
require_once('wfutils.php');


class PopulationDAO extends BaseDAO {	
	
public function getList($stfips, $areatype, $area, $popsource) {
		
		 $link = getDatabaseConnection();
         $query = sprintf(" SELECT * from wid.populatn 
                             where stfips = '%s'
                             and areatype = '%s'
                             and area = '%s'
                             and popsource = '%s' 
                             and periodyear >= '1980' ",
    		                 mysql_real_escape_string($stfips),
    	 	                 mysql_real_escape_string($areatype),
    		                 mysql_real_escape_string($area),
    		                 mysql_real_escape_string($popsource));
    		                 
    	$list = $this->getResult($query, $link);

         return $list;
		
	}

	
} //PopulationDAO 

/* Tests   
$popdao = new PopulationDAO();
echo json_encode($popdao->getList("41", "04", "000023", "1"));
*/	

?>