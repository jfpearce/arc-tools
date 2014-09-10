<?php
require_once('../data/employer_data.php');

$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'naicsect'=>'00', 'search'=>''));

$glist = new EmployerDAO();
echo $glist->getEmployerIndustries($parms['stfips'], $parms['areatype'], $parms['area'], $parms['naicsect'], $parms['search']);