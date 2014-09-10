<?php
require_once('../data/occ_data.php');

$parms = get_params(array('soccode'=>'', 'title'=>'', 'socparent'=>'', 'servicetype'=>'child'));

$socdao = new SocDAO();

if    ($parms['servicetype'] == 'child') echo json_encode($socdao->getChildSoccodeList($parms['socparent']));
else                                     echo json_encode($socdao->getSoccodeList($parms['soccode'], $parms['title']));

?>