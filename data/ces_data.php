<?php
require_once('wfutils.php');


class CesDAO extends BaseDAO {
	
   public function getCesDataLevel($stfips, $areatype, $area, $periodyear, 
                                   $periodtype, $adjusted, $serieslvl) {
     
  	     $link = getDatabaseConnection();
         $query = sprintf(" SELECT s.seriesttls, s.serieslvl,  format(c.empces, '###,###,###.##') as empces,
                            c.periodyear, c.periodtype, c.period, c.stfips, c.areatype, c.area,
                            c.adjusted, c.seriescode, c.prelim
                             FROM wid.cescode s
                             INNER JOIN wid.ces c ON c.stfips = s.stfips
                             AND c.seriescode = s.seriescode
                             WHERE c.stfips = '%s'
                             AND c.areatype = '%s'
                             AND c.area = '%s'
                             AND c.periodyear = '%s'
                             AND c.periodtype = '%s'
                             and c.adjusted = '%s'
                             and serieslvl <= '%s'
                             ORDER BY seriescode, period ",
    		                mysql_real_escape_string($stfips),
    		                mysql_real_escape_string($areatype),
    		                mysql_real_escape_string($area),
    		                mysql_real_escape_string($periodyear),
    		                mysql_real_escape_string($periodtype), 
    		                mysql_real_escape_string($adjusted),
    		                mysql_real_escape_string($serieslvl));
    	 $list = $this->getResult($query, $link);

         return $list;
       
  } //getCesData
  
} //CesDAO

class CesIndustryDAO extends BaseDAO {
	
	public function getList($stfips, $areatype, $area, $seriescode, $adjusted){
	  $link = getDatabaseConnection();
         $query = sprintf(" SELECT s.seriesttls, s.serieslvl,  empces, format(c.empces, '###,###,###.##') as empces_fmt,
                            c.periodyear, c.periodtype, c.period, c.stfips, c.areatype, c.area,
                            c.adjusted, c.seriescode, c.prelim
                             FROM wid.cescode s
                             INNER JOIN wid.ces c ON c.stfips = s.stfips
                             AND c.seriescode = s.seriescode
                             WHERE c.stfips = '%s'
                             AND c.areatype = '%s'
                             AND c.area = '%s'
                             AND c.seriescode = '%s'
                             and c.adjusted = '%s'
                             ORDER BY periodyear, periodtype, period, prelim ",
    		                mysql_real_escape_string($stfips),
    		                mysql_real_escape_string($areatype),
    		                mysql_real_escape_string($area),
    		                mysql_real_escape_string($seriescode),
    		                mysql_real_escape_string($adjusted));
    	 $list = $this->getResult($query, $link);

         return $list;	
	}
} // CesIndustryDAO

/* tests 
$ces = new CesDAO();
echo json_encode($ces->getCesDataLevel("41", "01", "000000", "2010", "03", "1", "5"));
$ces = new CesIndustryDAO();
echo json_encode($ces->getList("41", "01", "000000", "20000000", "1"));
*/





?>