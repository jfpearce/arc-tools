<table border="0" cellspacing="0" width="441">
<tr><th valign="top" align="center" colspan="9" height="40"><span class="quickstatsheader">Unemployment Rates</span><br/>
<span class="small">Not Seasonally Adjusted</span></th></tr>
<tr><td></td>
<?php
   require_once('quick_stats.php');
   $stats = new MapSeries();
   $guam = $stats->getMapSeries("1997", "2004", "66", "02", "'01'", 16, "LIST");
   $us = $stats->getMapSeries("1997", "2004", "00", "01", "'00'", 16, "LIST"); 
   foreach ($us as $value) { 
           echo '<td class="dcell">' . $value['periodyear'] . '</td>';
          }
   echo '</tr><tr><td align="left"><strong>Guam (1st Qtr)</strong></td>';
   foreach ($guam as $value) { 
           echo '<td class="dcell">' . $value['unemprate'] . '</td>';
          }
   echo '</tr><tr><td align="left"><strong>US (Annual)</strong></td>';
   foreach ($us as $value) { 
           echo '<td class="dcell">' . $value['unemprate'] . '</td>';
          }
?>
</tr>
</table>
