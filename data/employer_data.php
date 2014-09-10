<?php
require_once('wfutils.php');

class EmployerDAO extends BaseDAO {
	
    protected $recs = 0;
    		
    public function __construct( /*...*/ ) { }
    
    public function getEmployerRecord($uniqueid){
    	
    	 $link = getDatabaseConnection();
    	 
    	 $query= sprintf(" select e.*, s.emprngdesc, a.salrngdesc " .
                         " from wid.empdb e left outer join wid.annslrng a " .
                         "  on a.annsalrang = e.annsalrng " .
                         "  left outer join wid.empszrng s " .
                         "  on s.empsizrng = e.empsizrng " .
                         " where e.uniqueid = '%s' ",
                          mysql_real_escape_string($uniqueid));

         $emprec = $this->getResult($query, $link);

         return $emprec;
    	
    }
    
    public function getEmployerIndustries($stfips, $areatype, $area, $sect, $search){
    	$link = getDatabaseConnection();
    	$query = "";
    	if (strlen($search) >= 3) {
    	  $query= sprintf(" select n.naicscode, n.naicstitle, i.employers " .
                  " from wid.naiccode n, wid.indsum i " .
                  " where stfips = '%s'" .
                  " and areatype = '%s'" .
                  " and area = '%s'" . 
                  " and n.naicscode = i.indcode " .
                  " and i.indcodetyp = '10' " .
                  " and indsource = '1'" .
                  " and lower(n.naicstitle) like '%s'" . 
                  " order by naicscode",
                   mysql_real_escape_string($stfips), 
                   mysql_real_escape_string($areatype), 
                   mysql_real_escape_string($area), 
                   mysql_real_escape_string('%' . $search . '%')); 
    	}
    	else {
    		$query = sprintf(" select n.naicscode, n.naicstitle, i.employers " .
                  " from wid.naiccode n, wid.indsum i " .
                  " where stfips = '%s'" .
                  " and areatype = '%s'" .
                  " and area = '%s'" .
                  " and n.naicscode = i.indcode " .
                  " and i.indcodetyp = '10' " .
                  " and indsource = '1'" .
                  " and naicsect = '%s'" . 
                  " order by naicscode",
                   mysql_real_escape_string($stfips), 
                   mysql_real_escape_string($areatype), 
                   mysql_real_escape_string($area), 
                   mysql_real_escape_string($sect)); 
    	}
    	
    	
         $indlist = $this->getJSONResult($query, $link);

         return $indlist;
     
    }
    
    
    
    
    public function getEmployerNearestData($latitude="45.56790980571085", $longitude="-122.69531292187501", $miles="5",
                                  $naicscode="000000", $sizeclass="9", $annsalrng="X",  
                                  $search="", $page="1", $rows="25", $sord="asc", $sidx="name"){
      $link = getDatabaseConnection();
      $page = max($page, 1);
      $start = (($page * $rows) + 1) - $rows;
                                     	
      $where = sprintf(" where ((sqrt(power((" . $longitude .  ") - longitude, 2) + power(" . $latitude .  " - latitude, 2)) * 75) < " . $miles . ")") .
               sprintf( ($naicscode == '000000') ? "" : " and primnaics like '%s' ", mysql_real_escape_string($naicscode . '%') ) . 
               sprintf( ($search == '') ? "" : " and name like '%s' ", mysql_real_escape_string('%' . $search . '%') ) . 
               sprintf( ($annsalrng == 'X') ? "" : " and annsalrng='%s'", mysql_real_escape_string($annsalrng ) ) . 
               sprintf( (($sizeclass == '9') ? "" : " and empsizrng='%s'") . 
              " order by " . $sidx . " " . $sord . "  ", mysql_real_escape_string($sizeclass) );
         
           
       $query = "select * from wid.empdb " . $where . " limit " . ($start - 1) . ", " . $rows ;
      
   
    	return $this->getEmployerResult($query, $where,  $rows, $page, $link);
   }
                                                   
    
    
    
    public function getEmployerData($stfips = "41", $areatype = "01", $area = "000000", $zipcode="",
                                     $naicscode="000000", $sizeclass="9", $annsalrng="X",
                                     $search="", $page="1", $rows="25", $sord="asc", $sidx="name"){
                                     	
      $link = getDatabaseConnection();
      $page = max($page, 1);
      $start = (($page * $rows) + 1) - $rows;
                                     	
      $where = sprintf(" WHERE stfips = '%s' ", mysql_real_escape_string($stfips) ) . 
           sprintf( ($areatype == '01') ? "" : " and areatype = '%s' and area = '%s' ", mysql_real_escape_string($areatype), mysql_real_escape_string($area) ) .
           sprintf( ($naicscode == '000000') ? "" : " and primnaics like '%s' ", mysql_real_escape_string($naicscode . '%') ) . 
           sprintf( ($search == '') ? "" : " and name like '%s' ", mysql_real_escape_string('%' . $search . '%') ) . 
           sprintf( ($annsalrng == 'X') ? "" : " and annsalrng='%s'", mysql_real_escape_string($annsalrng ) ) . 
           sprintf( ($zipcode == '') ? "" : " and zipcode='%s'", mysql_real_escape_string($zipcode ) ) . 
           sprintf( (($sizeclass == '9') ? "" : " and empsizrng='%s'") . 
           " order by " . $sidx . " " . $sord . "  ", mysql_real_escape_string($sizeclass) );
         
           
       $query = "select * from wid.empdb " . $where . " limit " . ($start - 1) . ", " . $rows ;
      
   
    	return $this->getEmployerResult($query, $where,  $rows, $page, $link);
    } //getEmployerData
    
   public function getEmployerResult($query, $where, $rows, $page, $link){
                                     	
      $result = mysql_query($query, $link);
      
      $this->recs = $this->getQueryRecords($where, $link);

   // Check result and report any errors
    if (!$result) {
        $this->$message  = 'Invalid query: ' . mysql_error() . "\n";
        $this->$message .= 'Whole query: ' . $query;
     }
      
   $total = round($this->recs / $rows);
   $xmlstring =  "<?xml version='1.0' standalone='yes'?>" .  "\n" .
                  "<rows>" . "\n" .
                  '<page>' . $page . '</page>' . "\n" .
                  '<total>' . $total . '</total>' . "\n" .
                  '<records>' . $this->recs . '</records>' . "\n";
      while ($row = mysql_fetch_assoc($result)){
      	          $xmlstring = $xmlstring . '<row>' .
                  '<cell>' .$row['uniqueid']. '</cell>' .
                  '<cell>'  .$row['latitude']. '</cell>' .
                  '<cell>'  .$row['longitude']. '</cell>' .
                  '<cell>'  .htmlspecialchars(ucwords(strtolower($row['name']))). '</cell>' .
                  '<cell>'  .htmlspecialchars(ucwords(strtolower($row['addressp']))). '</cell>' .
                  '<cell>'  .htmlspecialchars(ucwords(strtolower($row['cityp']))). '</cell>' .
                  '<cell>'  .htmlspecialchars($this->getSizeRange($row['empsizrng'])). '</cell>' .
                  '<cell>'  .htmlspecialchars($this->getSalesRange($row['annsalrng'])). '</cell>' .
                  '</row>' . "\n";
            }
         $xmlstring = $xmlstring . "</rows>";                          
    	 mysql_free_result($result);
         mysql_close($link);
   
    	return $xmlstring;
    } //getEmployerResult
    
    private function getQueryRecords($where, $link){
       $query = "SELECT count(*) as count FROM wid.empdb " . $where;
       $result = mysql_query($query, $link);
       $row = mysql_fetch_assoc($result);
       $recs = $row['count'];
       mysql_free_result($result);
       return $recs;
    }
    
    public function getRecordCount(){
      return $this->recs;
    }
    
    private function getSizeRange($empsizrng) {

     if      ($empsizrng == "A") return "1 - 4 employees";
     else if ($empsizrng == "B") return "5 - 9 employees";
     else if ($empsizrng == "C") return "10 - 19 employees";
     else if ($empsizrng == "D") return "20 - 49 employees";
     else if ($empsizrng == "E") return "50 - 99 employees";
     else if ($empsizrng == "F") return "100 - 249 employees";
     else if ($empsizrng == "G") return "250 - 499 employees";
     else if ($empsizrng == "H") return "500 - 999 employees";
     else if ($empsizrng == "I") return "1000 - more employees";
     else if ($empsizrng == "J") return "5000 - 9,999 employees";
     else if ($empsizrng == "K") return "10,000+ employees";
     else return "";

     }

   private function getSalesRange($annsalrng) {

     if      ($annsalrng == "A") return "Less than 500K";
     else if ($annsalrng == "B") return "500K < 1 Million";
     else if ($annsalrng == "C") return "1 Million < 2.5 Million";
     else if ($annsalrng == "D") return "2.5 Million < 5 Million";
     else if ($annsalrng == "E") return "5 Million < 10 Million";
     else if ($annsalrng == "F") return "10 Million < 20 Million";
     else if ($annsalrng == "G") return "20 Million < 50 Million";
     else if ($annsalrng == "H") return "50 Million < 100 Million";
     else if ($annsalrng == "I") return "100 Million < 500 Million";
     else if ($annsalrng == "J") return "500 Million < 1 Billion";
     else if ($annsalrng == "K") return "Greater than 1 Billion";
     else return "";

       }
    
}

/* Tests 
$empdao = new EmployerDAO();
echo $empdao->getEmployerIndustries("41", "04", "000001", "44", "new car");
echo $empdao->getMessage();
echo $empdao->getEmployerData();
echo $empdao->getEmployerNearestData();
echo $empdao->getRecordCount();
echo $empdao->getEmployerRecord("659758189");
*/





?>