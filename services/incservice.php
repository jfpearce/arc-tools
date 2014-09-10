<?php
require_once('../data/income.php');

$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'incsource'=>'incsource', 'inctype'=>'incstype'));

$incdao = new IncomeDAO();

echo json_encode($incdao->getList($parms['stfips'], $parms['areatype'], 
                                  $parms['area'], '3', $parms['inctype']));
?>