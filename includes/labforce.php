<?php
   require_once('quick_stats.php');
 $stats = new QuickStats(ARConfig::stname, ARConfig::stfips);
?>
<table border="0" cellspacing="0" width="441">
<tr><th valign="top" colspan="4" height="40"><span class="quickstatsheader">Current Unemployment Rates</span><br/>
<span class="small">Seasonally Adjusted</span></th></tr>
<tr><td></td>
<td class="dcell"><?php echo $stats->getThisYearMonth() ?></td>
<td class="dcell"><?php echo $stats->getLastMonth() ?></td>
<td class="dcell"><?php echo $stats->getLastYearMonth() ?></td></tr>
<tr><td align="left"><strong><?php echo $stats->getStateName() ?></strong></td>
<td class="dcell"><?php echo $stats->getRate('41M1') ?>%</td>
<td class="dcell"><?php echo $stats->getRate('41M2') ?>%</td>
<td class="dcell"><?php echo $stats->getRate('41M3') ?>%</td></tr>
<tr><td align="left"><strong>United States</strong></td>
<td class="dcell"><?php echo $stats->getRate('00M1') ?>%</td>
<td class="dcell"><?php echo $stats->getRate('00M2') ?>%</td>
<td class="dcell"><?php echo $stats->getRate('00M3') ?>%</td></tr>
</tr>
</table>