<?php
require_once('../data/employer_data.php');


// Create parameterized query for empdb table
$parms = get_params(array('stfips'=>'41', 'areatype'=>'04', 'area'=>'000000', 'zipcode'=>'', 'naicscode'=>'000000', 'sizeclass'=>'9', 
                          'annsalrng'=>'X', 'search'=>'', 'page'=>'1', 'rows'=>'25', 'sord'=>'asc', 'sidx'=>'name') );

$empdao = new EmployerDAO();
header('Content-type: text/xml');
echo $empdao->getEmployerData($parms['stfips'], $parms['areatype'], $parms['area'], $parms['zipcode'],
     $parms['naicscode'], $parms['sizeclass'], $parms['annsalrng'],
     $parms['search'], $parms['page'], $parms['rows'], $parms['sord'], $parms['sidx']);

?>