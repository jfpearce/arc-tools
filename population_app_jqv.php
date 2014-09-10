<html>
<head>
<link href="css/basic.css" type="text/css" rel="stylesheet" />
<link href="css/visualize.css" type="text/css" rel="stylesheet" /> 
<link href="css/visualize-pop.css" type="text/css" rel="stylesheet" /> 
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/excanvas.js"></script>		
<script type="text/javascript" src="js/visualize.jQuery.js"></script>
<script src="js/arc_util.js" type="text/javascript"></script>
</head>
<?php require_once('data/wfutils.php'); ?>
<body>
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

<div id="widdata"></div>

<script type="text/javascript">
    //<![CDATA[
    
     function getReport() {
       var areaname = $("#areacode option:selected").text();
       var rows = '<table id="popline" style="display:none; font-size: 11px; width: 400px; height: 150px">';
       rows += '<caption>' + areaname + ' Population</caption>';
       rows += '<thead><tr><td>Year</td><th scope="col">' + areaname + ' (thousands)</th></tr></thead><tbody>';
       var popsource = $("select#popsource").attr('value');
       var areacode = $("select#areacode").attr('value');
       var stfips = areacode.substring(0,2);
       var areatype = areacode.substring(2,4);
       var area = areacode.substring(4,10);
      $.getJSON('services/popservice.php?stfips=' + stfips + '&areatype='  + areatype + '&area=' + area + '&popsource=' + popsource, function(j){
              for (var i = 0; i < j.length; i++) {
                   rows += '<tr><th scope="col">' + j[i].periodyear + '</th><td>' + j[i].population + '</td></tr>';
                   }
              $("#widdata").html(rows + '</tbody></table>');
              $('#popline').visualize({type: 'line', width: '800px', parseDirection: 'y'});
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
</body>
</html>