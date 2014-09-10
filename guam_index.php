<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to the Guahan Department of Labor/AHRD Site - Employment, Appeals Process</title>
<meta name="description" content="guam department of labor, guam jobs, guam wia, maria connelley, guam bls, guam osha, guam workers compensation, guam employment service, guam wage and hour, guam bureau of labor statistics, Guam Division of Vocational Rehabilitation, Guam Department of Labor" />
<meta name="keywords" content="guam department of labor, guam jobs, guam wia, maria connelleyguam department of labor, guam jobs, guam wia, maria connelley, guam bls, guam osha, guam workers compensation, guam employment service, guam wage and hour, guam bureau of labor statistics, Guam Division of Vocational Rehabilitation, Guam Department of Labor" />
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="http://guamdol.net/images/favicon.ico" />
<link rel="shortcut icon" href="http://guamdol.net/templates/gdol/favicon.ico" />
<link href="css/template_css.css" rel="stylesheet" type="text/css"  media="all" />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/arc_util.js" type="text/javascript"></script>
</head>
<body id="body_bg">
<div align="center">

	<div id="wrapper" align="center"> <!-- start: div#wrapper -->
	
		<!-- start: topmenu -->
		<div id="top">
						<div id="topmenu"><table width="100%" border="0" cellpadding="0" cellspacing="1"><tr><td nowrap="nowrap"><a href="http://guamdol.net/component/option,com_frontpage/Itemid,295/" class="mainlevel" >Home</a><a href="http://guamdol.net/component/option,com_weblinks/catid,67/Itemid,304/" class="mainlevel" >Employment Resources</a><a href="http://guamdol.net/content/view/119/185/" class="mainlevel" >O*NET OnLine</a><a href="http://www.doleta.gov/" class="mainlevel" >U.S. DOL ETA</a><a href="http://guamdol.net/component/option,com_jobline/Itemid,298/" class="mainlevel" >GDOL Job Bank</a><a href="http://www.guam.gov" class="mainlevel" >Guam.Gov</a><a href="http://webmail.dol.guam.gov" class="mainlevel" >GDOL Web Mail</a><a href="http://guamdol.net/content/section/27/428/" class="mainlevel" >Provider's Corner</a></td></tr></table></div>

			 <!-- end: topmenu -->
			<div id="feed"><a href="#"></a></div>
			<div class="clearfix"></div>
		</div>
		<!-- end: topmenu -->
		
		
		<!-- start: header -->
		      <div class="header_bg">  
                        <span style="font-size: 35px; color: #f7f7c7">Guam Labor Market Information</span><br/>
                        <span style="font-size: 20px ; color: #fafa55" >Latest Facts and Figures about the Workforce and Economy.</span>
		       </div>
		<!-- end: header -->
		
		<!-- start: pathawy -->

		<div id="pw">
			<div id="pathway"><span class="pathway"><a href="http://guamdol.net/" class="pathway">Guam DOL Home</a></div>

			<div id="date"><?php echo date("l, j F, Y"); ?></div>
			<div class="clearfix"></div>
		</div>
		<!-- end: pathway -->
		
<!-- start: maincontent -->
<div id="maincontent">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>

			  	                <td width="200px" valign="top" class="leftblock">
					<div id="left">
								<div class="moduletable">
							<h3>
					Search Our Site...				</h3>
				
<form action="index.php?option=com_search" method="get">
	<div class="search">
		<input name="searchword" id="mod_search_searchword" maxlength="20" alt="search" class="inputbox" type="text" size="20" value="search..."  onblur="if(this.value=='') this.value='search...';" onfocus="if(this.value=='search...') this.value='';" />	</div>

	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="" />	
</form>
</div> 

		
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
			

                         <div class="moduletable">
			<table cellpadding="0" cellspacing="0" class="moduletable">
                       <tr>
	                    <td>
		              <strong><a href="http://www.bls.gov/ces/" target="_blank">
                             Current Employment Statistics Latest Numbers</a></strong>
	                     </td>
                       </tr>
                        <tr>
	                <td>Latest Numbers for Current Employment Statistics, U.S. Bureau of Labor Statistics</td>
                        </tr>
                         <tr>
	                  <td>
		              <ul class="newsfeed">
                            <li class="newsfeed">

	                        <strong>
                              <a href="http://www.bls.gov/ces/" target="_blank">
                                 Current Employment Statistics Latest Numbers</a>
	                         </strong>
                                    <div>
         
                                 <p>Change in Total Nonfarm Payroll Employment:<br><strong><span title="Number of jobs, 1-month net change, seasonally adjusted" class="data">+290,000(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES0000000001&amp;output_view=net_1mth">Historical Data</a></p><p>Change in Total Private Average Hourly Earnings for All Employees:<br><strong><span title="average hourly earnings For All Employees on private payrolls, 1-month net change, seasonally adjusted" class="data">+$0.01(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES0500000003&amp;output_view=net_1mth">Historical Data</a></p><p>Change in Total Private Average Weekly Hours for All Employees:<br><strong><span title="average weekly hours for All Employees, 1-month net change, seasonally adjusted" class="data">+0.1(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES0500000002&amp;output_view=net_1mth">Historical Data</a></p><p>Percent change in Total Private Aggregate Weekly Hours for All Employees:<br><strong><span title="indexes of aggregate weekly hours for All Employees, 1-month net change, seasonally adjusted" class="data">+0.4%(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES0500000016&amp;output_view=pct_1mth">Historical Data</a></p><p>Change in Manufacturing Average Weekly Hours for All Employees:<br><strong><span title="average weekly hours for All Employees in manufacturing, 1-month net change, seasonally adjusted" class="data">+0.2(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES3000000002&amp;output_view=net_1mth">Historical Data</a></p><p>Change in Manufacturing Average Weekly Overtime for All Employees:<br> <strong><span title="average weekly overtime hours for All Employees in manufacturing, 1-month net change, seasonally adjusted" class="data">+0.1(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES3000000004&amp;output_view=net_1mth">Historical Data</a></p><p>Change in Total Private Real Average Hourly Earnings for All Employees:<br><strong><span title="average hourly earnings for All Employees, 1982 dollars, Total private, 1-month net change, seasonally adjusted" class="data">+$0.01(p)  in Apr 2010</span></strong><br><a href="http://data.bls.gov/servlet/SurveyOutputServlet?data_tool=latest_numbers&amp;series_id=CES0500000013&amp;output_view=net_1mth">Historical Data</a></p><p><strong>p</strong>- preliminary</p>						</div>

               </li>
                  </ul>
	            </td>
                   </tr>
</table>
		</div>



   <div class="moduletable">
			<h3>GDOL Online Job Bank</h3>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
                                codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
                                 width="200" height="200" id="jobs" align="">
                         <param name=movie value="http://guamdol.net/jobs.swf"><param name=quality value=high>
                         <embed src="http://guamdol.net/jobs.swf" quality=high  width="200" height="200" name="jobs" align=""
                                         type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
                         </embed></object>
                         </div>






                        



	
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
			<div class="copyright">Guam Department of Labor/AHRD </div>
		</div>

		<!-- end: footer -->
		
	</div> <!-- end: div#wrapper -->

</div>
</body>
</html>