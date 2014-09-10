<?php
require_once('../data/qcew_data.php');


$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'periodyear'=>'1999', 
                          'periodtype'=>'02', 'period'=>'01', 'servicetype'=>'data'));


$qcewdao = new IndustryDAO();
echo json_encode($qcewdao->getQCEWQuarter($parms['stfips'], $parms['areatype'], $parms['area'], 
                              $parms['periodyear'], $parms['periodtype'], $parms['period']));
?>