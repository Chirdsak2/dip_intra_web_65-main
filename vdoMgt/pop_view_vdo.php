<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$vdo_cid = (int)(!isset($_GET['vdo_cid']) ? 0 : $_GET['vdo_cid']);
$vdo_id = (int)(!isset($_GET['vdo_id']) ? 0 : $_GET['vdo_id']);

$s_vdo = $db->query("SELECT * FROM vdo_list WHERE vdo_id = '{$vdo_id}' ");
$a_video = $db->db_fetch_array($s_vdo);
?>

<div class="container">
	<span class="far fa-times-circle fa-2x" onclick="$('#box_popup').fadeOut();pauseAllVideos();" style="font-size:24px;position:absolute; top:10px; right : 20px; color:#FFFFFF;cursor:pointer;z-index:1000;"></span>
	<div class="modal-dialog modal-lg">
		<div class="modal-content-vdo">
			<?php
			if ($a_video['vdo_filename'] != "") {
				$type = "mp4";
			} else {
				$type = "youtube";
			}

			$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_video['vdo_fileyoutube']);

			$vdo_image = "../images/pic_preview.gif";
			if ($a_video['vdo_show_vdo'] == "1") {
				if ($a_video['vdo_filename'] != "") {
					//echo "<img src=\"".$vdo_image."\" alt=\"".$rec_vdo['vdo_name']."\"  title=\"".$rec_vdo['vdo_name']."\" width=\"100%\" height=\"300\"/>";		
					echo "<video class=\"mejs-wmp \" onclick=\"Func_Vdocount(" . $vid . ")\" data-vdo=\"" . $vid . "\" id=\"vplayer\" width=\"100%\" height=\"480\" src=\"../../download/file_vdo/" . $a_video['vdo_filename'] . "\" poster=\"" . $vdo_image . "\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";
				}
			} else {
				//echo "<img src=\"https://i.ytimg.com/vi/".$vdo_fileyoutube."/sddefault.jpg\" alt=\"".$rec_vdo['vdo_name']."\"  title=\"".$rec_vdo['vdo_name']."\" width=\"100%\" height=\"300\"/>";
				echo "<iframe  class=\"mejs-wmp\" onclick=\"Func_Vdocount(" . $vid . ")\"  data-vdo=\"" . $vid . "\"  allow=\"autoplay\" width=\"100%\"  height=\"480\"  src=\"https://www.youtube.com/embed/" . $vdo_fileyoutube . "?wmode=transparent&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=1&#038;mute=0\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>";
			}
			?>
		</div>
	</div>
</div>
<script type="text/javascript" src="../js/mediaelement/build/jquery.js"></script>
<script src="../js/mediaelement/build/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="../js/mediaelement/build/mediaelementplayer.min.css" />
<link rel="stylesheet" href="../js/mediaelement/build/mejs-skins.css" />

<script>
	$('audio,video').mediaelementplayer({
		//mode: 'shim',
		success: function(player, node) {
			$('#' + node.id + '-mode').html('mode: ' + player.pluginType);
			player.play();

		}
	});
</script>
<script>
	function Func_Vdocount(event) {
		console.log(event);
		$.ajax({
			type: 'POST',
			url: "count_view_vdo.php",
			data: {
				'id': event,
				'proc': 'CountVdo'
			},
			success: function(data) {
				console.log(data);

			}
		});
	}

	function pauseAllVideos() {
		$('.mejs-wmp').each(function(index) {
			$(this).attr('src', '#');
		});

	}

	function Preview(id, fileInput, type) {
		if (type == 'VDO') {
			var fileTypes = [$('#t' + type).val()];
		} else if (type == 'IMG') {
			var fileTypes = ["png", "jpg", "gif", "bmp"];
		}

		var file = $("#" + id)[0];
		var size = file.files[0].size;
		var maxsize = 314572800;
		var name = $('#' + id).val();
		var n = name.split('.');
		var m = 0;

		for (var i = 0; i < n.length; i++) {
			var v = n[1];
		}
		for (var x = 0; x < fileTypes.length; x++) {
			var f = fileTypes[x];
			if (v.match(f)) {
				var m = 1;
				document.getElementById("warning").innerHTML = "";
			}
		}
		if (m == '0') {
			var sms = "<div class=\"login col-md-12 col-sm-12 alert alert-warning\"><strong>Warning!</strong> รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง\nกรุณาเลือกรูปแบบใหม่  เช่น :\n" + fileTypes.join(", ") + "</div>";
			document.getElementById("warning").innerHTML = sms;
			//alert(sms);
			$('#' + id).val("");
			//$('#'+id).focus(); 
			scrollTo(body, 0, 100);
		}

		if (size > maxsize) {
			var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 300 MB.</div>";
			document.getElementById("warning1").innerHTML = sms1;
			$('#' + id).val("");

		} else {
			document.getElementById("warning1").innerHTML = "";
		}
	}
</script>