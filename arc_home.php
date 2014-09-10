<div class="quickstats">
<br/>
<div class="quickstatsheader"><strong>Quick Stats</strong></div>
<br/>
<?php
require_once('includes/quick_stats.php');
$ms = new MapSeries();

?>
<img src="http://chart.apis.google.com/chart?chxt=x,y&chxl=0:|2002|2003|2004|2005|2006|2007|2008|2009|1:|0|4|8|12|16&&chco=00aaaa,ff0000,3072F3&cht=lc&chdl=Oregon|US&chd=t:<?php echo $ms->getMapSeries("2002", "2009", "41", "01", "'00'", 16, "DEL"); ?>|<?php echo $ms->getMapSeries("2002", "2009", "00", "01", "'00'", 16, "DEL"); ?>&chls=2.0&chs=450x200&chm=s,000000,0,-1,5|s,000000,1,-1,5&chg=10,25&chf=bg,s,eeeeff&chtt=Unemployment History (Not Seasonally Adjusted)" />
<br/><br/>
<?php require_once('includes/labforce.php'); ?>
<br/><br/>
<?php require_once('includes/cpi.php'); ?>
<br/><br/>
<?php require_once('includes/blding_include.php'); ?>
</div>
