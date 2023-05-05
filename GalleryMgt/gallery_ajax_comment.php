<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<table width="600" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <th height="20" colspan="2" bgcolor="#5599CC" scope="col"><strong style="color:#FFFFFF">ความคิดเห็น</strong></th>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF"><br />
<?php
		
			if($_POST[page]) $page = $_POST[page];
			else $page = $_GET[page];
			
			if($_POST[category_id]) $category_id = $_POST[category_id];
			else $category_id = $_GET[category_id];
			
			if($_POST[img_id]) $img_id = $_POST[img_id];
			else $img_id = $_GET[img_id];
			
			if($_POST[limit]) $limit = $_POST[img_id];
			else $limit = $_GET[limit];
			
			if(!$limit) $limit = 5;
			if($page == '' || $page < 1)$page =1;
			$page1=$page-1;
			if($page1 == '' || $page1 < 0)$page1 =0;

	
		$sql_comment = "SELECT * FROM gallery_comment WHERE category_id = '".$category_id."' AND img_id = '".$img_id."' order by choice desc";
		$query_comment = $db->query($sql_comment);
		$num_comment = $num_all = $db->db_num_rows($query_comment);
		
		
		if($num_all%$limit==0){
		@$page_all = $num_all/$limit;
		}else{
			@$page_all = (int)($num_all/$limit)+1;
		}
		if($page_all==0) $page_all = 1;
		if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
		$sql_2 = $sql_comment."  limit ".$page1*$limit.",$limit";
		$query = $db->query($sql_2);
		$num_rows_2 = $db->db_num_rows($query);
		
		if($num_rows_2 > 0){
			for($i=1;$i<=$num_rows_2;$i++){
				$rs_comment = $db->db_fetch_array($query);
				$date_time = explode(" ",$rs_comment[com_date]);
				$date =  explode("-",$date_time[0]);
				$date = $date[2]."/".$date[1]."/".($date[0]+543);
				
				$date_time_full = " วันที่ ".$date." เวลา ".$date_time[1];
	?>
      <table width="580" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#EBEBEB">
          <tr>
            <td width="580"><div align="left"><strong>&nbsp;ความคิดเห็นที่
              <?php echo $rs_comment[choice]?>
              : คุณ
              <?php echo $rs_comment[name]?>
              &nbsp;&nbsp;&nbsp;
              <?php echo $date_time_full?>
            </strong></div></td>
          </tr>
          <tr>
            <td width="580"><div align="left"> &nbsp;&nbsp;&nbsp;
                    <?php echo str_replace("\n","<br>",$rs_comment[comment])?>
            </div></td>
          </tr>
        </table>
      <br />
        <?php 
		}
		?>
        <table width="580" border="0" align="center" bgcolor="#FFFFFF">
          <tr>
            <th width="580"><div align="right">หน้าที่
              <select name="page" onchange="var url = 'gallery_ajax_comment.php?page='+this.value+'&amp;category_id=<?php echo $category_id?>&amp;img_id=<?php echo $img_id?>&limit=<?php echo $limit?>';  load_divForm(url,'div_comment','');">
                      <?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
                    </select>
              /
              <?php echo $page_all?>
              หน้า</div></th>
          </tr>
        </table>
        <?php
	}else{
	?>
        <br />
        <table width="580" border="0" align="center" bgcolor="#EBEBEB">
          <tr>
            <th width="580"><div align="center"><strong style="color:#FF0000"> ไม่มีความคิดเห็น </strong></div></th>
          </tr>
        </table>
      <?php }?>
        <br /></td>
  </tr>
</table>
