<h3>Census Labor Report</h3>
<br/>
Select Year:
<select id="periodyear"></select>

<br/><br/>
<button class="sbutn" id="doreport">Get Report</button>
<br/><br/>

<div id="report"></div>
<script type="text/javascript">
    //<![CDATA[

   
    function getPeriodYear() {
       var options = "";
       $.getJSON("services/cenlabor_service.php?stfips=66&servicetype=periodyears", function(j){
              for (var i = 0; i < j.length; i++) {
                   options += '<option value="' + j[i].periodyear + '">' + j[i].periodyear + '</option>';
                   }
              $("select#periodyear").html(options);
      })

    } //

     function getReport() {
       var rows = "";
       var periodyear = $("select#periodyear").attr('value');
       $.getJSON('services/cenlabor_service.php?stfips=66&periodyear='+ periodyear + '&servicetype=data', function(j){
              for (var i = 0; i < j.length; i++) {
                   rows += '<tr><td>' + j[i].censtitle.ucwords() + '</td><td class="dcell">' + j[i].malelf + '</td><td class="dcell">' + j[i].femalelf + '</td></tr>';
                   }
              $("#report").html('<strong>Census Laborforce Employment</strong><br/><table><tr><th>Occupation</th><th>Male</th><th>Female</th>' + rows + '</table>');
       }) 

    } //

  getPeriodYear();

  $("#doreport").click(function () {
        getReport();
      });
    
   //]]>
    </script>
