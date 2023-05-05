<?
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	
	$start_time_counter = date("YmdHis");
	include("../../lib/function.php");
	include("../../lib/user_config.php");
	include("../../lib/connect.php");
	/*
	include("../../../ewt_block_function.php");
	include("../../../ewt_menu_preview.php");
	include("../../../ewt_article_preview.php");
	include("../../../ewt_public_function.php");
	*/ 	
	//$UserPath = "\\\\192.168.0.250\\ictweb\\";
	//$Website = "http://192.168.0.250/ewtadmin/ewt/ictweb/";  ย้ายไปไว้ใน config.inc.php ของเราแล้ว
	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";  อาจไม่ต้องใช้ ฐานข้อมูลลูกค้าเลย  เพราะเราอ่านข้อมูลจากหน้าเวบ url โดยตรง
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "../";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	include ($path.'include/class_application.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    $CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?
	if($_GET["solution_id"]==1) {  // ถ้าเลือกทางแก้เป็น การครอบด้วย Start-Tag
						// ให้เลือกว่าจะครอบด้วย Start-Tag อะไร
				$sql_tag_allow = " SELECT  *  FROM  tag_canbe_inside  WHERE  tag_name = '".$_GET["text_tag"]."' ORDER BY start_tag ";
				
				if( strtoupper($_GET["text_tag"])=="TABLE" || strtoupper($_GET["text_tag"]) =="P" ) {
						$default_stag = "map";
				}
				?><br>Start-Tag :	<select name="start_tag<?=$_GET["runvar"];?>" >
					<option value="">==เลือก==</option>
					<? $disp->ddw_list_selected($sql_tag_allow,"start_tag", "start_tag", $default_stag); ?>
					</select>
					<?
	} else if($_GET["solution_id"]==2) {	 // ย้าย tag พร้อมข้อมูล ไปไว้ ก่อน ตำแหน่ง tag ที่เท่าไร
	
				$sql_webtag = " SELECT  text_id, text_tag, text_value, text_rank  FROM  web_tag  WHERE filename = '".$_GET["filecheck"]."' AND db_name = '".$_GET["main_db"]."'  AND ( text_status <> 'del' OR text_status is null )   ORDER BY text_rank ";
				$exec_webtag = $db2->query($sql_webtag);
				?><br>
				<input name="move_status<?=$_GET["runvar"];?>" type="radio" value="before" checked="checked" onclick=" if(this.checked) { document.getElementById('in_tag<?=$_GET["runvar"];?>').value=''; } "> ย้ายไปไว้ก่อน Tag : <select name="b_tag<?=$_GET["runvar"];?>" id="b_tag<?=$_GET["runvar"];?>" >
					<option value="">==เลือก==</option>
					<? //$disp->ddw_list_selected($sql_webtag,"text_tag", "text_id"); 
					while($rec_webtag = $db2->fetch_array($exec_webtag)) {
					?><option value="<?=$rec_webtag[text_id];?>"><?=$rec_webtag[text_tag]; if(trim($rec_webtag[text_value])) { echo " (".substr($rec_webtag[text_value],0,10); 
					if(strlen(trim($rec_webtag[text_value])) > 10 ) echo "...";
					echo " ) "; } ?></option>
					<? } ?>
					</select><br>
				<input name="move_status<?=$_GET["runvar"];?>" type="radio" value="inside" onclick=" if(this.checked) { document.getElementById('b_tag<?=$_GET["runvar"];?>').value=''; } " > ย้ายไปข้างใน Tag : <select name="in_tag<?=$_GET["runvar"];?>" id="in_tag<?=$_GET["runvar"];?>" >
					<option value="">==เลือก==</option>
					<?   $db2->data_seek($exec_webtag,0);
					while($rec_webtag = $db2->fetch_array($exec_webtag)) {
					?><option value="<?=$rec_webtag[text_id];?>"><?=$rec_webtag[text_tag]; if(trim($rec_webtag[text_value])) { echo " (".substr($rec_webtag[text_value],0,10); 
					if(strlen(trim($rec_webtag[text_value])) > 10 ) echo "...";
					echo " ) "; } ?></option>
					<? } ?>
					</select><br>
				<input name="move_status<?=$_GET["runvar"];?>" type="radio" value="last" onClick="if(this.checked) { document.getElementById('b_tag<?=$_GET["runvar"];?>').value=''; document.getElementById('in_tag<?=$_GET["runvar"];?>').value=''; } " > ย้ายไปท้ายสุด
					<?
	}
?>
