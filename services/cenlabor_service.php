<?php
require_once('../data/cenlabor_data.php');

$parms = get_params(array('stfips'=>'41', 'periodyear'=>'2008', 'servicetype'=>'data'));

$cenlab = new CenLaborDAO();

if    ($parms['servicetype'] == 'data') echo $cenlab->getCenLabor($parms['stfips'], $parms['periodyear']);
else                                    echo $cenlab->getPeriodYears($parms['stfips']);

?>