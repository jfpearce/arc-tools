<?php
require_once('wfutils.php');


class IncomeDAO extends BaseDAO {	
	
public function getList($stfips, $areatype, $area, $incsource, $inctype) {
		
		 $link = getDatabaseConnection();
         $query = sprintf(" SELECT * from wid.income 
                             where stfips = '%s'
                             and areatype = '%s'
                             and area = '%s'
                             and incsource = '%s' 
                             and inctype = '%s' 
                             and periodyear >= '1980' ",
    		                 mysql_real_escape_string($stfips),
    	 	                 mysql_real_escape_string($areatype),
    		                 mysql_real_escape_string($area),
    		                 mysql_real_escape_string($incsource),
                                 mysql_real_escape_string($inctype));
    		                 
    	$list = $this->getResult($query, $link);

         return $list;
		
	}

	
} //PopulationDAO 

/* Tests   
$incdao = new IncomeDAO();
echo json_encode($incdao->getList("41", "04", "000023", "3"));
*/	

?>