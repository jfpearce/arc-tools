<?php
require_once('../data/geog_data.php');

$parms = get_params(array('stfips'=>'41', 'areatype'=>'04'));

$glist = new GeogDAO();
echo $glist->getAreaList($parms['stfips'], $parms['areatype']);
?>