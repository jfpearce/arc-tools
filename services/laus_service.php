<?php
require_once('../data/wfutils.php');

$link = getDatabaseConnection();
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'adjusted'=>'1'));

// Create parameterized query for labforce table
$query = sprintf("SELECT * FROM wid.labforce WHERE stfips='%s' and areatype='%s' and area='%s' and adjusted='%s' order by periodyear, periodtype, period, prelim",
                  mysql_real_escape_string($parms['stfips']),
                   mysql_real_escape_string($parms['areatype']),
                   mysql_real_escape_string($parms['area']),
                  mysql_real_escape_string($parms['adjusted']));


// Perform Query
$result = mysql_query($query, $link);

// Check result and report any errors
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

// Put results in XML document
header('Content-type: text/xml');
echo "<?xml version='1.0' standalone='yes'?>"; 
echo "<labforcelist>";
while ($row = mysql_fetch_assoc($result)) {
?>
  <labforce  stfips="<?php echo htmlspecialchars($row['stfips']); ?>"
             areatype="<?php echo htmlspecialchars($row['areatype']); ?>"
             area="<?php echo htmlspecialchars($row['area']); ?>"
             periodyear="<?php echo htmlspecialchars($row['periodyear']); ?>"
	     periodtype="<?php echo htmlspecialchars($row['periodtype']); ?>"
             period="<?php echo htmlspecialchars($row['period']); ?>"
	     adjusted="<?php echo htmlspecialchars($row['adjusted']); ?>"
             prelim="<?php echo htmlspecialchars($row['prelim']); ?>"
	     benchmark="<?php echo htmlspecialchars($row['benchmark']); ?>"
             laborforce="<?php echo htmlspecialchars($row['laborforce']); ?>"
	     emplab="<?php echo htmlspecialchars($row['emplab']); ?>"
	     unemp="<?php echo htmlspecialchars($row['unemp']); ?>"
	     unemprate="<?php echo htmlspecialchars($row['unemprate']); ?>"
             fmt_laborforce="<?php echo htmlspecialchars(number_format($row['laborforce'], 0, '.', ',')); ?>"
	     fmt_emplab="<?php echo htmlspecialchars(number_format($row['emplab'], 0, '.', ',')); ?>"
	     fmt_unemp="<?php echo htmlspecialchars(number_format($row['unemp'], 0, '.', ',')); ?>"
	        />
<?php
}

// Free the resources associated with the result set
mysql_free_result($result);
mysql_close($link);

?>
</labforcelist>
