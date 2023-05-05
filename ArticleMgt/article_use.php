<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
		
function countparent($c,$ppms){
global $db,$EWT_DB_USER,$y;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"],$ppms);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND (
	   (s_type = 'Ag' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_parent"]."' ) 
	  ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  $db->query("use ".$_SESSION["EWT_SDB"]);
  return $y;
}
		if($_GET["cid"] != ""){
		
$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["cid"]."'");
$G = $db->db_fetch_array($sql_group);

 }
function countchild($c){
global $db;

$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild($U["c_id"]);
	$x += $c;
	$x++;
  }
  return $x;
}
function countchild2($c){
global $db;

$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild2($U["c_id"]);
	$x += $c;
	$sql2 = $db->query("SELECT COUNT(n_id) FROM article_list WHERE n_approve = 'Y' AND c_id = '".$U["c_id"]."' ");
	$C = $db->db_fetch_row($sql2);
	$x += $C[0];
  }
  return $x;
}

 function findparent($id){
	 global $db;
	 $sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
	 	if($db->db_num_rows($sql)){
	 		$G = $db->db_fetch_array($sql);
			$txt = " <a href = \"article_use.php?cid=".$G["c_id"]."\">".$G["c_name"]."</a> &gt;&gt; ";
			if($G[c_parent] != "0" AND $G[c_parent] != ""){
				$txt = findparent($G[c_parent]).$txt;
			}		
	 	}
		return $txt;
	 }


 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}


	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 

<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/logo_biz.png"/>

<!-- bootstrap 3.3.7 -->
<link href="../EWT_ADMIN/css/bootstrap.css" rel="stylesheet"/>
<!-- END -->

<!-- Main Style -->
<link href="../EWT_ADMIN/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/backend_style.css"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/icons.css"/>
<!-- END -->
<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>
<script language="JavaScript">
function Editfile(c){
			
				if(self.parent.module_obj.document.formTodo.stype.value =="link"  && self.parent.module_obj.document.formTodo.Flag.value == "Link" ){
					sendfile(c);
				}else if(self.parent.module_obj.document.formTodo.Flag.value == "LinkReturn" ){
					 if(navigator.appName.indexOf('Microsoft')!=-1)
									 window.returnValue = c;
								else
									window.opener.setAssetValue(c);
									
									self.close();
				}else{
					return true;
				}
			}
						function sendfile(c){
					self.parent.module_obj.document.formTodo.objfile.value = c;
					self.parent.module_obj.document.formTodo.target = "_top";
					self.parent.module_obj.document.formTodo.action = "module_confirm.php";
					self.parent.module_obj.document.formTodo.submit();
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<div class="container-fluid" >
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered">
  <tr> 
    <td>
	<span class="ewtfunction">
	<a href="article_use.php?cid=0">หน้าหลัก</a>  &gt;&gt;  <?php echo findparent($G["c_parent"]); ?> 
      <a href="article_use.php?cid=<?php echo $G["c_id"]; ?>"><?php echo $G["c_name"]; ?></a> </span>
<hr>
    </td>
  </tr>
</table>
<br>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="table table-bordered">
  <tr> 
    <form name="form2" method="get" action="article_use.php" >
      <td class="form-inline"> ค้นหา : 
        <input name="search_txt" type="text" value="<?php echo $_GET["search_txt"];?>" size="50" class="form-control" style="width:50%;" />
        <input type="submit" name="Submit" value="ค้นหา" class="btn btn-success">
		<input name="serach_flag" type="hidden" value="<?php echo $_POST["serach_flag"];?>">
      </td>
    </form>
  </tr>
</table>
<br>
<?php
$sql_search = "SELECT * FROM article_group WHERE c_id != '0' ";
	if($_GET["cid"] != ""){
		$sql_search .= " AND c_parent = '".$_GET["cid"]."' ";
	}
		if($_GET["search_txt"] != ""){
		$sql_search .= " AND c_name REGEXP '".$_GET["search_txt"]."' ";
	}
	$sql_search .= " ORDER BY c_id ASC";

$sql_article = $db->query($sql_search);
if($db->db_num_rows($sql_article) > 0){
?>
<table  width="90%"  border="0" align="center" class="table table-bordered">
<tr class="success"  style="font-size:13px;">
      <th width="10%" height="18" align="center">&nbsp;</th>
      <th width="90%" height="18" align="center" class="text-center">ชื่อกลุ่มข่าว/บทความ</th>
</tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 	$S_count = $db->query("SELECT COUNT(n_id) FROM article_list WHERE n_approve= 'Y' AND c_id = '$G[c_id]' "); 
	$C = $db->db_fetch_row($S_count);
	?>
    <tr bgcolor="#FFFFFF"  style="font-size:13px;"> 
      <td align="center"><nobr>
        <input class="btn btn-info" name="Button" type="button" value="เลือก" OnClick="Editfile('more_news.php?c_id=<?php echo $G["c_id"]; ?>');">
        </nobr></td>
      <td height="25" valign="top"> <img src="../theme/main_theme/g_folder_closed.gif" alt="news folder" width="16" height="16" align="absmiddle"><a href="#article" onClick="self.location.href='article_use.php?cid=<?php echo $G["c_id"]; ?>';"> 
        <?php echo $G["c_name"]; ?> <font color="#666666">[ 
        <?php $numfolder = countchild($G["c_id"]); echo number_format($numfolder,0); ?>
        หมวด <?php echo number_format($C[0] + countchild2($G["c_id"]),0); ?> บทความ]</font></a> 
      </td>
    </tr>
    <?php  }
 ?>
</table>

<?php
}

	$sql_query = "SELECT n_id,n_topic,n_date,n_new_modi,n_last_modi,n_owner,news_use,n_share,n_shareuse,n_sharename,n_approve,c_id,link_html FROM article_list WHERE  n_approve = 'Y' and n_id != '' ";
		if($_GET["cid"] != ""){
		$sql_query .= " AND c_id = '".$_GET["cid"]."' ";
		}
		if($_GET["search_txt"] != ""){
		$sql_query .= " AND n_topic REGEXP '".$_GET["search_txt"]."' ";
		}
		$sql_article = $sql_query." ORDER BY n_date DESC,n_timestamp DESC LIMIT $offset,$limit ";
	 $sql_article = $db->query($sql_article);
	 if($db->db_num_rows($sql_article) > 0){
?><br>
<table width="90%" border="0" align="center"  class="table table-bordered">
<tr class="success"  style="font-size:13px;">
	<th width="10%" align="center" >&nbsp;</th>
      <th width="10%" align="center" >วันที่</th>
      <th width="60%"  height="18" align="center" >หัวข้อข่าว/บทความ</th>
      <th width="10%" align="center" >ผู้สร้าง</th>
      <th width="10%" align="center" >สร้าง</th>
</tr>
    <?php
	$i = 0;
	$rows = $db->db_num_rows($db->query($sql_query));
		  $nu = $rows-$offset;
	 while($N = $db->db_fetch_array($sql_article)){ 
	$date = explode("-",$N["n_date"]);
	if($N["n_new_modi"] != ''){
	$n_new_modi_Y=substr($N["n_new_modi"], 0, 4);    
	$n_new_modi_M=substr($N["n_new_modi"], 4, 2);   
	$n_new_modi_D=substr($N["n_new_modi"], 6, 2);   
	$date_create_f =$n_new_modi_D."/".$n_new_modi_M."/".($n_new_modi_Y+543);
	}else{
	$date_create_f  = '-';
	}
	if($N["n_last_modi"] != '' && $N["n_new_modi"] != ''){
	$n_last_modi_Y=substr($N["n_last_modi"], 0, 4);    
	$n_last_modi_M=substr($N["n_last_modi"], 4, 2);   
	$n_last_modi_D=substr($N["n_last_modi"], 6, 2);   
	$date_modi_f = $n_last_modi_D."/".$n_last_modi_M."/".($n_last_modi_Y+543);
	}else{
	$date_modi_f  ='-';
	}
	if($N["n_owner"] == 0 || $N["n_owner"] == ''){
	$owner = 'Web Admin';
	}else{
	$db->query("USE ".$EWT_DB_USER);
	$sql_chk = "SELECT name_thai,surname_thai,org_sort
							FROM
							  `gen_user`
							  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
							  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
							  where  gen_user_id ='".$N["n_owner"]."' order by gen_user.name_thai ";
	$query = $db->query($sql_chk);
	$rec = $db->db_fetch_array($query);
	$db->query("USE ".$EWT_DB_NAME);
	$owner = $rec[name_thai].'   '.$rec[surname_thai];
		if($rec[org_sort] != ''){
			$owner .= '<br>('.$rec[org_sort].')';
		}
	}
	$group_text = "";
	if($_GET["cid"] == ""){
			 $sql_gname = $db->query("SELECT c_name FROM article_group WHERE c_id = '".$N["c_id"]."' ");
			 $GN = $db->db_fetch_row($sql_gname);
			 $group_text = "<div><a href=\"#article\" onClick=\"self.location.href='article_use.php?cid=".$N["c_id"]."';\"><img src=\"../theme/main_theme/g_folder_closed.gif\" alt=\"news folder\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"> ".$GN[0]."</a></div>";
	}
	?>
    <tr bgcolor="#FFFFFF"  style="font-size:13px;"> 
      <td height="20" align="center" valign="top" nowrap><input class="btn btn-info"  name="Button2" type="button" value="เลือก" OnClick="Editfile('news_view.php?n_id=<?php echo $N["n_id"]; ?>');"></td>
      <td height="20" align="center" valign="top"><?php echo $date[2]."/".$date[1]."/".$date[0]; ?></td>
      <td height="20" valign="top" > 
        <img src="../theme/main_theme/g_document.gif" alt="News" width="16" height="16" align="absmiddle">
        <?php if($N["n_shareuse"] != "Y"){ ?>
              <?php echo $N["n_topic"]; ?> 
        <?php  }else{ ?>
        <img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle"> 
        <font color="#666666"><?php echo $N["n_topic"]; ?></font> [From:<?php echo $N["n_sharename"]; ?>] 
        <?php } ?><?php echo  $group_text; ?></td>
		<td height="20" align="center" valign="top"><?php echo $owner; ?></td>
      <td height="20" align="center" valign="top"><?php echo $date_create_f; ?></td>	
    </tr>
    <?php $i++;$nu--; }?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
	<?php if($rows > 0){ ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="10">หน้าที่ 
        : 
        <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt'>
<< ก่อนหน้า</a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "&nbsp;[$i]&nbsp;\n\n"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt' ". 
                  " >&nbsp;$i&nbsp;</a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&cid=".$_GET["cid"]."&search_type=$search_type&search_txt=$search_txt'>
		 ถัดไป>></a>"; 
    }
?>      </td>
    </tr>
	<?php } ?>
</table>
<?php } ?><br>
<br>
</div>
</body>
</html>
<?php $db->db_close(); ?>