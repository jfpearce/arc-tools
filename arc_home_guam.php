<div class="quickstats">
<br/>
<div class="quickstatsheader"><strong>Quick Stats</strong></div>
<br/>
<?php
require_once('includes/quick_stats.php');
$ms = new MapSeries();

?>
<img src="http://chart.apis.google.com/chart?chxt=x,y&chxl=0:|1997|1998|1999|2000|2001|2002|2003|2004|1:|0|4|8|12|16&&chco=00aaaa,ff0000,3072F3&cht=lc&chdl=Guam|US&chd=t:<?php echo $ms->getMapSeries("1997", "2004", "66", "02", "'01'", 16, "DEL"); ?>|<?php echo $ms->getMapSeries("1997", "2004", "00", "01", "'00'", 16, "DEL"); ?>&chls=2.0&chs=450x200&chm=s,000000,0,-1,5|s,000000,1,-1,5&chg=10,25&chf=bg,s,eeeeff&chtt=Unemployment Rates (Not Seasonally Adjusted)" />
<br/><br/>
<?php require_once('includes/labforce.php'); ?>
<br/><br/>
<?php require_once('includes/cpi.php'); ?>
<br/><br/>
<?php require_once('includes/blding_include.php'); ?>
</div>
