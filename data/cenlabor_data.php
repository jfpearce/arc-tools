<?php
require_once('wfutils.php');

class CenLaborDAO extends BaseDAO {
	
     		
    public function __construct( /*...*/ ) { }
    
    
   public function getPeriodYears($stfips) {

   $link = getDatabaseConnection();
  
   $sqlstring = "
   select distinct periodyear
   from  wid.cenlabor 
   where stfips = '%s'";

       
   $query = sprintf($sqlstring,   mysql_real_escape_string($stfips));
   
   $years = $this->getJSONResult($query, $link);

    return $years;
  
    } // getCenLabor
      
 
    
        
   public function getCenLabor($stfips, $periodyear) {

   	$link = getDatabaseConnection();
  
   $sqlstring = "
   select censtitle, format(femalelf, '#,###,###.##') as femalelf, format(malelf, '#,###,###.##') as malelf
   from wid.censcode c, wid.cenlabor l 
   where c.censcode = l.censcode
   and l.stfips = '%s'
   and l.periodyear = '%s' 
   order by c.censcode";

       
   $query = sprintf($sqlstring,   mysql_real_escape_string($stfips), mysql_real_escape_string($periodyear));
   
   $cenlab = $this->getJSONResult($query, $link);

    return $cenlab;
  
    } // getCenLabor
      
 }

 /* Tests 
$cenlab = new CenLaborDAO();
echo $cenlab->getCenLabor('66', '1999');
echo $cenlab->getPeriodYears('66');
*/


?>