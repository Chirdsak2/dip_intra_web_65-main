<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language.php");

$sql = $db->query("SELECT v_images,v_width,v_height FROM virtual_list WHERE v_id = '".$_GET["vid"]."' ");
$R = $db->db_fetch_row($sql);

					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$R[0])) {
						$img = "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$R[0];
					}else{
						$img = "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$R[0];
					}
					
	if($_GET["sid"] != ""){
		$sqls = $db->query("SELECT * FROM virtual_spot WHERE s_id = '".$_GET["sid"]."' ");
		$S = $db->db_fetch_array($sqls);
		$x1 = $S[s_x1];
		$x2 = $S[s_x2];
		$y1 = $S[s_y1];
		$y2 = $S[s_y2];
	}else{
		$x1 = 10;
		$x2 = 210;
		$y1 = 10;
		$y2 = 160;
	}
?>

<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
	<script src="../js/prototype.js" type="text/javascript"></script>	
 	<script src="../js/scriptaculous.js?load=builder,dragdrop" type="text/javascript"></script>
	<script src="../js/cropper.js" type="text/javascript"></script>
	
	
	<script type="text/javascript">
		
		// setup the callback function
		function onEndCrop( coords, dimensions ) {
			$( 'x1' ).value = coords.x1;
			$( 'y1' ).value = coords.y1;
			$( 'x2' ).value = coords.x2;
			$( 'y2' ).value = coords.y2;
			$( 'width' ).value = dimensions.width;
			$( 'height' ).value = dimensions.height;
		}
		
		// basic example
		Event.observe( 
			window, 
			'load', 
			function() { 
				new Cropper.Img( 
					'testImage',
					{
						onEndCrop: onEndCrop ,
						displayOnInit: true,
						onloadCoords: { x1: <?php echo $x1; ?>, y1: <?php echo $y1; ?>, x2: <?php echo $x2; ?>, y2: <?php echo $y2; ?> }
					}
				) 
			}
		); 		
		
		
		if( typeof(dump) != 'function' ) {
			Debug.init(true, '/');
			
			function dump( msg ) {
		//		Debug.raise( msg );
			};
		} else dump( '---------------------------------------\n' );
		
		
	</script>
		<style type="text/css">
		label { 
			clear: left;
			margin-left: 50px;
			float: left;
			width: 5em;
		}
		
		html, body { 
			margin: 0;
		}
		
		#testWrap {
			margin: 0px 0 0 0px; /* Just while testing, to make sure we return the correct positions for the image & not the window */
		}
	</style>
	<script type="text/javascript">
	function chkfrm(){
		if(document.form1.s_name.value == ""){
			alert("Please insert Hot-spot name!");
			document.form1.s_name.focus();
			return false;
		}
		if(document.form1.ctype[2].checked==false){
			if(document.form1.s_link.value == ""){
				alert("Please insert Hot-spot link!");
				document.form1.s_link.focus();
				return false;
			}
		}
	}
	</script>
</head>

<body topmargin="0" leftmargin="0">
	<div id="testWrap"  align="center"  style="HEIGHT: 350;OVERFLOW-X: scroll;OVERFLOW-Y: scroll;WIDTH: 100%;margin-right:scroll; margin-left:scroll;position:relative;">
<img id="testImage" src="<?php echo $img; ?>" border="1">
</div>
	<br>
	<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
      <form action="virtual_function.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkfrm();">
	  <tr class="ewttablehead">
        <td colspan="2" >ตั้งค่า Hot-spot 
		<p style="display:none">
		<label for="x1">x1:</label>
		<input type="text" name="x1" id="x1" value="<?php echo $x1; ?>" />
	
		<label for="y1">y1:</label>
		<input type="text" name="y1" id="y1"   value="<?php echo $y1; ?>" />
	
		<label for="x2">x2:</label>
		<input type="text" name="x2" id="x2"   value="<?php echo $x2; ?>"/>
	
		<label for="y2">y2:</label>
		<input type="text" name="y2" id="y2"  value="<?php echo $y2; ?>" />
	
		<label for="width">width:</label>
		<input type="text" name="width" id="width" />
	
		<label for="height">height</label>
		<input type="text" name="height" id="height" />
	</p>		</td>
      </tr>
      <tr>
        <td width="34%" valign="top" bgcolor="#FFFFFF">ชื่อ Hot-spot </td>
        <td width="66%" valign="top" bgcolor="#FFFFFF">
            <input name="s_name" type="text" id="s_name" size="40" value="<?php echo $S["s_name"]; ?>">		</td>
      </tr>
	  <tr>
        <td valign="top" bgcolor="#FFFFFF">การเชื่อมต่อ</td>
        <td valign="top" bgcolor="#FFFFFF">
		<?php
		if($S["s_type"] =='VIRTUAL'){
		$virtual_id =$S["s_link"] ;
		$S["s_link"] = '';
		}
		?>
          <input name="ctype" type="radio" value="class=thickbox" <?php if($S["s_id"] == "" OR $S["s_type"] == "class=thickbox"){ echo "checked"; } ?>> 
          รูปภาพแบบขยาย
          <br>

		  <input name="ctype" type="radio" value="" <?php if($S["s_id"] != "" AND $S["s_type"] == ""){ echo "checked"; } ?>> 
          Link <br>
          <input name="s_link" type="text" value="<?php echo $S["s_link"]; ?>" size="40" >
          <img src="../images/i_folder_on.jpg" width="16" height="16" align="absmiddle" style="cursor:pointer" onClick="window.open('../FileMgt/link_index.php?stype=link&Flag=Link&o_value=window.opener.document.form1.s_link.value','','width=800,height=600,resizable=1');">	    <br><br><input name="ctype" type="radio" value="VIRTUAL" <?php if($S["s_id"] != "" AND $S["s_type"] == "VIRTUAL"){ echo "checked"; } ?>>  
        เลือกจากข้อมูล Virtual <img src="../images/i_folder_on.jpg" width="16" height="16" align="absmiddle" style="cursor:pointer" onClick="window.open('virtual_choose.php','list_choose','width=800,height=600,scrollbars=1,resizable=1');document.form1.ctype[2].checked=true;">
        <input type="hidden" name="virtual_id" value="<?php echo $virtual_id;?>">
        <br>        <span id="listid"></span></td>
      </tr>
	  
      <tr>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="top" bgcolor="#FFFFFF"><select name="s_target" id="s_target">
          <option value="_self" <?php if($S["s_target"] == "_self"){ echo "selected"; } ?>>Self</option>
          <option value="_blank" <?php if($S["s_target"] == "_blank"){ echo "selected"; } ?>>Blank</option>
        </select>        </td>
      </tr>
	  <tr>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="top" bgcolor="#FFFFFF">
          <input type="submit" name="Submit" value="Submit">
          <input type="reset" name="Submit2" value="Reset"><input name="Flag" type="hidden" id="Flag" value="MSpot" ><input name="vid" type="hidden" id="vid" value="<?php echo $_GET["vid"]; ?>" ><input name="sid" type="hidden" id="sid" value="<?php echo $_GET["sid"]; ?>" ></td>
      </tr>
      </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>