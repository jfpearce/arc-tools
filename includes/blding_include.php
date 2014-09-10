<?php
require_once('quick_stats.php');
$stats = new BldingDAO();
// $wages = $stats->getPermits(ARConfig::stfips);
$wages = $stats->getPermits("66"); // Guam
if (count($wages) == 0) ;
      else { 
           $y_is_set = "n"; ?>
      <p>
      <table border="0" cellspacing="0" width="441">
      <tbody>
   <!--   <tr><th colspan="3" align="center" valign="top" height="20"><span class="quickstatsheader"><?php echo ARConfig::stname; ?> Building Permits</span></th></tr> -->
   <tr><th colspan="3" align="center" valign="top" height="20"><span class="quickstatsheader">Guam Building Permits</span></th></tr>
      <?php foreach ($wages as $value) {
      	       if ($y_is_set == 'n') {
      	       	  echo '<tr><th colspan="3" align="center">(' . $value['periodyear'] . ')<th></tr>';
      	       	  echo ' <tr><th>Permit Type</th><th class="dcell">Units</th><th class="dcell">Cost</th></tr>';
      	       	  $y_is_set = "y";
      	          }
               echo '<tr><td>' . $value['typedesc'] . '</td><td class="dcell">' .	$value['units'] . '</td><td class="dcell">$' . $value['unitcost'] . '</td></tr>';
               } ?>
      </tbody>
      </table>
      </p>
<?php     }?>