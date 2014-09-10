/** Geoglists and other utility functions **/

 String.prototype.ucwords = function(){ //v1.0

    return this.replace(/\w+/g, function(a){
        return a.charAt(0).toUpperCase() + a.substr(1).toLowerCase();
       });

    };


   function getDateSetting(theyear, themonth, theday){
       return (new Date(theyear + "/" + themonth + "/" + theday)).getTime();
     }


    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #000',
            padding: '5px',
            'background-color': '#fee',
            opacity: 0.98
        }).appendTo("body").fadeIn(200);
    }

  var GeogLists = {


          service_url: 'services/geog_service.php',

          stfips: '41', 

          areatype: '04', 

          area: '000000', 

          include_statewide: 'y', 

          include_national: 'n', 
       
          select_list: '',

          list_size: 1,

          keep: 'n', 

          area_select: function(area, code) { return (area == code) ? 'selected="selected"' : '';},  

          getGeog: function() { 
              var options = "";
              if (this.include_national == 'y') options += '<option value="0000000000" ' + this.area_select(this.area, '000000') + ' >US</option>';
              if (this.include_statewide == 'y') options += '<option value="4101000000" ' + this.area_select(this.area, '000000') + '>Oregon</option>';
              var sl = this.select_list; 
              var ls = this.list_size;
              var kp = this.keep;
              var area_suffix = '';
              var this_funcs = this;
              if (this.areatype == '04') area_suffix = ' County';
             $.ajax({
                    url: this.service_url + '?stfips=' + this.stfips + '&areatype=' + this.areatype,
                    async: false,
                    dataType: 'json',
                    success: function(myjson){
                         var j = eval(myjson);
                         for (var i = 0; i < j.length; i++) {
                             options += '<option value="' + j[i].stfips + j[i].areatype + j[i].area +  '"' + this_funcs.area_select(this_funcs.area, j[i].area) +  ' >' + 
                                         j[i].areaname +  ' ' + area_suffix + '</option>';
                              }
                        var keeplist = "";
                        if (kp == 'y') keeplist = $("select#" + sl).html(); 
                        $("select#" + sl).html(keeplist + options);
                        $("select#" + sl).attr("size", ls);
                       } 
                });

               }



   } // GeogLists

  

