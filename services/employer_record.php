<?php

require_once('../data/employer_data.php');


// Create parameterized query for empdb table
$parms = get_params(array('uniqueid'=>'41', 'printme'=>'n') );

$empdao = new EmployerDAO();
header('Content-type: text/html');
$emprec = $empdao->getEmployerRecord($parms['uniqueid']);
 if ($parms['printme'] == 'y') { ?>

<html>
<head>
     <link type="text/css" href="layout.css" rel="stylesheet" />
</head>
<body>
<div class="wrap" style="width: 60%">
<h2>InfoGroup Employer Database</h2>  
<?php } 
 foreach ($emprec as $row)  { ?>  

<div>
  <strong><?php echo ucwords(strtolower($row['name'])) ?></strong><br/>
  <?php echo htmlspecialchars(ucwords(strtolower($row['addressp']))) ?><br/>
  <?php echo htmlspecialchars(ucwords(strtolower($row['cityp']))) ?>,  <?php echo htmlspecialchars(ucwords(strtolower($row['statep']))) . ' ' . htmlspecialchars(ucwords(strtolower($row['zipcodep']))) ?><br/>
 <strong>Phone: </strong><?php echo formatPhonenum($row['telenum']) ?><br/>
 <strong>Contact: </strong><?php echo htmlspecialchars(ucwords(strtolower($row['cntctfname']))) ?> <?php echo htmlspecialchars(ucwords(strtolower($row['cntctlname']))) ?><br/>
 <strong>Web Site: </strong><a href="http://<?php echo htmlspecialchars(ucwords(strtolower($row['weburl']))) ?>"><?php echo htmlspecialchars(ucwords(strtolower($row['weburl']))) ?></a><br/><br/>
 <strong>Business Description: </strong><?php echo htmlspecialchars(ucwords(strtolower($row['busdesc']))) ?><br/>
 <strong>Standard Industry Code (SIC):</strong> <?php echo htmlspecialchars(ucwords(strtolower($row['primarysic']))) ?><br/> 
 <strong>North American Industry Code (NAICS):</strong>  <?php echo htmlspecialchars(ucwords(strtolower($row['primnaics']))) ?><br/><br/>
 <strong>Employer Size:</strong> <?php echo htmlspecialchars(ucwords(strtolower($row['emprngdesc']))) ?><br/><br/>
 <strong>Annual Sales:</strong> <?php echo ucwords(strtolower($row['salrngdesc'])) ?><br/><br/>
 <strong>Year Established: </strong><?php echo htmlspecialchars(ucwords(strtolower($row['yearest']))) ?><br/><br/>
 <strong>Stockticker: </strong><?php echo htmlspecialchars(ucwords(strtolower($row['stockticker']))) ?><br/><br/>
 <?php if ($parms['printme'] != 'y') { ?><a href="employer_record.php?printme=y&amp;uniqueid=<?php echo $row['uniqueid'] ?>" target="top">Print</a><?php } ?>
</div>
<?php  } 
  if ($parms['printme'] == 'y') { ?>

<p style="width: 600px"><a href="http://www.infousagov.com/"><img src="/ows-img/olmtest/infousa.gif" alt="InfoGroup"/></a>
    This database contains listings of nearly 12 million U.S. employers.  
   The employer information is provided by infoUSA., Omaha, NE, 800/555-5211. Copyright 2009.  
   All Rights Reserved. Send requests for changes and additions to infoUSA by e-mailing 
   <a href="mailto:employer.database@infoUSA.com">employer.database@infoUSA.com</a> 
   or calling 1-800-555-5211 (ask for the Government Division).
</p>
</div>
</body>
</html>
<?php } ?> 