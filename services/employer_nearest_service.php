<?php
require_once('../data/employer_data.php');


// Create parameterized query for empdb table
$parms = get_params(array('latitude'=>'41', 'longitude'=>'04', 'miles'=>'5', 'naicscode'=>'000000', 'sizeclass'=>'9', 
                          'annsalrng'=>'X', 'search'=>'', 'page'=>'1', 'rows'=>'25', 'sord'=>'asc', 'sidx'=>'name') );

$empdao = new EmployerDAO();
header('Content-type: text/xml');
echo $empdao->getEmployerNearestData($parms['latitude'], $parms['longitude'], $parms['miles'], 
     $parms['naicscode'], $parms['sizeclass'], $parms['annsalrng'],
     $parms['search'], $parms['page'], $parms['rows'], $parms['sord'], $parms['sidx']);

?>
