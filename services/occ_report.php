<?php
require_once('../data/occ_data.php');
require_once('../data/education_data.php');
require_once('../data/license_data.php');


$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'soccode'=>'352014'));

$licdao = new LicenseDAO();
$socdao = new SocDAO();
$wagedao = new OesWageDAO();
$edudao = new EducationDAO();
$occdao = new MatrixDAO();
$ciplist = $edudao->getSocCips($parms['soccode']);
$wages =  $wagedao->getWageData("66", $parms['soccode'], "07", "01"); // Guam data
// $wages =  $wagedao->getWageData($parms['stfips'], $parms['soccode'], "08", "01");
$occprj = $occdao->getMatprojData($parms['stfips'], $parms['areatype'], $parms['area'], $parms['soccode']);
$indest = $occdao->getIndestData($parms['stfips'], $parms['areatype'], $parms['area'], $parms['soccode']);
$liclist = $licdao->getLicxocc($parms['stfips'], "01", "000000", $parms['soccode']);
?>
<div class="reportSection">
<span class="sectionTitle">Occupational Description</span>
<p>
<?php $occdata = $socdao->getSoccodeList($parms['soccode'], '');
echo   $occdata[0]['soctitlel'] . ' (SOC: ' . $occdata[0]['soccode'] . ')</p>';
echo '<p><br/>' .  $occdata[0]['socdesc'] . '</p>';

?>
</div>
<br/><br/>
<div class="reportSection">
<span class="sectionTitle">Licenses</span>
<br/><br/>
<?php if (count($liclist) == 0) echo "<br/>No Licenses associated with this occupation.";
      else {
      
?>
<table>
<tbody>
<?php  foreach ($liclist as $value) { 
     echo '<tr><td>' . ucwords(strtolower($value['lictitle'])) . '</td></tr>';
      }        ?>
</tbody>
</table>
<?php } // end Licenses ?>


<br/><br/>
<div class="reportSection">
<span class="sectionTitle">Training Programs</span>
<br/><br/>
<?php if (count($ciplist) == 0) echo "<br/>No training programs association with this occupation.";
      else {
      
?>
<table>
<tbody>
<?php  foreach ($ciplist as $value) { 
     echo '<tr><td>' . ucwords(strtolower($value['ciptitle'])) . '</td></tr>';
      }        ?>
</tbody>
</table>
<?php } // end Traing programs ?>
<br/><br/>
<div class="reportSection">
<span class="sectionTitle">Wages</span>
<br/><br/>
<?php if (count($wages) == 0) echo "<br/>No wage data available.";
      else {
      
?>
<table class="data" border="1" cellpadding="5" cellspacing="0">
 <tbody>
 <tr>
 <th rowspan="2">Region</th>
 <th rowspan="2">Year</th>
 <th rowspan="2">Avg<br>Hourly</th>
 <th colspan="5">Percentiles (hourly wages)</th>
 </tr>

 <tr>
  <th>10th</th>
  <th>25th</th>
  <th>50th<br>(median)</th>
  <th>75th</th>
  <th>90th</th>
 </tr>
 <?php 
  foreach ($wages as $value) {
 ?>
 
  <tr>
  <td><?php echo $value['areaname']; ?></td>
  <td><?php echo $value['periodyear']; ?></td>
  <td class="dcell">$<?php echo $value['mean']; ?></td>
  <td class="dcell">$<?php echo $value['pct10']; ?></td>
  <td class="dcell">$<?php echo $value['pct25']; ?></td>
  <td class="dcell">$<?php echo $value['median']; ?></td>
  <td class="dcell">$<?php echo $value['pct75']; ?></td>
  <td class="dcell">$<?php echo $value['pct90']; ?></td>
  </tr>
 	
<?php   	
  }
 
 ?>
</tbody>
</table>
</div>
<?php } // end wage display ?>


<br/><br/>
<div class="reportSection">
<span class="sectionTitle">Employment Projections</span>
<br/><br/>
<?php if (count($occprj) == 0) echo "<br/>No projections association with this occupation.";
      else {
  $heading = '';
?>
<table border="1" cellpadding="5" cellspacing="0">
<tbody>
<th rowspan="2">Mat. Occupation</th>
  <th colspan="2">Employment</th>
  <th rowspan="2">Change</th>
  <th rowspan="2">% Change</th>
  <th colspan="3">Projected Annual Openings</th>
  </tr>
  <tr>
 <?php  foreach ($occprj as $value) {
 	if ($heading == '') {
        echo '<th>' . $value['estyear'] . '</th>';
        echo '<th>' . $value['projyear'] . '</th>';
        $heading =  '<th>Growth</th><th>Replacement</th><th>Total</th></tr>';
        echo $heading;
 	    }
     echo '<tr><td class="txt">' . $value['matocctitl'] . '</td>';
     echo '<td class="dcell">' . number_format($value['estemp']) . '</td>';
     echo '<td class="dcell">' . number_format($value['projemp']) . '</td>';
     $change = $value['projemp'] - $value['estemp'];
     $percent = 100 * $change / $value['estemp'];
     echo '<td class="dcell">' . number_format($change) . '</td>';
     echo '<td class="dcell">' . number_format($percent, 1) . '</td>';
     echo '<td class="dcell">' . number_format($value['aopeng']) . '</td>';
     echo '<td class="dcell">' . number_format($value['aopenr']) . '</td>';
     echo '<td class="dcell">' . number_format($value['aopent']) . '</td></tr>';
        }        ?>
</tbody>
</table>
<?php } // end Occ Projections ?>

<br/><br/>
<div class="reportSection">
<span class="sectionTitle">Industry Estimates</span>
<br/><br/>
<?php if (count($indest) == 0) echo "<br/>No Industry employment estimates association with this occupation.";
      else {
$heading = "";
?>
<table  class="ind" border="1" cellpadding="5" cellspacing="0">
<tbody>
<?php  foreach ($indest as $value) { 
	 if (strlen($heading) == '') {
	 	$heading ='<tr><th>Industry</th><th>' . $value['estyear'] . ' Employment</th></tr>';
	 	echo $heading; 
	    } 
     $cssf = new OccLevel();
     echo '<tr><td ' . $cssf->getCssClass($value['matincode']) . ' >' . ucwords(strtolower($value['matintitle'])) . ' (' . $value['matincode'] . ')</td>';
     echo '<td class="dcell">' . $value['emp']   .   '</td></tr>';
      }        ?>
</tbody>
</table>
<?php } // end Industry Estimates ?>


