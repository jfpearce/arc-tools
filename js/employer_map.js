/** Employer Database Mapping functions */

var map = '';
var map_state = 'none';
var map_count = 0;

function makeMap() {

     $("#map_message").hide();
     $("#map_canvas").show();
     $("#map_canvas").css("width", "630px");
     $("#map_canvas").css("height", "300px");
     
     var mapLatlng = new google.maps.LatLng(45.56790980571085, -122.69531292187501);
          var mapOptions = {
      // zoom: (($('#areacode').attr('value').substring(2,4) == '01') ? 6 : 8),
      center: mapLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    var data_id = jQuery("#list").getDataIDs();
    var centerpoint = "";
    var markers = "";
    var sep = "";
    var distance = 0;
    var lat1 = 0;
    var lon1 = 0;
     for (var i = 0; i < data_id.length; i++) {
            var ret = jQuery("#list").getRowData(data_id[i]);
            mapEmployer(ret, map, i);
            markers += sep + ret.Latitude + ',' + ret.Longitude;
            centerpoint = ret.Latitude + ',' + ret.Longitude;
            sep = "|";
            distance = maxDistanceBetweenLatLon(lat1, lon1, ret.Latitude, ret.Longitude, distance);
            lat1 = ret.Latitude;
            lon1 = ret.Longitude;
           }
     makePrintLink(markers, centerpoint, setZoomLevel(distance));
     map.setZoom(setZoomLevel(distance));
} //makeMap()


function mapEmployer(ret, map, i) {
       var message = '<a href="" onclick="getEmpdbPage(' + ret.ID + '); return false">' +ret.Name+'</a><br/>' +
                           ret.Address + '<br/>' + ret.City;
       var llpos = new google.maps.LatLng(ret.Latitude, ret.Longitude);
       var marker = new google.maps.Marker({
                     position: llpos, 
                     map: map,
                     title: ret.Name}); 
       attachInfoWindow(map, marker, message, i);
       map.setCenter(llpos);
} //mapEmployer

function makePrintLink(markers, centerpoint, zoomlevel){
  /* var zoomlevel = ($('#areacode').attr('value').substring(2,4) == '01') ? 6 : 8;
     if ($('#thezip').attr('value') != '') zoomlevel = 13;
  */
     var prod_key = "ABQIAAAAy2Q1iHBEuAsl40bPKALDDBQhsISthwkmhnFn4kLFkBSH4y6M3hSbs9c7ZDOY3ijjBzXA9DsLwrnC4Q";
     var dev_key  = "ABQIAAAAy2Q1iHBEuAsl40bPKALDDBReoD5IGgKLT_aFxiVQ3FbCIBAIORRYQsBOYYLqxRZSPSTAk5w_vFuovQ";
     var ws_key =   "ABQIAAAAy2Q1iHBEuAsl40bPKALDDBRfSsjKY_Y98cveIzM6pNTPKUWKWhQ_r8ewe58EfkmTyi1JF4lp-UNy9Q";
     var hostname = window.location.hostname;
   key = 'xxx';
   if      (hostname == 'www.qualityinfo.org') key = prod_key;
   else if (hostname == 'olmis-dev.emp.state.or.us') key = dev_key;
   else if (hostname == '10.1.43.59') key = ws_key; 
   else ;
   var printurl = 'http://maps.google.com/staticmap?center=' + centerpoint + '&markers='+ markers + ',red&zoom=' + zoomlevel + '&size=600x600&key=' + key;	
   $('#map_print').html('<a href="' + printurl + '" target="top" alt="Print Map">Print Map</a>');	
   $('#map_print').show();	
}

function setZoomLevel(distance) {
  var z = 6;
  if      (distance < 10) z = 13;
  else if (distance < 20) z = 12;
  else if (distance < 30) z = 11;
  else if (distance < 50) z = 10;
  else if (distance < 80) z = 9;
  else if (distance < 150) z = 8;
  else if (distance < 200) z = 7;
  else z = 6;
  return z;

}


function maxDistanceBetweenLatLon(lat1, lon1, lat2, lon2, distance) {
  if (lat1 == 0) return distance;
  else {
     var R = 6371; // Earth size
     var dLat = toRad(lat2-lat1);
     var dLon = toRad(lon2-lon1); 
     var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
             Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
             Math.sin(dLon/2) * Math.sin(dLon/2); 
     var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
     var d = R * c;
     return Math.max(d, distance);
     }
}

function toRad(latlon) {
 /* Conver latlon degrees to Radians */
 return (latlon / 180) * Math.PI;

}


function makeNearestMap() {
 map_state = 'nearest';
 geocodeAddress($("#c_address").attr('value'));
  $("#map_canvas").show();
  $("#map_message").fadeIn('slow');
  $('#showeid').html('<input class="sbutn" type="submit" id="procgo" name="keyg" value="Map Employers" onclick="makeNearestMap() ; return false" />');
} //makeNearestMap()


function makeNearestMaptoAddress(mapLatlng) {

   //  $("#map_canvas").css("width", "85%");
   //  $("#map_canvas").css("height", "60%");

     $("#map_canvas").css("width", "630px");
     $("#map_canvas").css("height", "300px");
     
     var mapOptions = {
      zoom: 8,
      center: mapLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    processNearestReq(document.forms['locateform'], mapLatlng.lat(), mapLatlng.lng());


   var gYellowIcon = new google.maps.MarkerImage(
      "http://chart.apis.google.com/chart?cht=mm&chs=32x32&chco=FFFF00FF,FFFF00FF,000000FF&ext=.png",
      new google.maps.Size(32, 32),
      new google.maps.Point(0, 0),
      new google.maps.Point(16, 16));

   var gRedIcon = new google.maps.MarkerImage(
      "http://chart.apis.google.com/chart?cht=mm&chs=32x32&chco=FF0000FF,FF0000FF,000000FF&ext=.png",
      new google.maps.Size(32, 32),
      new google.maps.Point(0, 0),
      new google.maps.Point(16, 16));



    var marker = new google.maps.Marker({
                     position: mapLatlng, 
                     map: map,
                     title:"Center Point",
                     icon: gYellowIcon,
                     draggable: true}); 


    google.maps.event.addListener(marker, 'dragstart', function() {
        marker.setOptions({icon: gRedIcon});
    });


    google.maps.event.addListener(marker, 'dragend', function() {
       var latlng = marker.getPosition();
       marker.setOptions({icon: gYellowIcon});
       processNearestReq(document.forms['locateform'], latlng.lat(), latlng.lng());
   });



    

}

  function attachInfoWindow(map, marker, message, number) {
   
             var infowindow = new google.maps.InfoWindow({
                    content: message,
                      zIndex: number
              });

             google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
             });
        

  }



 function geocodeAddress(addr) {
   var geocoder = new google.maps.Geocoder();
   geocoder.geocode({
    address: addr
  }, function(responses) {
      
    if (responses && responses.length > 0) {
       makeNearestMaptoAddress(responses[0].geometry.location);
    } else {
      makeNearestMaptoAddress(new google.maps.LatLng(45.56790980571085, -122.69531292187501));
    }
  });
}
