<?php
require_once('../data/population.php');

$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'popsource'=>'popsource'));

$popdao = new PopulationDAO();

echo json_encode($popdao->getList($parms['stfips'], $parms['areatype'], 
                                  $parms['area'], $parms['popsource']));
?>