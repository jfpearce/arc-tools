  <!--[if IE]><script language="javascript" type="text/javascript" src="flot-0.6/flot/excanvas.min.js"></script><![endif]-->
   <!--   <script language="javascript" type="text/javascript" src="flot-0.6/flot/jquery.js"></script> -->
     <script language="javascript" type="text/javascript" src="jquery-ui-1.8.2/js/jquery-1.4.2.min.js"></script> 
     <script language="javascript" type="text/javascript" src="flot-0.6/flot/jquery.flot.js"></script>
<h3>Population Statistics</h3>
<div id="geography">
     Select an area: <br/>
     <select id="areacode"></select>
     <br/><br/>
</div>
<div>
     Population Survey Source:<br/>
     <select id="popsource"><option value="1">U.S. Bureau of the Census</option></select>
</div>
<br/><br/>
<button class="sbutn" id="doreport">Get Report</button>
<br/><br/>

<div id="mylegend"></div>
<div id="placeholder" style="width:500px;height:300px;"></div>

<script type="text/javascript">
    //<![CDATA[

    var mts = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",];
    
     function getReport() {
       var pdata = new Array();
       var areaname = $("#areacode option:selected").text();
       var popsource = $("select#popsource").attr('value');
       var areacode = $("select#areacode").attr('value');
       var stfips = areacode.substring(0,2);
       var areatype = areacode.substring(2,4);
       var area = areacode.substring(4,10);
      $.getJSON('services/popservice.php?stfips=' + stfips + '&areatype='  + areatype + '&area=' + area + '&popsource=' + popsource, function(j){
              for (var i = 0; i < j.length; i++) {
                   pdata[i] = [getDateSetting(j[i].periodyear, '01', '01') , j[i].population];
                   }
              var plot_array = new Array();
              plot_array[0] = { label: areaname + ' Population', data: pdata };
               $.plot($("#placeholder"), plot_array, { 
                series: {
                       lines: { show: true },
                       points: {show: true }
                      },
              legend: {container: '#mylegend'},
               grid: { hoverable: true },
             xaxis: { mode: "time", minTickSize: [1, "year"] }
            });

           var previousPoint = null;
        $("#placeholder").bind("plothover", function (event, pos, item) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                   
                   $("#tooltip").remove();
                    var y = item.datapoint[1].toFixed(0);
                    millis = item.datapoint[0].toFixed(2);
                    thedate = new Date(Math.round(millis));
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label + ', ' + thedate.getFullYear() +  ", " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
             });


       }) 

    } //

    $("#doreport").click(function () {
        getReport();
      });
    
    GeogLists.stfips = '<?php echo ARConfig::stfips; ?>';
    GeogLists.include_national = 'n';
    GeogLists.include_statewide = 'y';
    GeogLists.select_list = 'areacode';
    GeogLists.keep = 'y';
    GeogLists.areatype = '04';
    GeogLists.getGeog();
   
    //]]>
</script>
