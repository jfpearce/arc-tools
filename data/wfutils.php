<?php
require_once('configuration.php');
require_once('jsonwrapper.php');


function get_params($defaults = null)
{
    $ret = array();

    // fetch values from request
        foreach($_GET as $k=>$v)
            $ret[$k] = $v;

    // apply defaults for missing parameters
    if($defaults) foreach($defaults as $k=>$v)
        if(!isset($ret[$k]))
            $ret[$k] = $v;

   
    return $ret;
}

function getDatabaseConnection($mysql_server = ARConfig::database_url, $mysql_user = ARConfig::database_user, $mysql_password = ARConfig::database_password) {

 $link = mysql_connect($mysql_server, $mysql_user, $mysql_password);
      if (!$link) {
                die('Could not connect: ' . mysql_error());
       }
 return $link;
}

function formatPhonenum($phonenum){
	if (strlen($phonenum) == 10) return substr($phonenum, 0, 3) . '-' . substr($phonenum, 3, 3) . '-' . substr($phonenum, 6, 4);
	else if (strlen($phonenum) == 7) return substr($phonenum, 0, 3) . '-' . substr($phonenum, 3, 4);
	else return "";
}

class BaseDAO {
	
    protected $message = "OK";
    		
    public function __construct( /*...*/ ) {
    
    }
    
   
    
   public function getMessage(){return $this->message;} 
   
   public function getJSON($result){
          $jlist = array();
           for ($i = 0; $row = mysql_fetch_assoc($result); $i++){
            	$jlist[$i] = $row;
            }
           return $jlist;        
   }
   
  public function getJSONResult($query, $link){
        return json_encode($this->getResult($query, $link));        
   }
   
  public function getResult($query, $link){
        $jlist = array();
     
       $result = mysql_query($query, $link);
    
        // Check result and report any errors
        if (!$result) {
           $this->message = 'Invalid query: ' . mysql_error() . "\n";
           $this->message = 'Whole query: ' . $query;
            }
            
           for ($i = 0; $row = mysql_fetch_assoc($result); $i++){
            	$jlist[$i] = $row;
            }
            
           mysql_free_result($result);
           mysql_close($link);
           return $jlist;        
   }
    
        
} //BaseDAO

/* Tests
echo formatPhonenum("5414851418");
*/

?>