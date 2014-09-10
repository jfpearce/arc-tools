<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Analyst Resource Center Data Delivery Tools</title>
<link href="css/layout.css" rel="stylesheet" type="text/css"  media="all" />
<link href="css/template_css.css" rel="stylesheet" type="text/css"  media="all" />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/arc_util.js" type="text/javascript"></script>
</head>
<body id="body_bg">
<div align="center">

	<div id="wrapper" align="center"> <!-- start: div#wrapper -->
	
		<!-- start: topmenu -->
		<div id="top">
						<div id="topmenu"><table><tr>
                                              <td><a href="index.php">Home</a></td>
                                              <td><a href="index.php?item=001">Occupations</a></td>
                                              <td><a href="index.php?item=002">Industries</a></td>
                                              <td><a href="labforce_app.php">Unemployment</a></td>
                                              <td><a href="index.php?item=004">Census Labor</a><td>
                                              <td><a href="index.php?item=005">Population</a></td>
                                              <td><a href="index.php?item=007">Income</a></td>
                                               <td><a href="employers.php">Employers</a></td>
                                               </tr></table> </div>

			 <!-- end: topmenu -->
			<div id="feed"><a href="#"></a></div>
			<div class="clearfix"></div>
		</div>
		<!-- end: topmenu -->
		
		
		<!-- start: header -->
		      <div class="header_bg" style="text-align: left">  
                        <span ><img src="images/wid.jpg" style="vertical-align: middle" />
                        <span style="font-size: 25px; color: #000000"> <strong>Analyst Resource Center</strong></span>
                        <span style="font-size: 20px; color: #ff0000"> Data Delivery Tools</span></span>
                        </div>
		<!-- end: header -->
		
		<!-- start: pathawy 

		<div id="pw">
			<div id="pathway"><span class="pathway"><a href="http://www.almisdb.org" class="pathway">Analyst Resource Center (ARC) Home</a></div>

			<div id="date"><?php echo date("l, j F, Y"); ?></div>
			<div class="clearfix"></div>
		</div>
		   end: pathway -->
<hr/>		
<!-- start: maincontent -->
<div id="maincontent">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>

			  	                <td width="200px" valign="top" class="leftblock">
					<div id="left">
							<!--	<div class="moduletable">
							<h3>
					Search Our Site...				</h3>
				
<form action="index.php?option=com_search" method="get">
	<div class="search">
		<input name="searchword" id="mod_search_searchword" maxlength="20" alt="search" class="inputbox" type="text" size="20" value="search..."  onblur="if(this.value=='') this.value='search...';" onfocus="if(this.value=='search...') this.value='';" />	</div>

	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="" />	
</form>
</div>  -->

		
<br/>
<br/>				
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="index.php?item=001">Occupations</a></li>
<li><a href="index.php?item=002">Industries</a></li>
<li><a href="index.php?item=003">Unemployment</a></li>
<li><a href="index.php?item=004">Census Labor</a>
<li><a href="index.php?item=005">Population</a></li>
<li><a href="index.php?item=007">Income</a></li>
<li><a href="index.php?item=006">Employers</a></li>
</ul>


</div>			

</td>
<!-- end: left block -->
<!-- start: content-->
    <td valign="top" class="content">
	<div id="mainbody">

        <?php require_once('data/wfutils.php');

            $parms = get_params(array('itemid'=>'000', 'printme'=>'n') );
        
       
            if     ($parms['item'] == '001') {
                    require_once('occinfo_home.php');
                    } 
           else if ($parms['item'] == '002') {
                    require_once('indinfo_home.php');
                   }
           else if ($parms['item'] == '003') {
                    require_once('unemp_home.php');
                   }
           else if ($parms['item'] == '004') {
                    require_once('cenlabor_home.php');
                   }
           else if ($parms['item'] == '005') {
                    require_once('population_home.php');
                   }
           else if ($parms['item'] == '007') {
                    require_once('income_home.php');
                   }
           else if ($parms['item'] == '006') {
                    require_once('employerlist_home.php');
                   }   
          else    {
                   require_once('arc_home.php');
                  }
       ?>

										
	</div><!-- end: mainbody -->

   
	</td>

      <td width="239px" valign="top" class="rightblock">

		<div id="right">
			
          



	
               </div>

     </td>
</tr>
          </table>
		</div>
		<!-- end: maincontent -->

               

		
		<!-- start: bottom_users -->

				
		<!-- end: bottom_users -->
		
		<!-- start: footer -->
		<div id="footer">
			<div class="copyright">Analyst Resource Center </div>
		</div>

		<!-- end: footer -->
		
	</div> <!-- end: div#wrapper -->

</div>
</body>
</html>