<?php
require_once('../data/ces_data.php');


$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'01', 'periodyear'=>'2010', 
                          'periodtype'=>'03', 'adjusted'=>'1', 'serieslvl'=>'5', 'seriescode'=>'', 
                          'servicetype'=>'data'));




if ($parms['servicetype'] == 'industry'){
   $cesInd = new CesIndustryDAO();
   echo json_encode($cesInd->getList($parms['stfips'], $parms['areatype'], $parms['area'], $parms['seriescode'], $parms['adjusted']));	
   }
   else {
   $cesdao = new CesDAO();
   echo json_encode($cesdao->getCesDataLevel($parms['stfips'], $parms['areatype'], $parms['area'], 
                              $parms['periodyear'], $parms['periodtype'], $parms['adjusted'], $parms['serieslvl']));
   }



?>