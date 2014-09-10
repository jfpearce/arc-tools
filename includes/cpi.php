<?php
require_once('quick_stats.php');

$cpi = new CpiDAO();
$stats = $cpi->getCpiRates();
?>
<table border="0" cellspacing="0" width="441">
<tr><th valign="top" align="center" colspan="4" height="40">
<span class="quickstatsheader">US Consumer Price Index</span>
<th/>
</tr>
<tr>
<td class="dcell"><?php echo $cpi->getThisYearMonth() ?></td>
<td class="dcell"><?php echo $cpi->getLastMonth() ?></td>
<td class="dcell"><?php echo $cpi->getLastYearMonth() ?></td></tr>
<tr>
<td class="dcell"><?php echo $stats[0]['cpi'] ?></td>
<td class="dcell"><?php echo $stats[1]['cpi'] ?></td>
<td class="dcell"><?php echo $stats[2]['cpi'] ?></td>
</tr>
</table>