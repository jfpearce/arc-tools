<?php
require_once('wfutils.php');


class IndustryDAO extends BaseDAO {
	
   public function getQCEWQuarter($stfips, $areatype, $area, $periodyear, 
                                   $periodtype, $period) {
     
  	     $link = getDatabaseConnection();
             $query = sprintf(" SELECT ind.*, format(ind.estab, '###,###,###.##') as estab_fmt,  
                             format(ind.totwage, '###,###,###.##') as totwage_fmt, 
                             format(ind.avgwkwage, '###,###,###.##') as avgwage_fmt, 
                             format(ind.avgemp, '###,###,###.##') as avgemp_fmt, ic.codetitle 
                             FROM wid.industry ind
                             INNER JOIN wid.indcodes ic ON ind.indcodty = ic.codetype 
                             AND ind.indcode = ic.code
                             WHERE ind.stfips = '%s'
                             AND ind.areatype = '%s'
                             AND ind.area = '%s'
                             AND ind.periodyear = '%s'
                             AND ind.periodtype = '%s'
                             AND ind.period = '%s'
                             ORDER BY indcode, period ",
    		                mysql_real_escape_string($stfips),
    		                mysql_real_escape_string($areatype),
    		                mysql_real_escape_string($area),
    		                mysql_real_escape_string($periodyear),
    		                mysql_real_escape_string($periodtype), 
    		                mysql_real_escape_string($period));
    	 $list = $this->getResult($query, $link);
    	
         return $list;
       
  } //QCEWQuarter
  
} //IndustryDAO



/* tests 
$qcew = new IndustryDAO();
echo json_encode($qcew->getQCEWQuarter("41", "01", "000000", "1999", "02", "01"));
*/