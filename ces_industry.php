<?php 
require_once('data/ces_data.php');


$parms = get_params(array('stfips'=>'41', 'areatype'=>'01', 'area'=>'000000', 'adjusted'=>'1', 'seriescode'=>'20000000'));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CES Industry Report</title>
      <link href="css/layout.css" rel="stylesheet" type="text/css"></link> 
     <link rel="stylesheet" href="jquery-ui-1.8.2/themes/base/jquery.ui.core.css" type="text/css" media="screen" title="Flora (Default)" />
     <link rel="stylesheet" href="jquery-ui-1.8.2/themes/base/jquery.ui.theme.css" type="text/css" media="screen" title="Flora (Default)" />
     <link rel="stylesheet" href="jquery-ui-1.8.2/themes/base/jquery.ui.datepicker.css" type="text/css" media="screen" title="Flora (Default)" />
    <!--[if IE]><script language="javascript" type="text/javascript" src="flot-0.6/flot/excanvas.min.js"></script><![endif]-->
    <!--   <script language="javascript" type="text/javascript" src="flot-0.6/flot/jquery.js"></script> -->
     <script language="javascript" type="text/javascript" src="jquery-ui-1.8.2/js/jquery-1.4.2.min.js"></script> 
     <script language="javascript" type="text/javascript" src="flot-0.6/flot/jquery.flot.js"></script>
     <script type="text/javascript" src="jquery-ui-1.8.2/ui/jquery.ui.core.js"></script>
     <script type="text/javascript" src="jquery-ui-1.8.2/ui/jquery.ui.widget.js"></script>
     <script type="text/javascript" src="jquery-ui-1.8.2/ui/minified/jquery.ui.datepicker.min.js"  ></script>
     <script type="text/javascript" src="jquery-ui-1.8.2/ui/jquery.ui.button.js"></script>
     <script src="js/arc_util.js" type="text/javascript" ></script>

 </head>
<body>
<div class="wrap">
<?php require_once('includes/page_header.php'); ?>
<h2>Current Employment Statistics <?php echo (($parms['adjusted'] == '1') ? ' (Seasonally Adjusted)' : ' (Not Seasonally Adjusted)') ?><br/>
 <span id="myname"></span> <span id="mylegend"></span></h2>
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
    <td colspan="3">
    Adjusted: 
    <select id="adjusted">
    <option value="1" <?php echo (($parms['adjusted'] == '1') ? 'selected="selected"' : ''); ?> >Seasonally Adjusted</option>
    <option value="0" <?php echo (($parms['adjusted'] == '0') ? 'selected="selected"' : ''); ?> >Not Adjusted</option>
    </select>
    </td>
    </tr>

    <tr>
       <td>From: &nbsp; &nbsp; <input type="text" id="startperiod" value="01/01/2000" style="width:100px;"/></td>
    </tr>

    <tr>
       <td>To: &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" id="endperiod" value="<php? echo date('m/d/Y'); ?>" style="width:100px;"/></td>
    </tr>
   
    <tr>
     <td>Show: <input id="dolines" checked="checked" type="checkbox" />Lines  <input id="dopoints" type="checkbox" />Points</td>
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
       var datatab = '<table id="' + css_class + '" style="font-size: 13px"><tr><th>Year</th><th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Jul</th>' +
                      '<th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Annual</th></tr>';
       var rec = 0;
       var prelim_text = "";
       var stfips = areacode.substring(0,2);
       var areatype = areacode.substring(2,4);
       var area = areacode.substring(4,10);
       var indname = "";
       $.ajax({
       url: "services/ces_service.php?servicetype=industry&seriescode=<?php echo $parms['seriescode']; ?>&stfips=" + stfips + "&areatype=" + areatype + "&area=" + area + "&adjusted=" + adjusted,
      cache: false,
      async: false, 
      dataType: 'json',
      success: function(myjson){
              // var xmlDoc = myxml.responseXML;
              var ind = eval(myjson);
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
                   indname = ind[i].seriesttls;
                   var periodyear = ind[i].periodyear;
                   var periodtype = ind[i].periodtype;
                   var period = ind[i].period;
                   var longperiod = getLongDateString(periodyear, period);
                   var unemprate = ind[i].empces;
                   var fmt_val = ind[i].empces_fmt;
                   if (period == "00") annual_val = fmt_val;
                   var prelim = ind[i].prelim;
                   if ((longperiod >= start_date) && (longperiod <= end_date) && (periodtype == '03')) {
                      if ((pre_periodyear == periodyear) && (pre_period == period) && (prelim == '1')) {
                          ;
                          }
                      else {
                            if ((pre_periodyear == periodyear) && (pre_period == period) && (prelim == '0')) {
                                 rec = rec - 1;
                                 } 
                            pdata[rec] = [getDateSetting(periodyear, period), unemprate];
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
      $("#myname").html(indname);
      datatab +=  " </table>";
      datatab = "<strong>" + thelabel + "  " + indname + " Industry</strong>"  + datatab;
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

     function getDateSetting(theyear, themonth){
       return (new Date(theyear + "/" + themonth + "/01")).getTime();
     }

     function getYAxis() {
         return {mode: null}
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
                                item.series.label + ', ' + thedate.getFullYear() + '/' +  (mts[thedate.getMonth()]) + ", " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });

  } //runPlot

 function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }


  // $("#plcontrols").show();

  $("#doplot").click(function () {
        runPlot();
      });

   $('#startperiod').datepicker({changeMonth: true, changeYear: true});

   $('#endperiod').datepicker({changeMonth: true, changeYear: true});

    GeogLists.stfips = '41'
    GeogLists.include_statewide = 'y';
    GeogLists.areatype = '21';
    GeogLists.area = "<?php echo $parms['area']; ?>";
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
