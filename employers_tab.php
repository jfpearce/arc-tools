<html>
  <head>
     <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
     <link href="css/layout.css" type="text/css"  rel="stylesheet" /> 
     <link href="jquery-ui-1.8.2/themes/base/jquery.ui.core.css" rel="stylesheet" type="text/css" media="screen"  />
     <link href="jquery-ui-1.8.2/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" media="screen"  />
     <link href="jquery-ui-1.8.2/themes/base/jquery.ui.button.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="jquery-ui-1.8.2/themes/base/jquery.ui.accordion.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="jquery-ui-1.8.2/themes/base/jquery.ui.tabs.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="jquery-ui-1.8.2/themes/base/jquery.ui.dialog.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="jqgrid-3.7.1/css/ui.jqgrid.css" type="text/css" rel="stylesheet" /> 
     <script src="jquery-ui-1.8.2/js/jquery-1.4.2.min.js" type="text/javascript"></script> 
     <script src="jquery-ui-1.8.2/ui/jquery.ui.core.js" type="text/javascript"></script>
     <script src="jquery-ui-1.8.2/ui/jquery.ui.widget.js" type="text/javascript"></script>
     <script src="jquery-ui-1.8.2/ui/jquery.ui.button.js" type="text/javascript"></script>
     <script src="jquery-ui-1.8.2/ui/jquery.ui.accordion.js" type="text/javascript"></script>
      <script src="jquery-ui-1.8.2/ui/jquery.ui.tabs.js" type="text/javascript"></script>
    <script src="jquery-ui-1.8.2/ui/jquery.ui.dialog.js" type="text/javascript"></script>
     <script src="jqgrid-3.7.1/js/i18n/grid.locale-en.js" type="text/javascript"></script>
     <script src="jqgrid-3.7.1/js/jquery.jqGrid.min.js" type="text/javascript"></script> 
     <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
     <script src="js/employer_map.js"></script>
  </head>
<body>
<div class="wrap" style="width: 700px">
<?php require_once('includes/page_header.php'); ?>
<form name="locateform" onsubmit="return false" method="get" >
  
<h2>InfoGroup Employer Database &nbsp; &nbsp; <a style="font-size: 11px" href="index.php">Return to Home</a></h2>
<a href="employers.php" ><img src="images/goback.gif" alt="Start from the beginning" width="20" height="20" /></a> &nbsp;
<a href="employers.php" alt="Start from the beginning" >Start Over</a> &nbsp;


<div id="showemployers">
<p style="width: 600px">Use the following options to define your search for employers. Your
 search must include either an employer name, industry or occupation.  
</p>
<div id="thetabs" style="width: 600px">
<ul>
  <li><a href="#fragment-1"><span>Geography</span></a></li>
  <li><a href="#fragment-2"><span>Employers</span></a></li>
 <li><a href="#fragment-3"><span>Other</span></a></li>
  <li><a href="#fragment-4"><span>Review</span></a></li>
</ul>





<div id="fragment-1">
<span style="text-align: right"><input class="sbutn" type="submit"  value="Continue&gt;" onclick="$('#thetabs').tabs('select', 1); return false" /></span>
<br/><br/>
<div id="geo_options">
<h3><a href="#"><span>Search by County or Region</span></a></h3>
<div id="geoselect">
    Select a state:<br/><select id="stfips">
              <option value="41" selected="selected">Oregon</option>
              <option value="53">Washington</option>
              <option value="16">Idaho</option>
              <option value="06">California</option>
              <option value="32">Nevada</option>
         </select>
     <br/><br> 

 
 Select a <br/> <span id="areatype_choose">
                              <select id="areatype">
                              <option value="04" selected="selected">county</option>
                              <option value="05">workforce region</option>
                              </select>
                              </span>:<br/> 
 <select id="areacode" size="6"><option value="4101000000">Statewide</option></select>
 <br/><br/>
 
 Zipcode: <input type="text" id="thezip" name="zipcode" value="" maxlength="5" size="5"  />

</div>
<h3><a href="#"><span>Search by Address</span></a></h3>
<div id="nearestselect">
Street address:<br/>
<input type="text" id="c_address" name="cp_address" value="" maxlength="120" size="40"  />
<br/><br/> 
Find employers
<select id="miles">
     <option value=".5">1/2 Mile</option>
     <option value="1" selected="selected">1 Mile</option>
     <option value="5">5 Miles</option>
     <option value="10">10 Miles</option>
     <option value="15">15 Miles</option>
     <option value="20">20 Miles</option>
     <option value="50">50 Miles</option>
     <option value="100">100 Miles</option>
</select>
from address.
</div>
</div>
<div id="fragment-2">
       Search by:<br/>
       <div id="r">
      <input type="radio" id="r1" name="indradx" value="0" checked="checked" /><label for="r1">Industry type<label/>
      <input type="radio" id="r2" name="indradx" value="1"   /><label for="r2">Industry Name<label/>
      <input type="radio" id="r3" name="indradx" value="2"   /><label for="r3">Occupation<label/>
      </div>
      </br/>

      <div id="indocc" style="display: none">
  
      <span class="stitle">Enter an occupation name or keyword: <br/>
       <input type="text"  name="socsearch" value="" maxlength="60"  size="40" />
       <input class="sbutn" type="submit" name="key1" value="Go" onclick="getSearchSoc(this.form); return false" />
       <input class="sbutn" type="submit" name="keyr" value="Reset" onclick="resetSearchSoc(this.form); return false" />
      </span>  

      <br/><br/>
      <span class="stitle">Find an occupation by clicking through the drill down hierarchy:</span> 
      <div id="occdrill" style="border: #000 1px solid; padding: 2px; width: 500px; height: 80px; overflow:  scroll">
      </div>
       <div id="selocc"></div>
       <div id="indlist"></div>

    </div>

   <span id="indkey" style="display: none">Keyword Search: <br/> <input type="text" name="searchind" value="" maxlength="80" size="40"  />
   <input class="sbutn" type="submit" name="key" value="Go" onclick="getIndustries(this.form) ; return false" />  
   <input class="sbutn" type="submit" name="keyr" value="Reset" onclick="resetIndustries(this.form); return false" /> </span> 
       
  
   <span id="inddrill">
   Select the type of industry you want:<br/>

   <select name="sector"  onchange="this.form.searchind.value = '' ; getIndustries(this.form)">
    <option value="00">00 - All Industries</option>
    <option value="11">11 - Agriculture, Forestry, Fishing & Hunting</option>
    <option value="21">21 - Mining</option>
	<option value="22">22 - Utilities</option>
	<option value="23">23 - Construction</option>
        <option value="31">31 - Manufacturing</option> 
	<option value="42">42 - Wholesale Trade</option>
	<option value="44">44 - Retail Trade</option> 
	<option value="48">48 - Transportation and Warehousing</option> 
	<option value="51">51 - Information</option>
	<option value="52">52 - Finance and Insurance</option>
	<option value="53">53 - Real Estate and Rental and Leasing</option>
        <option value="54">54 - Professiona.l Scientific & Technical Svc</option>
	<option value="55">55 - Management of Companies and Enterprises</option>
	<option value="56">56 - Admin., Support, Waste Mgmt, Remediation</option>
	<option value="61">61 - Education Services</option>
	<option value="62">62 - Health Care and Social Assistance</option>
	<option value="71">71 - Arts, Entertainment, and Recreation</option>
        <option value="72">72 - Accommodation and Food Services</option>
	<option value="81">81 - Other Services (except Public Admin.)</option>
	<option value="92">92 - Public Administration</option>
	<option value="99">99 - Unclassified establishments</option>
    </select>
    </span>

    <br/><br/>
    Select industry or click next to search by employer name:<br/>
    <select id="indcode"><option value="000000" selected="selected">All Industries</option></select>
   </p>
<br/>
<input class="sbutn" type="submit"  value="&lt;Back" onclick="$('#thetabs').accordion('activate', 0) ; return false" />
<input class="sbutn" type="submit"  value="Next&gt;" onclick="$('#thetabs').accordion('activate', 2); return false" />
<span id="showeid1"><input class="sbutn" type="submit" value="Find Employers" onclick="processReq(this.form) ; return false" /></span></div>
<div id="fragment-3">
 Search for employers by name keyword:<br/>
  <input type="text" id="thesearch" name="search" value="" onKeyPress="checkEnter(event, this.form)" maxlength="80" size="40"  />
<br/><br/>
<input class="sbutn" type="submit"  value="&lt;Back" onclick="$('#thetabs').accordion('activate', 1) ; return false" />
<input class="sbutn" type="submit"  value="Next&gt;" onclick="$('#thetabs').accordion('activate', 3); return false" />
<span id="showeid2"><input class="sbutn" type="submit" value="Find Employers" onclick="processReq(this.form) ; return false" /></span></div>
<div id="fragment-4">
     Select employers by number of employees:<br/> 
     <select id="sizeclass" >
     <option value="9">All Employers</option>
     <option value="A">1 to 4 employees</option>
     <option value="B">5 to 9 employees</option>
     <option value="C">10 to 19 employees</option>
     <option value="D">20 to 49 employees</option>
     <option value="E">50 to 99 employees</option>
     <option value="F">100 to 249 employees</option>
     <option value="G">250 to 499 employees</option>
     <option value="H">500 to 999 employees</option>
     <option value="I">1000 or more employees</option>
     </select>
     <br/><br/>
    
    Select employers by annual sales:<br/> 
    <select id="annsalrng">
    <option value="X" >All Employers</option>
    <option value="A" >Less than 500K</option>
	<option value="B" >500K &lt; 1 Million</option>
	<option value="C" >1 Million &lt; 2.5 Million</option>
	<option value="D" >2.5 Million &lt; 5 Million</option>
	<option value="E" >5 Million &lt; 10 Million</option>
	<option value="F" >10 Million &lt; 20 Million</option>
	<option value="G" >20 Million &lt; 50 Million</option>
	<option value="H" >50 Million &lt; 100 Million</option>
	<option value="I">100 Million &lt; 500 Million</option>
	<option value="J" >500 Million &lt; 1 Billion</option>
	<option value="K" >Greater than 1 Billion</option>
	</select>
<br/><br/>
<input class="sbutn" type="submit"  value="&lt;Back" onclick="$('#thetabs').accordion('activate', 2); return false" />
<span id="showeid3"><input class="sbutn" type="submit" value="Find Employers" onclick="processReq(this.form) ; return false" /></span>
</div>
</div>
<br/>
</div>

<br/><br/>
<span id="showrecord" style="display: none">
<span style="font-size: 16px">Click on a record to display detail employer information.</span>
<input class="sbutn" type="submit" value="Refine Search" onclick="refineSearch(); return false" /> &nbsp;
<input class="sbutn" type="submit" value="Map the Data" onclick="makeMap(); return false" />
</span>
</form>
<div id="errmsg"></div>
<div id="message"></div><br/>
<div id="map_message" style="display: none"><strong>Drag the marker to change the center point and see a different employer list.</strong></div>
<div id="map_print" style="display: none"></div>
<div id="map_canvas" style="display: none"></div>
<table id="list" class="scroll"></table> 
<div id="pager" class="scroll" style="text-align:center;"></div>
<br/>
<p style="width: 600px">Information and data in the Employer Database tool is not gathered or developed by the 
Oregon Employment Department. The source of this information is the national InfoGroup database. The  Employer Database is licensed 
only for career exploration,job search assistance, and related One-Stop Career Center services.</p>
<p style="width: 600px"><a href="http://www.infousagov.com/"><img src="images/infogroup_logo.gif" alt="Infogroup"/></a>
This database contains listings of nearly 12 million U.S. employers.  
The employer information is provided by Infogroup, Omaha, NE, 800/555-5211. Copyright 2009.  
All Rights Reserved. Send requests for changes and additions to Infogroup by e-mailing 
<a href="mailto:employer.database@infoUSA.com">employer.database@infoUSA.com</a> 
or calling 1-800-555-5211 (ask for the Government Division).
</p>
<div id="erecord" style="display: none" title="Employer Detail"></div>
<div id="footer">
	  <div id="oed"><a href="http://www.emp.state.or.us">Oregon Employment Department</a></div>
	  <div id="links">
	  <a href="http://www.worksourceoregon.org">WorkSource Oregon</a> - 
 	  <a href="http://www.oregon.gov">Oregon.gov</a> - 
	  <a href="http://findit.emp.state.or.us/privacy-ada-eoe.cfm">Privacy / Accessibility</a> - 
	  <a href="http://www.oregon.gov/PRISM/">PRISM</a> - 
	  <a href="DoQuery?itemid=00004804">Need Help?</a>
	  </div>
</div>

</div>
<script type="text/javascript">
    //<![CDATA[


  var previous_links = new Array();

  var map_state = "";
  
  $("#rg1").click( function(){ 
      $('#showeid1').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Find Employers" onclick="processReq(this.form) ; return false" />');
      $('#showeid2').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Find Employers" onclick="processReq(this.form) ; return false" />');
      $('#showeid3').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Find Employers" onclick="processReq(this.form) ; return false" />');
      $('#geoselect').show();
      $('#nearestselect').hide();
      
  });

  $("#rg2").click( function(){ 
      $('#showeid1').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Find Employers" onclick="makeNearestMap() ; return false" />');
      $('#showeid2').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Find Employers" onclick="makeNearestMap() ; return false" />');
      $('#showeid3').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Find Employers" onclick="makeNearestMap() ; return false" />');
      $('#geoselect').hide();
      $('#nearestselect').show();
   });
  
  
   function checkEnter(e, f) {
     if (e.keyCode == 13) {
         processReq(f);
         return false;
         }
  }

  function refineSearch() {
     $('#showemployers').show('slow') ;
   }


   function getEmpdbNearestData(f, latitude, longitude) { 
            var areacode = f.areacode.value;
            var stfips = areacode.substring(0,2);
            var areatype = areacode.substring(2,4);
            var area = areacode.substring(4,10);
            var search = f.search.value;
            if   (search.length < 3) search = '';
            else search = search.replace('&', '%26');
           return "services/employer_nearest_service.php?miles=" + f.miles.value + "&latitude=" + latitude + "&longitude=" + longitude + 
                          "&naicscode=" + f.indcode.value + "&sizeclass=" + f.sizeclass.value + "&annsalrng=" + f.annsalrng.value + "&search=" + search;
             
   }


   function getEmpdbData(f) { 
            var areacode = f.areacode.value;
            var stfips = areacode.substring(0,2);
            var areatype = areacode.substring(2,4);
            var area = areacode.substring(4,10);
            var search = f.search.value;
            if    (search.length < 3) search = '';
            else   search = search.replace('&', '%26');
            return "services/employer_service.php?stfips=" + stfips + "&areatype=" + areatype + "&area=" + area +  "&zipcode=" + f.zipcode.value + 
                   "&naicscode=" + f.indcode.value + "&sizeclass=" + f.sizeclass.value + "&annsalrng=" + f.annsalrng.value + "&search=" + search;
            
   }
   

   function createDataGrid(f, url) {
         jQuery("#list").jqGrid({ url: url, 
                             datatype: 'xml', 
                              viewsortcols: [true,'vertical',true],
			     mtype: 'GET', 
			     colNames:['ID','Latitude','Longitude','Name', 'Address','City','Bus. Size','Sales'], 
			     colModel :[{name:'ID', index:'uniqueid', width:55, sortable: false, hidden: true}, 
					{name:'Latitude', index:'latitude', width:55, sortable: false, hidden: true}, 
					{name:'Longitude', index:'longitude', width:55, sortable: false, hidden: true}, 
					{name:'Name', index:'name', width:220}, 
					{name:'Address', index:'addressp', width:140, align:'left'},
					{name:'City', index:'cityp', width:100, align:'left'}, 
    				        {name:'Size', index:'empsizrng', width:100, align:'left'}, 
					{name:'Sales', index:'annsalrng', width:100, align:'left'} ], 
					pager: '#pager',
					rowNum: 25, 
					rowList:[25],
                                        height: 'auto',
                                        width: 700, 
                                        sortname: 'name', 
					sortorder: "asc", 
					viewrecords: true, 
				//	imgpath: 'themes/basic/images',
                                        onSelectRow: function(id){
                                                      if (id) { var ret = jQuery("#list").getRowData(id);
                                                          if      (map_state == 'nearest') mapEmployer(ret, map, map_count++); 
                                                          else     getEmpdbPage(ret.ID);
                                                          // alert("id="+ret.ID+" name="+ret.Name+"..."); 
                                                           } 
                                                      else { 
                                                           //   alert("Please select a row.");
                                                           $("#erecord").dialog('destroy');
                                                           $("#erecord").html("<strong>Please select the employer record you would like to display by clicking on it.</strong>");
                                                           $("#erecord").dialog({width: 400});
                                                            }

                                        },
                                       loadComplete: function(){
                                               if(($("#map_canvas").html().length > 50) && (map_state != 'nearest')) makeMap();
                                        }, 
                                        gridComplete: function(){
                                                      if (jQuery("#list").getGridParam("records") == 0) {
                                                          jQuery("#errmsg").html("<strong>No records found.</strong>");
                                                       //   jQuery("#pager").hide();
                                                         }
                                                       else { 
                                                            jQuery("#errmsg").html("");
                                                            }
                                        showSearchCriteria();
                                        }, 
					caption: 'infoUSA Employer Database' });
     
   } // createDataGrid(f)


   function showSearchCriteria(){
       var sresult = '';
       var szipcode = '';
       var ssizeclass = '';
       if ($("#thesearch").attr('value'))
          sresult = "  &nbsp; &nbsp;<strong>Search keyword:</strong> " + $("#thesearch").attr('value');
       if ($("#thezip").attr('value'))
          szipcode = "  &nbsp; &nbsp;<strong>Zipcode:</strong> " + $("#thezip").attr('value');

       if ($("#sizeclass").attr('value') == '9') ;
          else ssizeclass = " &nbsp; &nbsp;<strong>Sizeclass:</strong> " + $("#sizeclass option:selected").text();
       if ($("#rg1").attr('checked') == true) {
           $("#message").html('<br/><span style="border: 8px #dddddd;padding:3px; background-color: #efefef"><strong>Search for State:</strong> ' + $("#stfips option:selected").text() +
                          ' &nbsp; &nbsp; &nbsp; <strong>Area:</strong> ' + $("#areacode option:selected").text() +
                          ' &nbsp; &nbsp; &nbsp; <strong>Industry:</strong> ' + $("#indcode option:selected").text() +
                           sresult + szipcode + ssizeclass + '<br/></span>');
                           }
       else {
            $("#message").html('<br/><span style="border: 8px #dddddd;padding:3px; background-color: #efefef"><strong>Geography:</strong> Map Point'  +
                          ' &nbsp; &nbsp; &nbsp; <strong>Industry:</strong> ' + $("#indcode option:selected").text() +
                           sresult + szipcode + ssizeclass + '<br/></span>');
            }
    }


   function rebuildDataGrid(f, url){

     jQuery("#list").clearGridData();
     jQuery("#list").setGridParam({url: url + "&page=1"}); // hack for zero start problem. 
     jQuery("#list").setGridParam({pager: '#pager'});
     jQuery("#list").trigger("reloadGrid");
     jQuery("#list").setGridParam({url: url});
     
   }





  function getGeogJSON() {
    var stfips =   $('#stfips').attr('value');
    var areatype = $('#areatype').attr('value');
    if (stfips != '41') {
        areatype = '04';
        $('#areatype_choose').hide(); 
       }
    else { 
         $('#areatype_choose').show();
         }
     var options = '<option value="' + stfips + '01000000" selected="selected">Statewide</option>';
              if ((stfips == '06') || (stfips == '32')) {
                 options = '<option value="' + stfips + '01000000" selected="selected">All Border Counties</option>';
                 }
     $.getJSON("services/geog_service.php?stfips=" +stfips+"&areatype="+areatype, function(j){
              for (var i = 0; i < j.length; i++) {
                   options += '<option value="' + j[i].stfips + j[i].areatype + j[i].area + '">' + j[i].areaname + '</option>';
                   }
              $("select#areacode").html(options);
      }) 

  } //

  

               
     function getJSONIndData(f, naics){
      var areacode = f.areacode.value;
            var stfips = areacode.substring(0,2);
            var areatype = areacode.substring(2,4);
            var area = areacode.substring(4,10);
            var requrl = "";
      if (naics == 'sector') 
          requrl = "services/indsum_service.php?stfips=" + stfips + "&areatype=" + areatype + "&area=" + area + "&naicsect=" + f.sector.value + "&search=" + f.searchind.value;
      else  requrl = "services/indsum_service.php?stfips=" + stfips + "&areatype=" + areatype + "&area=" + area + "&naicscode=" + naics;
        return requrl;
     }

    function getNaicsIndustries(f, naics) {
       f.indcode.options.length = 0;
       getIndustryFeed(f, naics);
    }

    function getIndustries(f) {
       f.indcode.options.length = 0;
           if ((f.sector.value == '00') && (f.searchind.value == '')) {
        	   f.indcode.size = 1;
               var indopt = new Option('All Industries', '000000', true, true);
               f.indcode.options[f.indcode.options.length] = indopt;
             }
          else {
        	    f.indcode.size = 6;
                getIndustryFeedJSON(f, 'sector');
                 }
    } // getIndustries()


   function getIndustryFeedJSON(f, naics) {
     $.getJSON(getJSONIndData(f, naics), function(j){
              var areaoptions = "";
              var opt_sel = 'selected="selected"';
              if (j.length == 0) {
                 var indopt = new Option('No industries found. . .', '000000', true, true);
                 f.indcode.options[f.indcode.options.length] = indopt;
                 }
              for (var i = 0; i < j.length; i++) {
                     var indopt = new Option(j[i].naicscode + " - " + j[i].naicstitle + ' (' + j[i].employers +')', j[i].naicscode, true, true);
                    f.indcode.options[f.indcode.options.length] = indopt;
                 }
               f.indcode.selectedIndex = 0;
      }) 

   }

    function getIndustryFeed(f, naics) {
       $.ajax({
      url: getXMLIndData(f, naics),
      cache: false,
      async: false, 
      dataType: 'xml',
      success: function(myxml){
              var ind = myxml.documentElement.getElementsByTagName("industry");
              var areaoptions = "";
              var opt_sel = 'selected="selected"';
              if (ind.length == 0) {
                 var indopt = new Option('No industries found. . .', '000000', true, true);
                 f.indcode.options[f.indcode.options.length] = indopt;
                 }
              for (var i = 0; i < ind.length; i++) {
               var icode = ind[i].getAttribute("indcode");
               var employers = ind[i].getAttribute("employers");
                    var indopt = new Option(icode + " - " + ind[i].getAttribute("indtitle") + ' (' + employers +')', icode, true, true);
                   // var indopt = new Option(icode + " - " + ind[i].getAttribute("indtitle"), icode, true, true);
                    f.indcode.options[f.indcode.options.length] = indopt;
                    }
               f.indcode.selectedIndex = 0;
         }
      });

    } // getIndustryfeed(f)


    function getEmpdbPage(uniqueid) {
           $("#erecord").dialog('destroy');
           $.ajax({
            url: 'services/employer_record.php?uniqueid=' + uniqueid,
            cache: false,
            dataType: 'html',
            success: function(htmlDoc){
             $("#erecord").html(htmlDoc);
             $("#erecord").dialog({width: 400});
           } // success
        }) // $ajax
     } // getEmdbPage

    function processNearestReq(f, latitude, longitude) {
       processGridReq(f, getEmpdbNearestData(f, latitude, longitude));
    }

    function processReq(f){
       processGridReq(f, getEmpdbData(f));
    }
       
    function processGridReq(f, url) {
        $("#errmsg").html("");
        if (f.indcode.value == '000000' && f.search.value.length < 3) {
         // $tabs.tabs('select', 0);
          $('#thetabs').accordion('activate', 1);
          $("#errmsg").hide();
          $("#errmsg").html('<strong style="font-size: 20px; color: red">Select an industry or employer name.</strong>');
          $("#errmsg").fadeIn('slow');
         }
      else {
            $("#showrecord").show('slow');
            $("#showemployers").hide();
             if (jQuery("#list").html().length <= 15) createDataGrid(f, url); 
             else rebuildDataGrid(f, url);
            }     
    }

   

          $("#r1").click( function(){ 
                  $("#indkey").hide();
                  $("#inddrill").show("slow");
                  $("#indocc").hide();
                 }
           );

            $("#r2").click( function(){ 
                 $("#indkey").show("slow");
                 $("#inddrill").hide();
                 $("#indocc").hide();
                 }
            );

           $("#r3").click( function(){ 
                 $("#indkey").hide();
                 $("#inddrill").hide();
                 $("#indocc").show("slow");
                 getSoc(document.forms['locateform'], '000000', 'All Occupations', 0);
                 }
     
            );


 

 //   jQuery("#showrecord").click( function(){ 
 //   }); 

       function showemployer(){

                var id = jQuery("#list").getGridParam('selrow'); 
                if (id) { var ret = jQuery("#list").getRowData(id); 
                         // jQuery("#list").setGridParam({height: 100});
                         // jQuery("#list").trigger("reloadGrid");
                          getEmpdbPage(ret.ID);
                        // alert("id="+ret.ID+" name="+ret.Name+"..."); 
                        } 
                else { 
                    //   alert("Please select a row.");
                       $("#erecord").dialog('destroy');
                       $("#erecord").html("<strong>Please select the employer record you would like to display by clicking on it.</strong>");
                       $("#erecord").dialog();
                       } 
       }


  function getEmocclist(f, occcode) {
     var areacode = f.areacode.value;
     var stfips = areacode.substring(0,2);
     var areatype = areacode.substring(2,4);
     var area = areacode.substring(4,10);
     if  (areatype == '04') {
         areatype = '05';
         area = switchtoRegion(area);
         }
     $.ajax({
      url: 'services/occ_service?servicetype=empocclist&stfips=' + stfips + '&areatype=' + areatype + 
           '&area=' + area + '&occcode=' + occcode,
      cache: false,
      async: false, 
      dataType: 'xml',
      success: function(myxml){
              var ind = myxml.documentElement.getElementsByTagName("industry");
              var ind_html = "<table><th>Industry Group</th><th>Percentage Total<br/>Occupational Employment</th>";
              for (var i = 0; i < ind.length; i++) {
                   var indcode = ind[i].getAttribute("indcode");
                   
                   ind_html += '<tr><td>' + getNaicsLink(ind[i].getAttribute("title"), indcode) + '</td><td align="right"> ' + ind[i].getAttribute("percentage") + '</a></td></tr>';
                  }
                 $("#indlist").html(ind_html + '</table>');
              }
      });
   } // getEmocclist()

   
     function getNaicsLink(naicstitle, naicscode) {
         return '<a href="" onclick="getNaicsIndustries(document.forms[' + "'locateform'" + '], ' + 
                   "'" + naicscode + "'" + ') ; return false">' + naicstitle + '</a>';
    }

  function getSearchSocData(f){
         return "services/occ_service.php?servicetype=data?soccode=000000&title=" + f.socsearch.value;}


   function getSearchSoc(f) {
       $.getJSON(getSearchSocData(f), function(j){
                var alltext = '<a href="" onclick="getSoc(document.forms[' + "'occfeedform'" + '], ' + "'000000'," +
                         "'All Occupations'," + 0 +  ') ; return false">Return to Drill</a><br/>';
                var htmltext = "";
                for (var i = 0; i < j.length; i++) {
                     htmltext += getOccLink(j[i].soccode, j[i].soctitle, 1);
                     }
                $("#occdrill").html(alltext + htmltext);
       }) 

    }


    

  function getChildSocData(parent_soc){
         return  "services/occ_service.php?servicetype=child&socparent=" + parent_soc;}


  function getSoc(f, parent_soc, occtitle, occlevel) {
         $.getJSON(getChildSocData(parent_soc), function(j){
              var htmltext = "";
                for (var i = 0; i < j.length; i++) {
                     var newlevel = occlevel + 1;
                    htmltext += getOccLink(j[i].soccode, j[i].soctitle, newlevel);
                    }
               if (htmltext == '') {
                   $("#selocc").html('<strong>Industries of Employment for: ' + parent_soc + ' ' + occtitle + 
                                 '</strong><br/>(Click on an industry group to see detail industry employment.)');
                   getEmocclist(f, parent_soc);
                }
               else {
                     $("#occdrill").html(getPrevious_links(f, occlevel, occtitle, parent_soc) + htmltext) ;
                     }
      }) 
    } // getSoc


     function getPrevious_links(f, level, occtitle, occcode) {
      // f.socsearch.value = "search";
      var lhtml = ""; 
      // alert(level + ' ' + occtitle + ' ' + occcode);
      for (i = 0; i <= level; i++) {
         // alert(i);
         if (i == level) {
            previous_links[i] = getOccLink(occcode, occtitle, level);
            }
         lhtml += previous_links[i];
      }
    return lhtml;
   }



     function getOccLink(soccode, soctitle, newlevel) {
         var cssclass = ' class="occlevel' + newlevel + '" ';
         return '<span ' + cssclass + '>' + getSpaces(newlevel) + '</span><a href="" onclick="getSoc(document.forms[' + "'locateform'" + '], ' + 
                   "'" + soccode + "'," +
                   "'" + soctitle + "'," + newlevel + ') ; return false">' + soctitle + '</a><br/>';
    }




    function getSpaces(level){
       var sp = "&nbsp;";
       for (var i = 0; i < level; i++) {
          sp += " &nbsp; ";
        }
      return sp;
    }

    function switchtoRegion(county){
    	var regions = new Array();
     	regions["000007"] = "000001";
	regions["000009"] = "000001";
	regions["000057"] = "000001";
	regions["000051"] = "000002";
	regions["000067"] = "000002";
	regions["000047"] = "000003";
	regions["000053"] = "000003";
	regions["000071"] = "000003";
	regions["000003"] = "000004";
	regions["000041"] = "000004";
	regions["000043"] = "000004";
	regions["000039"] = "000005";
	regions["000019"] = "000006";
	regions["000011"] = "000007";
	regions["000015"] = "000007";
	regions["000029"] = "000008";
	regions["000033"] = "000008";
	regions["000021"] = "000009";
	regions["000027"] = "000009";
	regions["000055"] = "000009";
	regions["000065"] = "000009";
	regions["000069"] = "000009";
	regions["000013"] = "000010";
	regions["000017"] = "000010";
	regions["000031"] = "000010";
	regions["000035"] = "000011";
        regions["000037"] = "000011";
	regions["000049"] = "000012";
	regions["000059"] = "000012";
	regions["000001"] = "000013";
	regions["000061"] = "000013";
	regions["000063"] = "000013";
	regions["000023"] = "000014";
	regions["000025"] = "000014";
	regions["000045"] = "000014";
	regions["000005"] = "000015";
        var reg = regions[county];
        return reg;
    } // switchtoRegion

  

   $("#stfips").change(function () {  getGeogJSON(); });

   $("#areatype").change(function () {  getGeogJSON(); });

   // getGeog();

    getGeogJSON();


$("#rg").buttonset();

$("#r").buttonset();

$(".sbutn").button();

$("#thetabs").tabs();

   $("#thetabs").bind('tabsselect', function(event, ui) {
       showSearchCriteria();
    });

$("#geo_options").accordion({active: false});
   
/* $("#thetabs").accordion({autoHeight: ($.browser.msie),
                         icons: {header: "ui-icon-circle-arrow-e", 
                                 headerSelected: "ui-icon-circle-arrow-a"}
                         }); 

$('.ui-accordion').bind('accordionchange', function(event, ui) {

  if         ($(ui.oldHeader).attr('id') == 'ah1') {
               if   ($("#rg2").attr('checked') == true) $("#ah1t").html('Geography: Map Point');
               else $("#ah1t").html('State: ' + $("#stfips option:selected").text() + 
                               ', Area: ' +  $("#areacode option:selected").text());
             } 
  else if   ($(ui.oldHeader).attr('id') == 'ah2') $("#ah2t").html('Industry: ' + $("#indcode option:selected").text());
  else if   ($(ui.oldHeader).attr('id') == 'ah3') {
             var search_keyword = $("#thesearch").attr('value');
             $("#ah3t").html('Employer Name Search keyword: ' + ((search_keyword == '') ? 'None' : search_keyword));
             }
  else if   ($(ui.oldHeader).attr('id') == 'ah4'){
                                                  $("#ah4t").html('Employer Size: ' + $("#sizeclass option:selected").text() +
                                                  ', Annual Sales: ' + $("#annsalrng option:selected").text());
                                                 }
  else ;

  showSearchCriteria();
  });

*/
  
    
//   $("#thetabs").tabs();

/*   $("#thetabs").bind('tabsselect', function(event, ui) {
       showSearchCriteria();
    });

   var $tabs = $('#thetabs').tabs(); // first tab selected
 */

   $('#nexttab-1').click(function() { // bind click event to link
           $('#thetabs').accordion('activate', 1); // Next tab
       return false;
    });

   $('#nexttab-2').click(function() { // bind click event to link
           $('#thetabs').accordion('activate', 2); // Next tab
       return false;
    });

   $('#nexttab-3').click(function() { // bind click event to link
           $('#thetabs').accordion('activate', 3); // Next tab
       return false;
    });


     $('#backtab-1').click(function() { // bind click event to link
           $('#thetabs').accordion('activate', 0); // Next tab
       return false;
    });

   $('#backtab-2').click(function() { // bind click event to link
           $('#thetabs').accordion('activate', 1); // Next tab
       return false;
    });

   $('#backtab-3').click(function() { // bind click event to link
           $('#thetabs').accordion('activate', 2); // Next tab
       return false;
    });

   



 // $('#map').css('width', '600px');
  
   
    //]]>
    </script>
</body>
</html>
