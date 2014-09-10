<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Current Employment Statistics Report</title>
<link href="css/layout.css" rel="stylesheet" type="text/css"></link> 
<script src="jquery-ui-1.8.2/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/arc_util.js" type="text/javascript" ></script>
<link href="css/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<link href="css/tree_table_master.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/jquery.treeTable.js"></script>
  
</head>
<body>
<div class="wrap">
<?php require_once('includes/page_header.php'); ?>
<h3 style="text-align: center">Current Employment Statistics Report</h3>
<div id="controls"  style="padding-left: 40px">
<style>
#list_controls ul {list-style: none}
#list_controls li {float: left; padding: 20px}
</style>
<div id="list_controls">
<ul>
<li>
Area: <br/><select id="areacode"></select>
</li style="float: left">
<li>
Year:<br/><select id="year"></select>
</li>
<li>
Adjusted:<br/> 
    <select id="adjusted">
    <option value="1" >Seasonally Adjusted</option>
    <option value="0" >Not Seasonally Adjusted</option>
    </select>

</li>
<li>
Industry Level:<br/> 
    <select id="ilevel">
    <option value="5" >5</option>
     <option value="4" >4</option>
     <option value="3" >3</option>
     <option value="2" >2</option>
     <option value="1" >1</option>
    </select>

</li>
<li>
Detail View:<br/> 
    <select id="detail">
    <option value="0" >Collapsed</option>
    <option value="1" >Expanded</option>
    </select>
</li>
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
<a href="ces_report.php" ><img src="images/goback.gif" alt="Start from the beginning" width="20" height="20" /></a> &nbsp;
<a href="ces_report.php" alt="Start from the beginning" >Start Over</a> &nbsp;
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

    function setYears() {
       var options = "";
             for (var i = 2010; i >= 1990; i--) {
                   options += '<option value="' + i + '">' + i + '</option>';
                   }
              $("select#year").html(options);
    
    } //

     function getReport() {
       var areacode = $("#areacode").attr("value");
       var stfips = areacode.substring(0,2);
       var areatype = areacode.substring(2,4);
       var area = areacode.substring(4,10);
       var ilevel = $("#ilevel").attr("value");
       var rows = "";
       var rowhead = '<thead><tr><th>Industry</th><th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th></tr></thead><tbody>';
       var periodyear = $("#year").attr('value');
       var last_series = '';
       var last_period = '';
       var end_row = "";
       $.getJSON('services/ces_service.php?stfips=' + stfips + '&areatype='  + areatype + '&area=' + area + '&periodyear=' + periodyear + '&periodtype=03&adjusted=' + $('#adjusted').attr('value') + 
                 '&serieslvl=' + ilevel + '&servicetype=data', function(j){
             var cssref = {
                 parent_nodes: ['', '', '', '', '', ''],
                 parent_indexes: [0, 1, 2, 3, 4, 5],
                 node_index: 0,
                 previous_level: 0,
                 previous_node: ''};
              for (var i = 0; i < j.length; i++) {
                  // alert(j[i].serieslvl + '    ' + j[i].seriesttls);
                   if (last_series == j[i].seriescode) {
                       rows += '<td class="dcell">' + j[i].empces + '</td>';
                       }
                   else {
                       var slink = '<a href="ces_industry.php?seriescode=' + j[i].seriescode + '&stfips=' + j[i].stfips + '&area=' + j[i].area + '&adjusted=' + j[i].adjusted + '" target="_blank">' +
                                     j[i].seriesttls + '</a>';
                       rows += end_row + '<tr id="' +  j[i].seriescode + '" ' + getClass(cssref, j[i].seriescode, j[i].serieslvl) + '"><td align="left">' +  slink  + 
                       // ' ' +    j[i].serieslvl + ' ' + cssref.node_index +  
                         ' </td><td class="dcell">' + j[i].empces + '</td>';
                        }
                    end_row = '</tr>';
                    last_series = j[i].seriescode;
                    cssref.previous_level = j[i].serieslvl;
                    cssref.previous_node = j[i].seriescode;
                  }
              if (j.length == 0) $("#report").html('<strong>No ' + jQuery("#adjusted option:selected").text() + ' Employment for ' +  jQuery("#areacode option:selected").text() + ' ' + periodyear + '</strong>');
              else {
                    $("#report").html('<span class="sectionTitle">' +  jQuery("#adjusted option:selected").text() + ' Non-Farm Employment for ' + jQuery("#areacode option:selected").text() + 
                                ' (' + periodyear + ')</span><br/><table id="ces_tab" style="left-padding: 30px">' +
                                 rowhead + rows + '</tbody></table>');
                    $("#ces_tab").treeTable({
                        initialState: ($("#detail").attr('value') == 1) ? "expanded" : "collapsed"
                     }); 
                    }

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
    GeogLists.areatype = '21';
    GeogLists.select_list = 'areacode';
    GeogLists.getGeog();

    GeogLists.include_national = 'n';
    GeogLists.include_statewide = 'n';
    GeogLists.keep = 'y';
    GeogLists.areatype = '04';
    GeogLists.getGeog();

   setYears();

   $("#tree").treeTable();


  $("#doreport").click(function () {
        getReport();
      });
    
   //]]>
    </script>
</body>
</html>