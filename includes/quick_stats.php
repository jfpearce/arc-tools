<?php
require_once('data/wfutils.php');

class BldingDAO extends BaseDAO{
	
	public function getPermits($stfips) {
     
  	     $link = getDatabaseConnection();
         $query = sprintf(" SELECT u.typedesc, b.units, b.periodyear, format(b.unitcost, '#,###,###.##') as unitcost from wid.blding b inner join wid.unittype u on u.unittype = b.unittype
                             where periodyear in (select max(periodyear) from wid.blding)
                             and period in (select max(period) from wid.blding where periodyear in (select max(periodyear) from wid.blding))
                             and b.stfips = '%s'",
    		                mysql_real_escape_string($stfips));
         $list = $this->getResult($query, $link);

         return $list;
       
  } //getPermits
}

class StatsDAO extends BaseDAO {
     protected $periodyear;
	 protected $period;
	 protected $lastperiod;
	 protected $lastyear;	
	 protected $rates = array();
	 
    public function getThisYearMonth(){
    	 return date("M Y", mktime(0, 0, 0, $this->period, 1, $this->periodyear));
    }
   
    public function getLastYearMonth(){
   	     return date("M Y", mktime(0, 0, 0, $this->period, 1, $this->periodyear - 1));
    }
    
    public function getLastMonth(){
   	     return date("M Y", mktime(0, 0, 0, $this->period - 1, 1, $this->periodyear));
    }
	 
	protected function setMaxPeriods($link, $obj, $tablename){
   	   $result = mysql_query("select max(periodyear) as periodyear from wid." . $tablename, $link);
       $row = mysql_fetch_assoc($result);
       $obj->periodyear = $row['periodyear'];
       
       mysql_free_result($result);
   
       $query = sprintf(" select max(period) as period from wid." . $tablename .
                        " where periodyear = '%s'", mysql_real_escape_string($obj->periodyear));
       $result = mysql_query($query, $link);
       $row = mysql_fetch_assoc($result);
       $obj->period = $row['period'];
       
       $obj->lastyear = $obj->periodyear - 1;
       if  (($obj->period - 1) == 0)  $obj->lastperiod = '12'; 
       else $obj->lastperiod =  sprintf("%02d", $obj->period - 1);
       
       mysql_free_result($result);
   } //setMaxPeriod()
}

class CpiDAO extends StatsDAO {
	 
	 public function __construct( /*...*/ ) {

	 	$link = getDatabaseConnection();
	 	$this->setMaxPeriods($link, $this, "cpi");
	
	 	
	 	$query = sprintf(
        " select * from wid.cpi where (periodyear = '%s' " .
		" and periodtype = '03' " . 
		" and period in ('%s', '%s') " . 
		" and cpitype = '01' " . 
		" and cpisource = '1') " . 
		" or " .  
		" (periodyear = '%s' " .  
		" and periodtype = '03' " .  
		" and period = '%s' " . 
		" and cpitype = '01' " . 
		" and cpisource = '1') " .
	 	" order by periodyear desc, period desc",
		$this->periodyear, $this->period, $this->lastperiod,
		$this->lastyear, $this->period);
		
		$this->rates = $this->getResult($query, $link);
  	 	
	 }
    
     
     public function getCpiRates(){return $this->rates;}
     
     
}


class MapSeries extends BaseDAO {
	
	public function __construct( /*...*/ ) {}
	
	public function getMapSeries($startperiod="1997", $endperiod="2004", $stfips="00", $periodtype="03", $periods="'01', '06'", $scale=12.5, $output="DEL"){

		 $link = getDatabaseConnection();
		 
		 $query =  sprintf(" select * from wid.labforce where stfips = '%s' and periodyear >= '%s' " . 
                           " and periodyear <= '%s' ", 
		           mysql_real_escape_string($stfips),  mysql_real_escape_string($startperiod),  mysql_real_escape_string($endperiod)) .
		           sprintf(" and area = '000000' " .
		           " and periodtype = '%s' and period in (%s) and adjusted = '0' " .
		           " order by periodyear, periodtype, period", $periodtype, $periods);

		 $result = $this->getResult($query, $link);
		
	     $maplist = array();
             $cnt = 0;
	     $previous = "";

         /* Elminate preliminary duplicates */
	     for ($i = 0; $i < count($result); $i++){
	     	    $current = $result[$i]['periodyear'] . $result[$i]['period'];
	             if ($current == $previous){
	     	       if ($result[$i]['prelim']== '1'){
	     	       	     ;
	     	          }
	     	       else {
	     	       	 $maplist[$cnt - 1] = $result[$i];
	     	       } 	
	     	    }
	     	    else { 
	     	    	   $maplist[$cnt] = $result[$i];
            	       $cnt = $cnt + 1; 
            	       }
	     	   $previous = $current; 
	        } 
          
            if ($output == 'LIST') return $maplist;
                else {
		
		     $mapdata = "";
		     $comma = "";

                    /* Create map list */
		     foreach ($maplist as $value) {
		 	      $mapdata = $mapdata . $comma . ($value['unemprate'] / $scale) * 100;
		 	      $comma = ",";
		              }
		 
		 return $mapdata;
                 }
		 
	} //getMapSeries
	
	
} //MapSeries


class QuickStats extends StatsDAO {
	protected $stfips = "41";
	protected $state_name = "Oregon";
		
    public function __construct( /*...*/ ) {
       $args = func_get_args();
       $this->state_name = $args[0]; 
       $this->stfips = $args[1]; 
       
       $link = getDatabaseConnection();
       $this->setMaxPeriods($link, $this, "labforce");
       
         $query2 = sprintf(
         "select * from wid.labforce " .
		 "where (periodyear = '%s' " .
		 "and periodtype = '03' " .
		 "and period in  ('%s', '%s') " . 
		 "and stfips in ('00', '%s') "  .
		 "and areatype in ('00', '01')" .
		 "and area = '000000' " .
		 "and adjusted = '1') " .
		 "or" .
		 "(periodyear = '%s' " .
		 "and periodtype = '03' " .
		 "and period = '%s' " .
		 "and stfips in ('00', '%s') " .
		 "and areatype in ('00', '01') " .
		 "and area = '000000' " .
		 "and adjusted = '1') " .
		 "order by stfips, periodyear, period", 
		 $this->periodyear, $this->period, $this->lastperiod, $this->stfips, 
		 $this->lastyear, $this->period, $this->stfips);
		 $result = mysql_query($query2, $link);
         if (!$result) {
               $message  = 'Invalid query: ' . mysql_error() . "\n";
               $message .= 'Whole query: ' . $query;
                 die($message);
                }
         
          while ($row = mysql_fetch_assoc($result)) {
            if (($this->periodyear == $row['periodyear']) &&
               ($this->period == $row['period']) &&
               ($row['stfips'] == '00'))
               $this->rates['00M1']  = $row['unemprate'];
               
            else if (($this->periodyear == $row['periodyear']) &&
               ($this->lastperiod == $row['period']) &&
               ($row['stfips'] == '00'))
               $this->rates['00M2']  = $row['unemprate'];  

            else if (($this->lastyear == $row['periodyear']) &&
               ($this->period == $row['period']) &&
               ($row['stfips'] == '00')&&
               ($row['prelim'] == '0'))
               $this->rates['00M3']  = $row['unemprate'];
            
             else if (($this->periodyear == $row['periodyear']) &&
               ($this->period == $row['period']) &&
               ($row['stfips'] == $this->stfips))
               $this->rates[$this->stfips . 'M1']  = $row['unemprate'];
               
            else if (($this->periodyear == $row['periodyear']) &&
               ($this->lastperiod == $row['period']) &&
               ($row['stfips'] == $this->stfips) &&
               ($row['prelim'] == '0'))
               $this->rates[$this->stfips . 'M2']  = $row['unemprate'];  

            else if (($this->lastyear == $row['periodyear']) &&
               ($this->period == $row['period']) &&
               ($row['stfips'] == $this->stfips)&&
               ($row['prelim'] == '0'))
               $this->rates[$this->stfips . 'M3']  = $row['unemprate'];
               
            else ;
             }
             
             mysql_free_result($result);
             mysql_close($link);
   
         
       
      }  // end Constructor
       
    public function getStateName(){
    	return $this->state_name; 
    }
   
        
    public function getRate($key){
    	return $this->rates[$key];
    }
    
    public function getThisYearMonth(){
    	return date("M Y", mktime(0, 0, 0, $this->period, 1, $this->periodyear));
    }
   
   public function getLastYearMonth(){
   	return date("M Y", mktime(0, 0, 0, $this->period, 1, $this->periodyear - 1));
    }
    
  public function getLastMonth(){
   	return date("M Y", mktime(0, 0, 0, $this->period - 1, 1, $this->periodyear));
    }
    
 
} // end QuickStats

/*
$stats = new QuickStats("Oregon", "41");
echo "Starting tests";
echo $stats->getRate('00M1'). '\n';
echo $stats->getRate('00M2'). '\n';
echo $stats->getRate('00M3'). '\n';
echo $stats->getRate('41M1'). '\n';
echo $stats->getRate('41M2'). '\n';
echo $stats->getRate('41M3'). '\n';
echo $stats->getThisYearMonth();
echo $stats->getLastYearMonth();
echo $stats->getLastMonth();
$ms = new MapSeries();
echo $ms->getMapSeries("2005", "00");
echo "\n";
echo $ms->getMapSeries("2005", "41");
$cpi = new CpiDAO();
echo "Finishing tests.";
*/








?>