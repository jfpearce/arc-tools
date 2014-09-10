/** Occupational Drilldown and search functions **/


  var previous_links = new Array();

   function getSearchSocData(){
         return "services/occ_service.php?servicetype=data?soccode=000000&title=" + $("#socsearch").attr('value');}

  function getSearchSoc() {
       $.getJSON(getSearchSocData(), function(j){
                var alltext = '<a href="" onclick="getSoc(' + "'000000'," +
                         "'All Occupations'," + 0 +  ') ; return false">Return to Drill</a><br/>';
                var htmltext = "";
                $("#selocc").html('');
                for (var i = 0; i < j.length; i++) {
                     htmltext += getOccLink(j[i].soccode, j[i].soctitle, 1);
                     }
                $("#occdrill").html(alltext + htmltext);
       }) 

    } //getSearchSoc

    function getChildSocData(parent_soc){
         return  "services/occ_service.php?servicetype=child&socparent=" + parent_soc;}

   function getSoc(parent_soc, occtitle, occlevel) {
         $.getJSON(getChildSocData(parent_soc), function(j){
              var htmltext = "";
                for (var i = 0; i < j.length; i++) {
                     var newlevel = occlevel + 1;
                    htmltext += getOccLink(j[i].soccode, j[i].soctitle, newlevel);
                    }
               if (htmltext == '') {
                   getOccReport(parent_soc);
                   $("#occfind").hide();
                   $('#slink').show()
                }
               else {
                     $("#selocc").html('');
                     $("#occdrill").html(getPrevious_links(occlevel, occtitle, parent_soc) + htmltext) ;
                     }
      }) 
    } // getSoc

     function getPrevious_links(level, occtitle, occcode) {
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
         return '<span ' + cssclass + '>' + getSpaces(newlevel) + '</span><a href="" onclick="getSoc(' + "'" + soccode + "'," +
                                          "'" + soctitle + "'," + newlevel + ') ; return false">' + soctitle + '</a><br/>';
    }

    function getSpaces(level){
       var sp = "&nbsp;";
       for (var i = 0; i < level; i++) {
          sp += " &nbsp; ";
        }
      return sp;
    }

    function resetSearchSoc() {
         $("#socsearch").attr('value', '');
         $("#selocc").html('');
         getSoc('000000', 'All Occupations', 0);
    };

    function getOccReport(occcode) {
            var areacode = $("#areacode").attr('value');
            var stfips = areacode.substring(0,2);
            var areatype = areacode.substring(2,4);
            var area = areacode.substring(4,10);
           $.ajax({
            url: 'services/occ_report.php?stfips=' + stfips + '&areatype=' + areatype + '&area=' + area + '&soccode=' + occcode,
            cache: false,
            dataType: 'html',
            success: function(htmlDoc){
             $("#selocc").html(htmlDoc);
           } // success
        }) // $ajax
     } // getEmdbPage


    jQuery.fn.occmenu = function() {
           this.html('Initializing. . . ');
           getSoc('000000', 'All Occupations', 0);
    };


