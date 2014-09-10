<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Quarterly Census of Payroll and Wages (QCEW)</title>
<link href="css/layout.css" rel="stylesheet" type="text/css"></link> 
<script src="jquery-ui-1.8.2/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/arc_util.js" type="text/javascript" ></script>
<!-- <link href="css/jquery.treeTable.css" rel="stylesheet" type="text/css" /> -->
<!-- <link href="css/tree_table_master.css" rel="stylesheet" type="text/css" /> --> 
<!-- <script type="text/javascript" src="js/jquery.treeTable.js"></script> -->
  
</head>
<body>
<div class="wrap">
<?php require_once('includes/page_header.php'); ?>
<h3 style="text-align: center">Quarterly Census of Payroll and Wages (QCEW)</h3>
<div id="controls"  style="padding-left: 40px">
<style>
#list_controls ul {list-style: none}
#list_controls li {float: left; padding: 20px}
</style>
<div id="list_controls">
<ul>
<li>
Area: <br/><select id="areacode"></select>
</li>
<li>
Year:<br/> 
    <select id="periodyear">
    <option value="1999" >1999</option>
    </select>

</li>
<li>
Quarter:<br/> 
    <select id="period">
     <option value="04" >04</option>
     <option value="03" >03</option>
     <option value="02" >02</option>
     <option value="01" >01</option>
    </select>

</li>
<!-- <li>
Detail View:<br/> 
    <select id="detail">
    <option value="0" >Collapsed</option>
    <option value="1" >Expanded</option>
    </select>
</li> -->
</ul>
</div>
<br/>
<table id="tree" style="display: none">
  <tr id="node-1">
    <td>Parent</td>
  </tr>
  <tr id="node-2" class="child-of-node-1">
    <td>Child</td>
  </tr>
  <tr id="node-3" class="child-of-node-2">
    <td>Child</td>
  </tr>
</table>

<br/><br/>
<br/><br/>
<div style="padding-left: 60px">
<a href="qcew_report.php" ><img src="images/goback.gif" alt="Start from the beginning" width="20" height="20" /></a> &nbsp;
<a href="qcew_report.php" alt="Start from the beginning" >Start Over</a> &nbsp;
<button class="sbutn" id="doreport">Get Report</button>
<br/><br/>
Click arrows to view more or less industry detail. 
</div>
</div>

<br/><br/>

<div id="report" style="text-align: center; padding-left: 40px"></div>
</div>
<script type="text/javascript">
    //<![CDATA[

 /*   function setYears() {
       var options = "";
             for (var i = 2010; i >= 1990; i--) {
                   options += '<option value="' + i + '">' + i + '</option>';
                   }
              $("select#year").html(options);
    
    } */

     function getReport() {
       var areacode = $("#areacode").attr("value");
       var stfips = areacode.substring(0,2);
       var areatype = areacode.substring(2,4);
       var area = areacode.substring(4,10);
       var ilevel = $("#ilevel").attr("value");
       var rows = "";
       var rowhead = '<thead><tr><th>Code</th><th>Industry</th><th>Ownership</th><th>Units</th><th>Employment</th><th>Payroll</th><th>Avg Pay</th></tr></thead><tbody>';
       var periodyear = $("#periodyear").attr('value');
       var period = $("#period").attr('value');
       var last_series = '';
       var last_period = '';
       var end_row = "";
       $.getJSON('services/qcew_service.php?stfips=' + stfips + '&areatype='  + areatype + '&area=' + area + '&periodyear=' + periodyear + '&periodtype=02&period=' + period, function(j){
                for (var i = 0; i < j.length; i++) {
                 rows +=  '<tr><td align="left">' +  j[i].indcode + '</td><td align="left">' + j[i].codetitle + '</td><td align="right">' + j[i].ownership + '</td><td align="right">' + j[i].estab_fmt + '</td><td align="right">' +
                                      j[i].avgemp_fmt + '</td><td align="right">' +j[i].totwage_fmt + '</td><td align="right">' + j[i].avgwage_fmt + '</td><tr>'; 
                        }
                    $("#report").html('<table><tbody>' + rowhead + rows + '</tbody></table>');
     
       }) 

    } //

    function getClass(cssref, seriescode, serieslvl){

       
           if (serieslvl == cssref.previous_level) {
               if (serieslvl == 0) result = '';
                  else result = ' class="child-of-' + cssref.parent_nodes[cssref.node_index] + '"';
               }
          else if (serieslvl > cssref.previous_level) { 
                cssref.node_index += 1;
                cssref.parent_indexes[cssref.node_index] = serieslvl;
                cssref.parent_nodes[cssref.node_index] = cssref.previous_node;
                result = ' class="child-of-' + cssref.parent_nodes[cssref.node_index] + '"'; 
                }
         else {
                if      (serieslvl == 1) {
                         cssref.node_index = 1;
                         result = ' class="child-of-00000000"';  
                        }
                else {
                      cssref.node_index = 1;
                      for (i = 5; serieslvl < cssref.parent_indexes[i]; i--)   cssref.node_index = i;
                          cssref.node_index = i; 
                     // inc = cssref.previous_level - serieslvl; 
                     //  cssref.node_index = Math.max((cssref.node_index - inc), 1);
                      result =  ' class="child-of-' + cssref.parent_nodes[cssref.node_index] + '"'; 
                      }
                }
        
         return result;

       } // getClass
       
   

    GeogLists.stfips = '41'
    GeogLists.include_statewide = 'y';
    GeogLists.areatype = '04';
    GeogLists.select_list = 'areacode';
    GeogLists.getGeog();

    

 //  setYears();

 //  $("#tree").treeTable();


  $("#doreport").click(function () {
        getReport();
      });
    
   //]]>
    </script>
</body>
</html>