<?php
require_once('wfutils.php');

class GeogDAO extends BaseDAO {
	
     		
    public function __construct( /*...*/ ) { }
    
        
    public function getAreaList($stfips, $areatype) {
          
    	 $link = getDatabaseConnection();
       
    	 $query = sprintf("select * from wid.geog " .
                     "where stfips = '%s' and areatype = '%s' order by stfips, areatype, area",
                     mysql_real_escape_string($stfips),  mysql_real_escape_string($areatype));
            
         $arealist = $this->getJSONResult($query, $link);

         return $arealist;
     
    }
    
        
}

/* Tests
$glist = new GeogDAO();
echo $glist->getAreaList("06", "04");
*/



?>