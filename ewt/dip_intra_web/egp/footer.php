<div id="box_popup" class="layer-modal"></div>
<!--<footer class="footer panel-footer fix navbar-fixed-bottom">
<div class="container">
<p>© Copyright © 2018, สำนักงานปลัดกระทรวงการท่องเที่ยวและกีฬา เลขที่ 4 ถนนราชดำเนินนอก แขวงวัดโสมนัส เขตป้อมปราบศัตรูพ่าย กรุงเทพฯ 10100</p>
</div>
</footer>-->
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" src="../js/loadcalendar.js"></script>
<script type="text/javascript" src="../js/calendar-en.js"></script>
 <link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script>
  function boxPopup(link)
  {
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
  
  $(".datepicker").each(function() {//ปฏิทิน
			var date_for = $(this).attr("for");
			$('span[for='+date_for+']').attr('data-date', $('#'+date_for).val());
			
			$("span[for="+date_for+"]").datepicker({
				language: "th-th"
			});
			$("span[for="+date_for+"]").on("changeDate", function (e){//onchangeDate
				$('#'+date_for).val(e.format('dd/mm/yyyy'));
				$('span[for='+date_for+']').datepicker('hide');
			});
			$("#"+date_for).on("keyup", function (e){//onkeyup
				beginchk(this,e,this.id);
			});
		});
</script>
</body>
</html>
<script type="text/javascript">
/*var	url='../egpfeed.php';
var data = {t:"page"};
	$.get(url,data,function(req){
	});*/	
</script>