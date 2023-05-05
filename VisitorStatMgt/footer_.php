</div>

<?php include("../EWT_ADMIN/panel-footer.php");?>
<a href="#" class="scrollup" style="display: none;"><i class="fas fa-chevron-circle-up scrollup-icon color-ewt"></i></a>	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!--<script src="<?=$IMG_PATH;?>js/bootstrap.js"></script>-->
<script src="<?=$IMG_PATH;?>js/bootstrap.js"></script>

<script>
function myMap() {
  var myCenter = new google.maps.LatLng(13.733333,100.5);
  var mapCanvas = document.getElementById("map");
  var mapOptions = {center: myCenter, zoom: 2};
  var map = new google.maps.Map(mapCanvas, mapOptions);
  var marker = new google.maps.Marker({position:myCenter});
  marker.setMap(map);

  var infowindow = new google.maps.InfoWindow({
    content: "Thailand"
  });
  infowindow.open(map,marker);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDAmMDUALjOeeqskEQ9FHFIpIFkaCkltig"></script>
<script>
var map;

var places = [
['Chainat', 15.1851971, 100.125125],
['CHANGMAI', 18.7060641, 98.9817163]
];

function initialize() {
var mapOptions = {
zoom: 2,
center: new google.maps.LatLng(13.733333, 100.5)
}
var map = new google.maps.Map(document.getElementById('map'),mapOptions);
setMarkers(map, places);

}

function setMarkers(map, locations) {
for (var i = 0; i < locations.length; i++) {
var place = locations[i];
var myLatLng = new google.maps.LatLng(place[1], place[2]);
var marker = new google.maps.Marker({
position: myLatLng,
title: place[0]
});
marker.setMap(map);
}
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpimlvtQdXpK6GSw7lsDOXnJeX-m0cldA&callback=initMap" async defer ></script-->
<script type="text/javascript">

$(document).ready(function(){ 
	$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
							
});

</script>
<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

<script src="../js/bootstrap-datepicker/js/bootstrap-datepicker-custom.js"></script>
<script src="../js/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js"></script>
<script>
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	
});

function getRefresh(){	
	$("#chartonline").load("chart_online.php", '', callback);
}
function callback() {
	window.setTimeout("getRefresh();", 18000);
}
function getRefreshSes(){	
	$("#sessiononline").load("session_online.php", '', callbackSes);
}
function callbackSes() {
	window.setTimeout("getRefreshSes();", 1000);
}
function getRefreshSesSO(){	
	$("#so_").load("so_session.php", '', callbackSesSO);
}
function callbackSesSO() {
	window.setTimeout("getRefreshSesSO();", 1000);
}
$(document).ready(getRefresh);
$(document).ready(getRefreshSes);
$(document).ready(getRefreshSesSO);
/*$(document).ready(function () {
var url = 'chart_online.php';  
  
//$('#div-online').load(url); 

setTimeout(function(){										
  $("#chartonline").load(url);
	}, 1000);
	
});*/

</script>

<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 
	
<script>

function isNumberInt(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            //(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            //(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    

function boxPopup(link){
    $.ajax({
      type: 'GET',
      url: link,
      beforeSend: function() {
        $('#box_popup').html('');
      },
      success: function (data) {
        $('#box_popup').html(data);
      }
    });
	
    $('#box_popup').fadeIn();
  }
  
</script>

<!-- Counter -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/waypoints.js"></script>
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/jquery.counterup.js"></script>

<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>