<?php
require_once('wfutils.php');

interface OccDAO
{
    public function setVariable($name, $var);
    public function getHtml($template);
}

class OccLevel {

   public function getCssClass($indcode) {
      if      (strlen($indcode) < 2) return '';
      else if (strlen($indcode) < 3) return 'class="lev2"'; 
      else if (strlen($indcode) < 4) return 'class="lev3"'; 
      else if (strlen($indcode) < 5) return 'class="lev4"'; 
      else return '';
      
   }

}


class MatrixDAO extends BaseDAO {
	
   public function getMatprojData($stfips, $areatype, $area, $soccode) {
     
  	     $link = getDatabaseConnection();
         $query = sprintf(" select o.matocctitl, m.*, p.projyear, p.estyear from wid.iomatrix m 
               inner join wid.occdir o 
               on o.stfips = m.stfips 
               and o.matoccode = m.matoccode
               and o.periodid = m.periodid
               inner join wid.matxsoc x 
               on o.stfips = x.stfips 
               and o.matoccode = x.matoccode
               and o.periodid = x.periodid
               inner join wid.periodid p
               on m.periodid = p.periodid
               where m.stfips = '%s'
               and m.areatype = '%s'
               and m.area = '%s' 
               and x.soccode = '%s'
               and m.matincode = '0'; ",
    		                mysql_real_escape_string($stfips),
    		                 mysql_real_escape_string($areatype),
    		                mysql_real_escape_string($area),
    		                mysql_real_escape_string($soccode));
    	 $list = $this->getResult($query, $link);

         return $list;
       
  } //getMatprojData
  
  public function getIndestData($stfips, $areatype, $area, $soccode) {
     
  	$link = getDatabaseConnection();
    $query = sprintf(" select d.matincode, g.areaname as areaname,  matintitle, format(d.estemp, '###,###,###') as emp, p.projyear, p.estyear
                       FROM wid.iomatrix d, wid.geog g, wid.inddir e, wid.matxsoc m, wid.periodid p
                       WHERE d.matincode = e.matincode  
    					and g.stfips = '%s'
    					and d.areatype = '%s'  
    					and g.area =  '%s' 
    					and m.soccode = '%s'   
    					and e.stfips = g.stfips  
    					and m.stfips = g.stfips 
    					and d.stfips = g.stfips 
   						and p.stfips = g.stfips 
    					and g.areatype =  d.areatype  
    					and d.area =  g.area
    					and d.periodid = p.periodid
    					and d.matoccode = m.matoccode; ",
    		                mysql_real_escape_string($stfips),
    		                 mysql_real_escape_string($areatype),
    		                mysql_real_escape_string($area),
    		                mysql_real_escape_string($soccode));
    	 $list = $this->getResult($query, $link);

         return $list;
       
  } //getMatprojData
    	
	
}

class SocDAO extends BaseDAO {
	
     		
    public function __construct( /*...*/ ) { }
    
        
    public function getSoccodeList($soccode, $title) {
    	  $link = getDatabaseConnection();
    	  $query = "";
          if (strlen($title) > 0 )
             $query = sprintf("select * from wid.soccode 
    		                   where (lower(soctitle) like '%s' 
                               or lower(socdesc) like '%s' ) 
                               and soccode not like '%s' order by soccode ", 
                               mysql_real_escape_string('%' . $title . '%'),  
                               mysql_real_escape_string('%' . $title. '%'),
                               mysql_real_escape_string('%0'));
         else 
             $query = sprintf(" select * from wid.soccode 
    		                    where soccode = '%s' order by soccode ",
                                mysql_real_escape_string($soccode));
                                    
         $soclist = $this->getResult($query, $link);

         return $soclist;
       
  } //getSoccodeList


  public function getChildSoccodeList($socparent) {
     
  	     $link = getDatabaseConnection();
         $query = sprintf(" select * from wid.soccode 
    		                where socparent = '%s' order by soccode ",
    		                mysql_real_escape_string($socparent));
    		                
         $soclist = $this->getResult($query, $link);

         return $soclist;
       
  } //getChildSoccodeList
    
        
}

class OccodeDAO extends BaseDAO {
	
     		
    public function __construct( /*...*/ ) { }
    
        
    public function getOccodeList($occcode, $title, $codetype) {
    	  $link = getDatabaseConnection();
    	  $query = "";
          if (strlen($title) > 0 )
             $query = sprintf("select * from wid.occcodes 
    		                   where lower(codetitle) like '%s' 
                                   and codetype = '%s'
                                   order by occcode ", 
                               mysql_real_escape_string('%' . $title . '%'),  
                               mysql_real_escape_string(codetype));
         else 
             $query = sprintf(" select * from wid.occcode 
    		                    where occcode = '%s' order by occcode ",
                                mysql_real_escape_string($occcode));
                                    
         $occlist = $this->getResult($query, $link);

         return $occlist;
       
  } //getOccodeList

}


class OesWageDAO extends BaseDAO {
	
	public function getWageData($stfips, $occcode, $periodtype, $period) {
     
  	     $link = getDatabaseConnection();
         $query = sprintf(" SELECT periodyear, g.areaname,  pct10, pct25, median, pct75, pct90, mean 
                             from wid.geog g inner join wid.oeswage w  
                             on w.stfips = g.stfips and w.areatype = g.areatype and w.area = g.area 
                             inner join wid.soccode s on occcode = soccode 
                             where w.stfips = '%s'  
                             and occcode = '%s'
                             and periodtype = '%s'
                             and period = '%s' ",
    		                mysql_real_escape_string($stfips),
    		                 mysql_real_escape_string($occcode),
    		                mysql_real_escape_string($periodtype),
    		                mysql_real_escape_string($period));
    	 $list = $this->getResult($query, $link);

         return $list;
       
  } //getWageData
    
	
	
}

/*  Tests
$socdao = new SocDAO();
echo $socdao->getSoccodeList("291060", "truck");
echo $socdao->getChildSoccodeList("000000");'
$wages = new OesWageDAO();
echo $wages->getWageData("66", "111011", "07", "02");
$matproj = new MatrixDAO();
echo json_encode($matproj->getMatprojData("41", "01", "000000", "111011"));
echo json_encode($matproj->getIndestData("41", "01", "000000", "111011"));
*/



?>