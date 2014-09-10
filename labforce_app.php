<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Laborforce Data</title>
     <link href="css/layout.css" rel="stylesheet" type="text/css"></link> 
     <link rel="stylesheet" href="css/lausprint.css" type="text/css" media="print"/>  
     <link rel="stylesheet" href="jquery-ui-1.8.2/themes/base/jquery.ui.core.css" type="text/css" media="screen" title="Flora (Default)" />
     <link rel="stylesheet" href="jquery-ui-1.8.2/themes/base/jquery.ui.theme.css" type="text/css" media="screen" title="Flora (Default)" />
     <link rel="stylesheet" href="jquery-ui-1.8.2/themes/base/jquery.ui.datepicker.css" type="text/css" media="screen" title="Flora (Default)" />
    <!--[if IE]><script language="javascript" type="text/javascript" src="flot-0.6/flot/excanvas.min.js"></script><![endif]-->
   <!--   <script language="javascript" type="text/javascript" src="flot-0.6/flot/jquery.js"></script> -->
     <script language="javascript" type="text/javascript" src="jquery-ui-1.8.2/js/jquery-1.4.2.min.js"></script> 
     <script language="javascript" type="text/javascript" src="flot-0.6/flot/jquery.flot.js"></script>
     <script src="jquery-ui-1.8.2/ui/jquery.ui.core.js" type="text/javascript"></script>
     <script src="jquery-ui-1.8.2/ui/jquery.ui.widget.js"type="text/javascript" ></script>
     <script src="jquery-ui-1.8.2/ui/minified/jquery.ui.datepicker.min.js" type="text/javascript"  ></script>
     <script src="jquery-ui-1.8.2/ui/jquery.ui.button.js" type="text/javascript" ></script>
     <script  src="js/arc_util.js" type="text/javascript" ></script>
 </head>
<body>
<div class="wrap">
<?php require_once('includes/page_header.php'); ?>
<h2>Labor Force Data</h2>
<noscript>
<div>
<strong>To see more advanced Labor Force features, you need to have JavaScript turned on in your browser.</strong>
<br/><br/>
Check the OLMIS Homepage for the: <a href="http://www.qualityinfo.org">Latest Employment Situation.</a><br/><br/>
or the Bureau of Labor Statistics for: <a href="http://www.bls.gov/bls/unemployment.htm">Unemployment Information.</a>
</div>
</noscript>
<table>
<tbody>
<tr>
  <td valign="top" align="left">
   <div id="placeholder" style="width:600px;height:300px;"></div>
   <div id="result"></div>
   </td>

   <td valign="top" align="left">
   <div id="mylegend"></div>
   </td>

  <td valign="top">
  <div id="plcontrols" style="display: none">
    <table>
    <tbody>
    <tr>
    <td valign="top" colspan="3">
    Areas:<br/><select id="areacode" multiple="multiple"></select>
    </td>
    </tr>

    <tr>
       <td colspan="3">Statistic: &nbsp; 
       <select id="stat">
       <option value="unemprate"  selected="selected" >Unemployment Rate</option>
       <option value="laborforce"  >Civilian Labor Force</option>
       <option value="emplab"      >Employed Level</option>
       <option value="unemp"       >Unemployed Level</option>
       </select>
       </td>
    </tr>

    <tr>
    <td colspan="3">
    Adjusted: 
    <select id="adjusted">
    <option value="1" >Seasonally Adjusted</option>
    <option value="0" >Not Adjusted</option>
    </select>
    </td>
    </tr>

    <tr>
       <td>From: &nbsp; &nbsp; <input type="text" id="startperiod" value="01/01/2007" style="width:100px;"/></td>
    </tr>

    <tr>
       <td>To: &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" id="endperiod" value="08/01/2009" style="width:100px;"/></td>
    </tr>
   
    <tr>
     <td>Show: <input id="dolines" checked="checked" type="checkbox" />Lines  <input id="dopoints" checked="checked" type="checkbox" />Points</td>
    </tr>

   	<tr>
   	<td colspan="4">
   	<button class="sbutn" id="doplot">Draw Plot</button>
   	</td>
   	</tr> 
       </tbody>
       </table>
       </div>
   </td>
</tr>
</tbody>
</table>
<br/><br/>
<div id="datatab"></div>
<span><b>Source: Oregon Employment Department</b></span>
</div>

   
<script id="source" language="javascript" type="text/javascript">
$(function () {

     var mts = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",];

     var max_xvalue = 8;

     var plot_number = 0;
     
   function setNewMax(the_max) {
       var new_max = Math.max(max_xvalue, the_max);
       if (new_max > 8) max_xvalue = 10;
       if (new_max > 10) max_xvalue = 14;
       if (new_max > 14) max_xvalue = 18;
       if (new_max > 18) max_xvalue = 20;
       if (new_max > 20) max_xvalue = 25;
       if (new_max > 25) max_xvalue = 35;
     }

   function getBlank_months(first_record, periodyear, period) {
         if    (first_record == 'n') return "";
         else if (period == '01') return "";
         else  { tab_row ='<tr><td>' + periodyear + '</td>';
                 for (i = 1; i < period; i++){
                       tab_row += "<td></td>";
                      }
                return tab_row;
                }
   } // getBlank_months


     function getLausPlotData(thelabel, areacode, adjusted){
       var pdata = new Array();
       var css_class = 'sumdatatable' + plot_number;
       var datatab = '<table id="' + css_class + '"><tr><th>Year</th><th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Jul</th>' +
                      '<th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Annual</th></tr>';
       var rec = 0;
       var prelim_text = "";
       var stfips = areacode.substring(0,2);
       var areatype = areacode.substring(2,4);
       var area = areacode.substring(4,10);
       $.ajax({
       url: "services/laus_service.php?stfips=" + stfips + "&areatype=" + areatype + "&area=" + area + "&adjusted=" + adjusted,
      cache: false,
      async: false, 
      dataType: 'xml',
      success: function(myxml){
              // var xmlDoc = myxml.responseXML;
              var ind = myxml.documentElement.getElementsByTagName("labforce");
              var pre_periodyear = '';
              var pre_period = '';
              var pre_unemprate = '';
              var annual_val = "";
              var first_record = "y";
              var startd = $('#startperiod').datepicker("getDate");
              var endd = $('#endperiod').datepicker("getDate");
              var start_date = getLongDateString(startd.getFullYear(), get2dMonth(startd.getMonth()));
              var end_date =  getLongDateString(endd.getFullYear(), get2dMonth(endd.getMonth()));
              for (var i = 0; i < ind.length; i++) {
                   var periodyear = ind[i].getAttribute("periodyear");
                   var periodtype = ind[i].getAttribute("periodtype");
                   var period = ind[i].getAttribute("period");
                   var longperiod = getLongDateString(periodyear, period);
                   var stat = $("#stat").attr("value");
                   var unemprate = ind[i].getAttribute(stat);
                   var fmt_val = unemprate;
                   if (stat != 'unemprate') fmt_val = ind[i].getAttribute("fmt_" + stat);
                   if (period == "00") annual_val = fmt_val;
                   var prelim = ind[i].getAttribute("prelim");
                   if ((longperiod >= start_date) && (longperiod <= end_date) && (periodtype == '03')) {
                      if ((pre_periodyear == periodyear) && (pre_period == period) && (prelim == '1')) {
                          ;
                          }
                      else {
                            if ((pre_periodyear == periodyear) && (pre_period == period) && (prelim == '0')) {
                                 rec = rec - 1;
                                 } 
                            pdata[rec] = [getDateSetting(periodyear, period, '01'), unemprate];
                            rec++;
                            var pre_caution = "";
                            if (prelim == '1') {
                                pre_caution = '(p) ';
                                prelim_text = "<span>(p) - preliminary caution</span>";
                                }
                            if (period == "01") datatab += '<tr><td>' + periodyear + '</td>';
                            datatab +=  getBlank_months(first_record, periodyear, period);
                            first_record = "n";
                            datatab += '<td class="lausval">' + pre_caution + fmt_val   + '</td>';
                            if (period == "12") {
                               datatab += '<td class="lausval">' + pre_caution + annual_val  + '</td></tr>';
                               annual_val = "";
                               }
                            }
                       setNewMax(unemprate);
                       pre_periodyear = periodyear;
                       pre_period = period;
                       pre_unemprate = unemprate;
                      }
                     
                   
                  }
          }
      });
      datatab +=  " </table>";
      datatab = "<strong>" + thelabel + " " + $("#stat option:selected").text() + "</strong>"  + datatab;
      lasttab = $("#datatab").html();
      $("#datatab").html(lasttab  + datatab + prelim_text + "<br/><br/>");
      $('#' + css_class + ' tr:even').css({color: 'black', backgroundColor: '#ECF3FE'});
      $('#' + css_class + ' tr:first').css({color: '#ffffff', backgroundColor: 'blue'});
      return { label: thelabel, data: pdata }

     }

     function get2dMonth(m) {

       return (["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"])[m];
     }

     function getLongDateString(theyear, themonth){
        return theyear + '' + themonth;
     }

    

     function getYAxis() {
     if   ($("#stat").attr("value") == "unemprate") 
          return {ticks: [[0, "0%"], 
                 //  [1,  "1%"], 
                     [2,  "2%"], 
                 //  [3,  "3%"], 
                     [4,  "4%"], 
                //   [5,  "5%"], 
                     [6,  "6%"], 
                //   [7,  "7%"], 
                     [8,  "8%"],
                //   [9,  "9%"],
                     [10, "10%"],
                     [12, "12%"],
                     [14, "14%"],
                     [16, "16%"],
                     [18, "18%"],
                     [20, "20%"],
                     [25, "25%"],
                     [30, "30%"],
                     [35, "35%"]]  , min: 0, max: max_xvalue } 
     else return {mode: null}
    }

   function runPlot() {

    // Initialize data are in the page 
    $("#datatab").html("");
    $("#result").html("");

   // Initialize data and preference values
   var plot_array = new Array();
   plot_number = 0;
   max_xvalue = 8;

   // Create data for the plot
   $("#areacode option:selected").each(function(){ 
                  plot_array[plot_number] = getLausPlotData($(this).text(), $(this).attr("value"), $("#adjusted").attr("value"));
                  plot_number++; 
    
             });

           

    // Run the plot
    $.plot($("#placeholder"), plot_array, { 
             series: {
                       lines: { show: ($("#dolines:checked").length > 0) },
                       points: {show: ($("#dopoints:checked").length > 0) }
                      },
             legend: {container: '#mylegend'},
             grid: { hoverable: true },
             xaxis: { mode: "time", minTickSize: [1, "month"] },
             yaxis: getYAxis()
         });

      /* Define an action when the plot area is clicked
      $("#placeholder").bind("plotclick", function (e, pos, item) {
          if (item) {
                     millis = item.datapoint[0].toFixed(2);
                     thedate = new Date(Math.round(millis));
                     $("#result").text('Values: (' + thedate.getFullYear() + '/' +  (mts[thedate.getMonth()])  + ', ' + item.datapoint[1].toFixed(1) + ')');
                    }
             });
      */

     // Define an action when the plot point is moused over
     var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var y = item.datapoint[1].toFixed(1);
                    millis = item.datapoint[0].toFixed(2);
                    thedate = new Date(Math.round(millis));
                    
                    showTooltip(item.pageX, item.pageY,
                                '<b>' + item.series.label + '</b>, ' + thedate.getFullYear() + '/' +  (mts[thedate.getMonth()]) + ", " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });

  } //runPlot

 
  $("#plcontrols").show();

  $("#doplot").button();

  $("#doplot").click(function () {
        runPlot();
      });

   $('#startperiod').datepicker({changeMonth: true, changeYear: true});

   $('#endperiod').datepicker({changeMonth: true, changeYear: true});

    GeogLists.stfips = '41'
    GeogLists.include_national = 'y';
    GeogLists.include_statewide = 'y';
    GeogLists.areatype = '21';
    GeogLists.select_list = 'areacode';
    GeogLists.list_size = 4;
    GeogLists.getGeog();

    GeogLists.include_national = 'n';
    GeogLists.include_statewide = 'n';
    GeogLists.keep = 'y';
    GeogLists.areatype = '04';
    GeogLists.getGeog();

   // getGeog();
   runPlot();

  

});
</script>

</body>
</html>
