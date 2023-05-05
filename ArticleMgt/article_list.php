<?php
include("../EWT_ADMIN/comtop.php");
include("../class/module/article.class.php");

$article = new article();

$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);
$count_approvable = 0;

$article_list_view = $article->getAricleListView($_GET['cid'], 1);

function article_group_parent($id)
{
	global $db;

	$s_parent = $db->query("SELECT * FROM article_group WHERE c_id = '{$id}' ");
	if ($db->db_num_rows($s_parent)) {
		$a_parent = $db->db_fetch_array($s_parent);
		$txt = "<li ><a href =\"article_group.php?cid=" . $a_parent['c_id'] . "\">" . $a_parent['c_name'] . "</a></li>";
		if ($a_parent['c_parent'] != "0" and $a_parent['c_parent'] != "") {
			if($_GET['cid'] != $a_parent['c_id']){
				$txt = article_group_parent($a_parent['c_parent']) . $txt;
			}else if($_GET['cid'] == $a_parent['c_id']){
				$txt = article_group_parent($a_parent['c_parent']) . "<li>".$a_parent['c_name']."</li>";
			}
		}
	}
	return $txt;
}

?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");

	/*if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}*/
	$_SESSION["EWT_OPEN_ARTICLE"] = $_GET["cid"];

	function countparent($c, $ppms)
	{
		global $db, $EWT_DB_USER, $y;

		$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ", $_SESSION["EWT_SDB"]);
		while ($U = $db->db_fetch_array($sql)) {
			$c = countparent($U["c_parent"], $ppms);
			$y += $c;
			$sql2 = $db->query_db("SELECT s_id FROM permission 
			WHERE ((p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."') 
			OR (p_type = 'D' AND pu_id = '".$_SESSION["EWT_SMDIV"]."'))
			AND UID = '" . $_SESSION["EWT_SUID"] . "' 
			AND ((s_type = 'Ag' AND s_permission = '" . $ppms . "'  AND s_id = '" . $U["c_parent"] . "' )) ", $EWT_DB_USER);
			if ($db->db_num_rows($sql2) > 0) {
				$y++;
			}
		}
		$db->query("use " . $_SESSION["EWT_SDB"]);
		return $y;
	}

	if ($_GET['cid'] != "") {
		$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$_GET['cid']}' ");

		$pass_w = '';

		$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
		if ($db->check_permission("Ag", "w", "0") or $db->check_permission("Ag", "w", $_GET['cid'])) {
			$pass_w = 'Y';
		} else {
			if (countparent($_GET['cid'], "w") > 0) {
				$pass_w = 'Y';
			}
		}

		$pass_a = '';
		$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
		if ($db->check_permission("Ag", "a", "0") or $db->check_permission("Ag", "a", $_GET['cid'])) {
			$pass_a = 'Y';
		} else {
			if (countparent($_GET['cid'], "a") > 0) {
				$pass_a = 'Y';
			}
		}


		if ($db->db_num_rows($sql_group) == 0 and $_GET["search_txt"] == "") {
	?>
			<script>
				self.location.href = "article_group.php";
			</script>
	<?php
			exit;
		}
		$G = $db->db_fetch_array($sql_group);
	}


	function countchild($c)
	{
		global $db;

		$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
		$x = 0;
		while ($U = $db->db_fetch_array($sql)) {
			$c = countchild($U["c_id"]);
			$x += $c;
			$x++;
		}
		return $x;
	}
	function countchild2($c)
	{
		global $db;

		$sql = $db->query("SELECT c_id FROM article_group WHERE c_parent = '$c'   ");
		$x = 0;
		while ($U = $db->db_fetch_array($sql)) {
			$c = countchild2($U["c_id"]);
			$x += $c;
			$sql2 = $db->query("SELECT COUNT(n_id) FROM article_list WHERE n_approve != 'D' AND c_id = '" . $U["c_id"] . "' ");
			$C = $db->db_fetch_row($sql2);
			$x += $C[0];
		}
		return $x;
	}

	function findparent($id)
	{
		global $db;
		$sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
		if ($db->db_num_rows($sql)) {
			$G = $db->db_fetch_array($sql);
			$txt = " <a href = \"article_list.php?cid=" . $G["c_id"] . "\">" . $G["c_name"] . "</a> &gt;&gt; ";
			if ($G['c_parent'] != "0" and $G['c_parent'] != "") {
				$txt = findparent($G['c_parent']) . $txt;
			}
		}
		return $txt;
	}
	function findparent2($id)
	{
		global $db;
		$sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
		if ($db->db_num_rows($sql)) {
			$G = $db->db_fetch_array($sql);
			$txt = $G["c_name"] . " &gt;&gt; ";
			if ($G['c_parent'] != "0" and $G['c_parent'] != "") {
				$txt = findparent2($G['c_parent']) . $txt;
			}
		}
		return $txt;
	}

	if (empty($offset) || $offset < 0) {
		$offset = 0;
	}
	//    Set $limit,  $limit = Max number of results per 'page' 
	if (empty($limit)) {
		$limit = 20;
	}

	function article_backto($cid)
	{
		global $db;
		$s_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$cid}' ");
		if ($db->db_num_rows($s_group)) {
			$a_data = $db->db_fetch_array($s_group);
			if ($a_data['c_parent'] != "0") {
				$txt = "article_list.php?cid={$a_data['c_parent']}";
			} else {
				$txt = "article_group.php";
			}
			return $txt;
		}
	}
	?>
	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

							<h4><?php echo $txt_article_list; ?></h4>
							<p></p>

						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<?php if ($cid) { ?>
										<li><a href="article_group.php"><?php echo $txt_article_group; ?></a></li>
									<?php  } else { ?>
										<li><a href="article_list.php"><?php echo $txt_article_list; ?></a></li>
									<?php } ?>
									<?php echo article_group_parent($cid); ?>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">

								<a href="article_gadd.php?p=0" target="_self">
									<button type="button" class="btn btn-info btn-sm" title="<?php echo $txt_article_add_group; ?>">
										<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add_group; ?>
									</button>
								</a>
								<a href="article_new.php?cid=<?php echo $_GET['cid']; ?>" target="_self">
									<button type="button" class="btn btn-info   btn-sm">
										<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add; ?>
									</button>
								</a>

								<button type="button" class="btn btn-primary btn-sm search_module_button">
									<i class="fas fa-search"></i>&nbsp;ค้นหาข่าว/บทความ
								</button>

								<a href="<?php echo article_backto($_GET['cid']); ?>" target="_self">
									<button type="button" class="btn btn-info   btn-sm ">
										<i class="fas fa-undo-alt"></i>&nbsp;&nbsp;<?php echo $txt_ewt_back; ?>
									</button>
								</a>
								<!--<button type="button" class="btn btn-info  btn-ml"  onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_complain_form.php?com_cid=<?php echo $com_cid; ?>');"  title="<?php echo $txt_complain_add_cate; ?>"  target="_self">
								<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_complain_add_form; ?>
								</button>-->
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info  btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;<?php echo $txt_ewt_menu_action; ?> <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="article_gadd.php?p=0"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add_group; ?></a></li>
											<li><a href="article_new.php?cid=<?php echo $_GET['cid']; ?>"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_article_add; ?> </a></li>
											<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหาข่าว/บทความ</a></li>
											<li><a href="<?php echo article_backto($_GET['cid']); ?>"><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?></a></li>
										</ul>
								</div>
							</div>
						</div>

					</div>
				</div>
				<!--END card-header -->

				<div class="card-body">
					<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none"></div>
					<div class="row">
						<?php /* <div class="col-md-12 col-sm-12 col-xs-12" >
							<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-12" >
							<form class="form-inline"  name="form2" id="form2" action="article_list.php" method="get">
							<div class="form-group">
							<label for="search_txt">ค้นหาหัวข้อข่าว/บทความ :</label>
							<input type="hidden" name="curPage" value="1">
							<input type="text" name="search_txt"  id="search_txt" value="<?php echo $search_txt;?>" class="form-control" />
							<input type="hidden" name="serach_flag" value="<?php echo $_POST['serach_flag'];?>" />
							<?php
							if($_GET['cid'] != ""){
							?>
							<input name="cid" type="checkbox" value="<?php echo $_GET['cid']; ?>" checked>&nbsp;เฉพาะหมวด <?php echo $G['c_name']; ?>&nbsp;
							<?php }else{ ?>
							<input name="cid" type="hidden" id="cid" value="<?php echo $_GET['cid'];?>" />&nbsp;
							<?php } ?>
							<?php
							if($_GET['uid_show'] == ""){
							?>
							<input name="uid_show" type="checkbox" value="<?php if($_SESSION['EWT_SMID']!=''){ echo $_SESSION['EWT_SMID']; }else{ echo "0";}?>" <?php if($_GET['uid_show']!=''){ echo "checked";}?>>&nbsp;เฉพาะข่าวที่รับผิดชอบ<?php } ?>
							</div>
							<input type="submit" name="Submit" value="ค้นหา" class="btn btn-success" />
							</form>
							</div>
								
							</div>
							</div>

							<div class="clearfix">&nbsp;</div>
							*/ ?>
						<div class="col-md-12 col-sm-12 col-xs-12">

							<?php
							/* if($_GET["search_type"] != "2" OR $_GET["search_txt"] == ""){
							$sql_search = "SELECT * FROM article_group WHERE c_id != '0' ";
								if($_GET["cid"] != ""){
									$sql_search .= " AND c_parent = '".$_GET["cid"]."' ";
								}
									if($_GET["search_txt"] != ""){
									$sql_search .= " AND c_name REGEXP '".$_GET["search_txt"]."' ";
								}

							//$sql_search .= "ORDER BY c_id ASC";
							$sql_search .= "ORDER BY d_id ASC";
							$sql_article = $db->query($sql_search);
							?>
							<div class="table-responsive" id="frm_edit_s1">
							<table  class="table table-bordered" width="100%"  align="center" >
							<form name="form11" method="post" action="article_function.php">
								<input type="hidden" name="Flag" value="DelGroup">
								<input name="p" type="hidden" id="p" value="<?php echo $_GET['cid']; ?>">
								<thead>
								<tr class="success">
									<th  width="10%" class="text-center"></th>
									<th  width="50%" class="text-center">ชื่อกลุ่มข่าว/บทความ</th>
									<th  width="10%" class="text-center">ภาษาอื่น</th>
									<th  width="10%" class="text-center">แสดง RSS<span class="text-danger"><a href="#help_01">*</a></span></th>
									<th  width="10%" class="text-center">ลบ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 0;
								while($G = $db->db_fetch_array($sql_article)){ 

								$S_count = $db->query("SELECT COUNT(n_id) FROM article_list WHERE n_approve != 'D' AND c_id = '$G[c_id]' "); 
								$C = $db->db_fetch_row($S_count);
										
									if($G["c_rss"]=='Y'){
										$checked= "checked";
										$filename="../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$G["c_id"].".xml";
										if(file_exists($filename)){
											$link='<a href="../ewt/'.$_SESSION["EWT_SUSER"].'/rss/group'.$G["c_id"].'.xml" target="_blank"><img src="../theme/main_theme/g_rss.gif" border="0" alt="ดูข้อมูล RSS"> </a>';
										}else{
											$link='';
										}
										
									}else{
										$checked=''; $link='';
									}
									
							$pass_sub_w=''; 
							$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
							if($db->check_permission("Ag","w","0") or $db->check_permission("Ag","w",$G["c_id"]) ){
								$pass_sub_w='Y';
							}else{
							if(countparent($G["c_id"],"w")>0){
									$pass_sub_w='Y';
							}
							}
								
								?>
							<tr bgcolor="#FFFFFF" style="display:<?php if($_GET["uid_show"] != "" && $pass_sub_w !='Y'){ echo "none";}?>"> 
							<td class="text-center">
							<nobr>
							<a href="article_list.php?cid=<?php echo $G['c_id'];?>"  >
							<button type="button" class="btn btn-success btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo "ดูข้อมูลรายการบทความ";?>" >
							<i class="fa fa-th-list" aria-hidden="true"></i>
							</button>
							</a> 
							<?php if($pass_sub_w=='Y'){ ?>
							<a href="article_gedit.php?cid=<?php echo $G['c_id'];?>" >
							<button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo "แก้ไขหมวดข่าว/บทความ";?>" >
							<i class="fa fa-edit" aria-hidden="true"></i>
							</button>
							</a> 

							<!--<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_set_lang.php?gid=&id=<?php echo $G['c_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?php echo "สร้างภาษาอื่นๆ";?>">-->
							<a onClick="txt_data('<?php echo $G['c_id'];?>','')" >
							<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $G['c_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_multilang;?>" >
							<i class="fa fa-language" aria-hidden="true"></i>
							</button>
							</a> 
							<?php  } ?>
							<?php echo $link;?>
							</nobr>
							</td>
							<td class="text-left"> 

							<a href="#article" onClick="self.location.href='article_list.php?cid=<?php echo $G["c_id"]; ?>';"> 
							<h4><i class="fas fa-folder"></i> <?php echo $G['c_name'];?></h4> 
							<font color="#666666">[<?php $numfolder = countchild($G["c_id"]); echo number_format($numfolder,0); ?> หมวด <?php echo number_format($C[0] + countchild2($G["c_id"]),0); ?> บทความ]</font></a>      
							</td>    
							<td class="text-center"><?php if($pass_sub_w=='Y'){  echo show_icon_lang($G["c_id"],'article_group'); }?></td>
							<td class="text-center" > 
								<?php if($pass_sub_w=='Y'){ ?>
									<input name="chkrss<?php echo $i; ?>" type="checkbox" id="chkrss<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php echo $checked; ?>> 
									<input name="chkrssH<?php echo $i; ?>" type="hidden" id="chkrssH<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>">
									
									<?php } ?>      
							</td>
							<td class="text-center"> 
								<?php if($pass_sub_w=='Y'){ ?>
									<input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G["c_id"]; ?>" <?php  if($numfolder > 0){ echo "disabled"; } ?>> 
									<?php $i++; } ?>      
							</td>
							</tr>	
							<?php  
								}
							?>
							<tr bgcolor="#FFFFFF"> 
							<td colspan="2" valign="top">&nbsp;<a id="#bottom"></a></td>
							<td>&nbsp;</td>
							<td class="text-center" >
							<?php if($i>0){ ?>
									<button type="button" class="btn btn-success  btn-ml " onClick="document.form11.Flag.value='SetRSS'; document.form11.submit();" >
									<span class="glyphicon glyphicon-cog"></span>&nbsp;<?php echo "ตั้งค่า";?>
									</button>
									<?php } ?>      
									</td>
							<td class="text-center" >
									<?php if($i>0){ ?>
									<button type="button" class="btn btn-danger  btn-ml " onClick="if(confirm('Are you sure to delete selected group?')){ form11.submit(); }" >
									<span class="glyphicon glyphicon-trash"></span>&nbsp;<?php echo "ลบกลุ่ม";?>
									</button>
								<?php } ?>    
							</tr>
							<tr bgcolor="#FFFFFF"> 
							<td colspan="3" valign="top"><span class="text-danger"><a name="help_01"></a>* 
							เลือก RSS เป็นการกำหนดให้ข่าวกลุ่มนั้นมีการส่งออกเป็นไฟล์ XML ตามมาตรฐาน 
							RSS ได้</span>
							</td>
							<td align="center" >&nbsp;</td>
							<td align="center"  >&nbsp;</td>
							</tr>
							<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
							</tbody>

							</form>
							</table>
							</div>

							<?php
							}*/

							if ($_GET['search_type'] != "1" or $_GET['search_txt'] == "") {
								$block_edit = "";
								$block_approve = "";

								/*$sql_query = "SELECT n_id,n_topic,n_date,n_new_modi,n_last_modi,n_owner,news_use,n_share,n_shareuse,n_sharename,n_approve,c_id,link_html FROM article_list WHERE  n_approve<>'D' and n_id != '' ";
										if($_GET["cid"] != ""){
										$sql_query .= " AND c_id = '".$_GET["cid"]."' ";
										}
										if($_GET["search_txt"] != ""){
										$sql_query .= " AND n_topic REGEXP '".$_GET["search_txt"]."' ";
										}
										if($_GET["uid_show"] != ""){
										$sql_query .= " AND n_owner = '".$_GET["uid_show"]."' ";
										}
										
								$sql_article = $sql_query." ORDER BY n_date DESC,n_timestamp DESC LIMIT $offset,$limit ";
								$sql_article = $db->query($sql_article);*/

								$wh = '';

								$search_pagin = "";

								if ($_GET['cid'] != "") {
									$wh .= " AND c_id = '{$_GET['cid']}' ";
								}


								if ($_GET["search"] == "Y") {

									$search_pagin .= "search=Y&";

									$article_name = trim($_GET['article_name']);
									$search_pagin .= "article_name=" . ready($_GET["article_name"]) . "&";

									if ($article_name != "") {
										$find = ready($article_name);
										$wh .= " AND n_topic LIKE '%$find%' ";
									}
								} else {
									$search_pagin = "&";
								}

								if ($_GET['uid_show'] != "") {
									$wh .= " AND n_owner = '{$_GET['uid_show']}' ";
								}

								$perpage = 10;
								$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
								if ($page <= 0) $page = 1;
								$start = ($page * $perpage) - $perpage;

								$_sql = $db->query("SELECT n_id,n_topic,n_date,n_new_modi,n_last_modi,n_owner,news_use,n_share,n_shareuse,n_sharename,n_approve,c_id,link_html,pinned,view_count
								FROM article_list 
								WHERE n_approve <> 'D' AND n_id != '' 
								{$wh} 
								ORDER BY CASE WHEN pinned = 'Y' THEN pinned END DESC, n_date DESC, n_timestamp DESC LIMIT {$start} , {$perpage} ");

								$statement = "SELECT count(n_id) AS b
								FROM article_list 
								WHERE n_approve <> 'D' AND n_id != ''
								{$wh} ";

								$a_rows = $db->db_num_rows($_sql);
								$s_count = $db->query($statement);
								$a_count = $db->db_fetch_array($s_count);
								$total_record = $a_count['b'];
								$total_page = (int)ceil($total_record / $perpage);
							?>

								<div class="table-responsive" id="frm_edit_s">
									<?php if (!empty($article_list_view["data"]) && $article_list_view["data"][0]["view_count"] != 0) { ?>
										<h5>ข่าว/บทความที่มีผู้ชมสูงสุด</h5>
										<table width="100%" border="0" align="center" class="table table-bordered">
											<thead>
												<tr class="info">
													<th width="5%" class="text-center">&nbsp;</th>
													<th width="10%" class="text-center">วันที่</th>
													<th width="40%" class="text-center">หัวข้อ/บทความ</th>
													<th width="20%" class="text-center">ผู้สร้าง</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($article_list_view["data"] as $key => $value) { ?>
													<?php
													if ($value["n_owner"] == 0 || $value["n_owner"] == '') {
														$owner = 'Web Admin';
													} else {
														$db->query("USE " . $EWT_DB_USER);
														$sql_chk = "SELECT name_thai,surname_thai FROM gen_user where  gen_user_id ='" . $value["n_owner"] . "'  ";
														$query = $db->query($sql_chk);
														$rec = $db->db_fetch_array($query);
														$db->query("USE " . $EWT_DB_NAME);
														$owner = $rec['name_thai'] . '   ' . $rec['surname_thai'];
													}

													$group_text = "";
													if ($_GET["cid"] == "") {
														$sql_gname = $db->query("SELECT c_name FROM article_group WHERE c_id = '" . $value["c_id"] . "' ");
														$GN = $db->db_fetch_row($sql_gname);
														$group_text = "<div><a href=\"#article\" onClick=\"self.location.href='article_list.php?cid=" . $value["c_id"] . "';\"><img src=\"../theme/main_theme/g_folder_closed.gif\" alt=\"news folder\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"> " . $GN[0] . "</a></div>";
													}

													$pass_w = '';

													$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน

													if ($db->check_permission("Ag", "w", "0") or $db->check_permission("Ag", "w", $value["c_id"])) {
														$pass_w = 'Y';
													} else {
														if (countparent($value["c_id"], "w") > 0) {
															$pass_w = 'Y';
														}
													}

													$pass_a = '';
													$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
													if ($db->check_permission("Ag", "a", "0") or $db->check_permission("Ag", "a", $value['c_id'])) {
														$pass_a = 'Y';
													} else {
														if (countparent($value['c_id'], "a") > 0) {
															$pass_a = 'Y';
														}
													}

													## >> Only super admin and article owner can edit the article
													if ($pass_w == "Y" and $value['n_owner'] != $_SESSION['EWT_SMID']) {
														$pass_w = '';
													}
													if ($_SESSION['EWT_SMTYPE'] == "Y") {
														$pass_w = "Y";
													}

													## >> Only super admin and article owner can approve the article
													if ($pass_a == "Y" and $value['n_owner'] != $_SESSION['EWT_SMID']) {
														$pass_a = '';
													}

													if ($_SESSION['EWT_SMTYPE'] == "Y") {
														$pass_a = "Y";
													}
													?>

													<tr bgcolor="#FFFFFF">
														<td height="20" align="center" valign="top" nowrap>
															<?php
															$path_news = "";
															if ($value['news_use'] == "2" or $value['news_use'] == "3" or $value['news_use'] == "4") {
																$path_news = "../ewt/" . $_SESSION['EWT_SUSER'] . "/article_view.php?n_id=" . $value['n_id'];
															} else {
																$url_array = array("http://", "https://");
																$is_outsidelink = "N";

																foreach ($url_array as $url_e) {
																	$check_link = (string)strpos($value['link_html'], $url_e);
																	if ($check_link == "0") {
																		$is_outsidelink = "Y";
																	}
																}

																if ($is_outsidelink == "Y") {
																	$path_news = $value["link_html"];
																} else {
																	$path_news = "../ewt/" . $_SESSION['EWT_SUSER'] . "/" . $value['link_html'];
																}
															}
															?>

															<a href="<?php echo $path_news; ?>" target="_blank">
																<button type="button" class="btn btn-success  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo "ดูข้อมูล"; ?>">
																	<i class="fas fa-search" aria-hidden="true"></i>
																</button>
															</a>

															<?php if ($pass_w == 'Y') { ?>

																<!-- <a onClick="txt_data3('<?php echo $value['n_id']; ?>','')">
																	<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $value['n_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang ?>">
																		<i class="fa fa-language" aria-hidden="true"></i>
																	</button>
																</a> -->

																<a href="article_edit.php?nid=<?php echo $value['n_id']; ?>&cid=<?php echo $_GET['cid']; ?>">
																	<button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_edit; ?>">
																		<i class="fa fa-edit" aria-hidden="true"></i>
																	</button>
																</a>

																<button type="button" class="btn btn-light  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo ($value["pinned"] == "Y" ? "ยกเลิกการปักหมุดข่าว/บทความ" : "ปักหมุดข่าว/บทความ"); ?>" onClick="<?php echo ($value["pinned"] == "Y" ? "article_unpin" : "article_pin"); ?>('<?php echo $value['n_id']; ?>');">
																	<i class="fas fa-thumbtack" style="<?php echo ($value["pinned"] == "Y" ? "color:#dc3545;" : "color:#c3c3c3;"); ?>"></i>
																</button>

															<?php } ?>
														</td>

														<td class="text-center"><?php echo date('d/m/Y', strtotime($value["n_date"])); ?></td>
														<td class="text-left">
															<?php if ($value["n_shareuse"] != "Y") { ?>
																<?php echo $value["n_topic"] . "&nbsp;{" . $value["view_count"] . " ครั้ง} "; ?>
															<?php  } else { ?>
																<img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle">
																<?php echo $value["n_topic"] . "&nbsp;{" . $value["view_count"] . " ครั้ง} "; ?> [From:<?php echo $value["n_sharename"]; ?>]
															<?php } ?>
															<?php echo $group_text; ?>
														</td>
														<td class="text-center">
															<span class="label label-success text-small"><?php echo $owner; ?></span>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									<?php } ?>

									<hr><h5>ข่าว/บทความทั้งหมด</h5>
									<table width="100%" border="0" align="center" class="table table-bordered">
										<form name="form1" method="post" action="article_function.php">
											<input type="hidden" name="Flag" value="DelArticle">
											<input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">
											<input type="hidden" name="backto" value="<?php if ($_GET["cid"] != "") {
																							echo "article_list.php?cid=" . $_GET["cid"];
																						} else {
																							echo "article_group.php";
																						} ?>">
											<thead>
												<tr class="info">
													<th width="5%" class="text-center">&nbsp;</th>
													<th width="10%" class="text-center">วันที่</th>
													<th width="40%" class="text-center">หัวข้อข่าว/บทความ</th>
													<!-- <th width="10%" class="text-center">ภาษาอื่น</th> -->
													<th width="10%" class="text-center">ผู้สร้าง</th>
													<!--<th width="4%" class="text-center">สร้าง</th>
													<th width="5%" class="text-center">แก้ไข</th>
													<th width="5%" class="text-center">Share</th>--> 
													<th width="5%" class="text-center">อนุมัติ</th>
													<th width="5%" class="text-center">ลบ</th>
												</tr>
											</thead>
											<?php
											$i = 0;
											$rows = $db->db_num_rows($_sql);
											$nu = $rows - $offset;
											while ($N = $db->db_fetch_array($_sql)) {
												$date = explode("-", $N["n_date"]);
												if ($N["n_new_modi"] != '') {
													$n_new_modi_Y = substr($N["n_new_modi"], 0, 4);
													$n_new_modi_M = substr($N["n_new_modi"], 4, 2);
													$n_new_modi_D = substr($N["n_new_modi"], 6, 2);
													$date_create_f = $n_new_modi_D . "/" . $n_new_modi_M . "/" . ($n_new_modi_Y + 543);
												} else {
													$date_create_f  = '-';
												}
												if ($N["n_last_modi"] != '' && $N["n_new_modi"] != '') {
													$n_last_modi_Y = substr($N["n_last_modi"], 0, 4);
													$n_last_modi_M = substr($N["n_last_modi"], 4, 2);
													$n_last_modi_D = substr($N["n_last_modi"], 6, 2);
													$date_modi_f = $n_last_modi_D . "/" . $n_last_modi_M . "/" . ($n_last_modi_Y + 543);
												} else {
													$date_modi_f  = '-';
												}
												if ($N["n_owner"] == 0 || $N["n_owner"] == '') {
													$owner = 'Web Admin';
												} else {
													$db->query("USE " . $EWT_DB_USER);
													$sql_chk = "SELECT name_thai,surname_thai
													FROM gen_user where  gen_user_id ='" . $N["n_owner"] . "'  ";
													$query = $db->query($sql_chk);
													$rec = $db->db_fetch_array($query);
													$db->query("USE " . $EWT_DB_NAME);
													$owner = $rec['name_thai'] . '   ' . $rec['surname_thai'];
												}
												$group_text = "";
												if ($_GET["cid"] == "") {
													$sql_gname = $db->query("SELECT c_name FROM article_group WHERE c_id = '" . $N["c_id"] . "' ");
													$GN = $db->db_fetch_row($sql_gname);
													$group_text = "<div><a href=\"#article\" onClick=\"self.location.href='article_list.php?cid=" . $N["c_id"] . "';\"><img src=\"../theme/main_theme/g_folder_closed.gif\" alt=\"news folder\" width=\"16\" height=\"16\" align=\"absmiddle\" border=\"0\"> " . $GN[0] . "</a></div>";
												}

												$pass_w = '';

												$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน

												if ($db->check_permission("Ag", "w", "0") or $db->check_permission("Ag", "w", $N["c_id"])) {
													$pass_w = 'Y';
												} else {
													if (countparent($N["c_id"], "w") > 0) {
														$pass_w = 'Y';
													}
												}

												$pass_a = '';
												$y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
												if ($db->check_permission("Ag", "a", "0") or $db->check_permission("Ag", "a", $N['c_id'])) {
													$pass_a = 'Y';
												} else {
													if (countparent($N['c_id'], "a") > 0) {
														$pass_a = 'Y';
													}
												}

												## >> Only super admin and article owner can edit the article
												if ($pass_w == "Y" and $N['n_owner'] != $_SESSION['EWT_SMID']) {
													$pass_w = '';
												}
												if ($_SESSION['EWT_SMTYPE'] == "Y") {
													$pass_w = "Y";
												}

												## >> Only super admin and article owner can approve the article
												if ($pass_a == "Y" and $N['n_owner'] != $_SESSION['EWT_SMID']) {
													$pass_a = '';
												}
												if ($_SESSION['EWT_SMTYPE'] == "Y") {
													$pass_a = "Y";
												}
											?>

												<tr bgcolor="#FFFFFF">
													<td height="20" align="center" valign="top" nowrap>
														<?php
														$path_news = "";
														if ($N['news_use'] == "2" or $N['news_use'] == "3" or $N['news_use'] == "4") {
															// $path_news = "../ewt/" . $_SESSION['EWT_SUSER'] . "/article-views-backend.php?nid=" . $N['n_id'] . "&lang=TH";
															$path_news = "../ewt/" . $_SESSION['EWT_SUSER'] . "/article_view.php?n_id=" . $N['n_id'];
														} else {
															$url_array = array("http://", "https://");
															$is_outsidelink = "N";

															## >> Check link from outside
															foreach ($url_array as $url_e) {
																$check_link = (string)strpos($N['link_html'], $url_e);
																if ($check_link == "0") {
																	$is_outsidelink = "Y";
																}
															}

															if ($is_outsidelink == "Y") {
																$path_news = $N["link_html"];
															} else {
																$path_news = "../ewt/" . $_SESSION['EWT_SUSER'] . "/" . $N['link_html'];
															}
														}
														?>

														<!--<a href="#view" onClick="window.open('<?php //echo $path_news; 
																									?>');">
														<img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" align="absmiddle" alt="ดูข้อมูล">
														</a>-->
														<a href="<?php echo $path_news; ?>" target="_blank">
															<button type="button" class="btn btn-success  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo "ดูข้อมูล"; ?>">
																<i class="fas fa-search" aria-hidden="true"></i>
															</button>
														</a>

														<?php if ($pass_w == 'Y') { ?>

															<!--<a href="#set" onClick="txt_data3('<? //=$N["n_id"]
																									?>','')">
															<img id="lang<?php //echo $N["n_id"]; 
																			?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0">
															</a>-->

															<!-- <a onClick="txt_data3('<?php echo $N['n_id']; ?>','')">
																<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $N['n_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang ?>">
																	<i class="fa fa-language" aria-hidden="true"></i>
																</button>
															</a> -->
															<!--<a href="##P" title="เพิ่ม Tool Tips"  onClick="window.open('content_tooltips.php?type=a&filename=<?php echo $N["n_id"]; ?>','','height=600,width=780,scrollbars=1,resizable=1');">
															<img src="../images/help.gif" alt="เพิ่ม Tool Tips" width="16" height="16" align="absmiddle" border="0">
															</a>-->
															<a href="article_edit.php?nid=<?php echo $N['n_id']; ?>&cid=<?php echo $_GET['cid']; ?>">
																<button type="button" class="btn btn-warning  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_article_edit; ?>">
																	<i class="fa fa-edit" aria-hidden="true"></i>
																</button>
															</a>

															<?php
															if ($N["pinned"] == "Y") {
															?>
																<button type="button" class="btn btn-light  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="ยกเลิกการปักหมุดข่าว/บทความ" onClick="article_unpin('<?php echo $N['n_id']; ?>');">
																	<i class="fas fa-thumbtack" style="color:#dc3545;"></i>
																</button>
															<?php
															} else {
															?>
																<button type="button" class="btn btn-light  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="ปักหมุดข่าว/บทความ" onClick="article_pin('<?php echo $N['n_id']; ?>');">
																	<i class="fas fa-thumbtack" style="color:#c3c3c3;"></i>
																</button>
															<?php
															}
															?>
														<?php } ?>
													</td>

													<td class="text-center"><?php echo $date[2] . "/" . $date[1] . "/" . $date[0]; ?></td>
													<td class="text-left">
														<!--<img src="../theme/main_theme/g_document.gif" alt="News" width="16" height="16" align="absmiddle">-->
														<?php if ($N["n_shareuse"] != "Y") { ?>
															<?php if ($pass_w == 'Y') { ?>
																<?php /*<a href="#article" onClick="self.location.href='article_edit.php?nid=<?php echo $N["n_id"]; ?>&cid=<?php echo $_GET["cid"]; ?>';"  > */ ?>
															<?php } ?>
															<?php echo $N["n_topic"] . "&nbsp;{" . $N["view_count"] . " ครั้ง} "; ?>
															<?php if ($pass_w == 'Y') { ?>
																<?php /*</a>*/ ?>
															<?php } ?>
														<?php  } else { ?>
															<img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle">
															<?php echo $N["n_topic"] . "&nbsp;{" . $N["view_count"] . " ครั้ง} "; ?> [From:<?php echo $N["n_sharename"]; ?>]
														<?php } ?>
														<?php echo  $group_text; ?>
													</td>
													<!-- <td class="text-center">
														<?php if ($pass_w == 'Y') {
															echo show_icon_lang2($N["n_id"], 'article_list');
														} ?>
													</td>  -->
													<td class="text-center"><span class="label label-success text-small"><?php echo $owner; ?></span></td>
													<!--
													<td class="text-center" ><? //=$date_create_f;
																				?></td>
													<td class="text-center" ><? //=$date_modi_f; 
																				?></td>-->

													 	<!-- hide share section ->
														<td class="text-center" > 
														<?php if($pass_w=='Y'){ ?>

														<?php if($N['n_share'] != "Y" AND $N['n_shareuse'] != "Y"){ ?>
															<div class="checkbox">
															<label>
															<input name="share<?php echo $i; ?>" type="checkbox" id="share<?php echo $i; ?>"  value="<?php echo $N['n_id'];?>" /> 
															<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
															</label>
															</div>
														<?php } ?>   

														<?php if($N['n_share'] == "Y"){ ?>
														<a href="#change" onClick="win2=window.open('article_share_news.php?nid=<?php echo $N['n_id']; ?>','change','width=400,height=500,resizable=1,scrollbars=1');"><img src="../images/bar_share.gif" width="20" height="20" border="0"></a> 
														<?php } ?>
														<?php if($N['n_shareuse'] == "Y"){ ?>
														<img src="../images/share.gif" width="20" height="20" border="0" /> 
														<?php 
														} 
															}
														?>      
														</td>-->
													

													<td class="text-center">
														<?php
														if ($pass_a == 'Y') { ?>
															<div class="checkbox">
																<label>
																	<input name="app<?php echo $i; ?>" type="checkbox" id="app<?php echo $i; ?>" value="Y" <?php if ($N['n_approve'] == "Y") {
																																								echo "checked";
																																							} ?> />
																	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
																</label>
															</div>
															<input name="nid<?php echo $i; ?>" type="hidden" id="nid<?php echo $i; ?>" value="<?php echo $N["n_id"]; ?>">

														<?php
															$block_approve = "Y";
															$count_approvable++;
														} else {
															if ($N["n_approve"] == "Y") {
																echo "<img src=\"../theme/main_theme/g_approve.gif\"  border=\"0\" align=\"absmiddle\" alt=\"อนุมัติแล้ว\">";
															}
														}
														?>
													</td>
													<td align="center" valign="top">
														<?php if ($pass_w == 'Y') { ?>
															<div class="checkbox">
																<label>
																	<input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $N['n_id']; ?>" />
																	<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
																</label>
															</div>
														<?php $block_edit = "Y";
														}
														?>
													</td>
												</tr>
											<?php $i++;
												$nu--;
											} ?>
											<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
											<tr bgcolor="#FFFFFF">
												<td height="30" colspan="4">&nbsp;</td>
						
												<!--<td class="text-center" >
												<?php if($block_edit=="Y"){ ?>
												<button type="button" class="btn btn-info  btn-ml " onClick="sharing();" >
												<i class="fas fa-share-alt-square fa-1x"></i>&nbsp;<?php echo "Share";?>
												</button>
												<?php }?>
												</td>-->
												
												<td class="text-center">
													<?php
													//if($block_approve=="Y"){ 
													if ($count_approvable > 0) {
													?>
														<button type="button" class="btn btn-success  btn-ml " onClick="document.form1.Flag.value='AppArticle';form1.submit();">
															<i class="far fa-check-circle fa-1x"></i>&nbsp;<?php echo "อนุมัติ"; ?>
														</button>
													<?php } ?>
												</td>
												<td class="text-center">
													<?php if ($block_edit == "Y") { ?>
														<button type="submit" class="btn btn-danger  btn-ml " onClick="return confirm('Are you sure to delete selected article?');">
															<i class="fas fa-trash-alt fa-1x"></i>&nbsp;<?php echo "ลบข่าว"; ?>
														</button>

													<?php } ?>
												</td>
											</tr>

										</form>
									</table>
								</div>
							<?php } ?>
							<?php echo pagination_ewt($statement, $perpage, $page, '?cid=' . $_GET['cid'] . $search_pagin); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<!--<style>

.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
</style>-->

<script>
	function JQDelete(id) {
		$.confirm({
			title: 'ลบข้อมูล',
			content: 'คุณต้องการลบรายการนี้หรือไม่?',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-exclamation-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันลบข้อมูล',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'GET',
							url: 'func_delete_vdo.php',
							data: {
								'id': id,
								'proc': 'DelVdo'
							},
							success: function(data) {
								$.alert({
									title: '',
									content: 'url:text.html',
									boxWidth: '30%',
									buttons: {
										cancel: {
											text: 'ตกลง',
											btnClass: 'btn-blue',
											action: function() {
												location.reload();
											}
										}
									}

								});

							}
						});
						//FuncDelete(id);											
						//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
					}

				},
				cancel: {
					text: 'ยกเลิก'

				}
			},
			animation: 'scale',
			type: 'orange'

		});
		// });
	}

	function JQSet_lang_list(form) {

		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: 'เพิ่มข่าว/บทความภาษาอื่นๆ',
				content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
				//content: 'url:form.html',
				boxWidth: '30%',
				icon: 'far fa-question-circle',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ยืนยันการบันทึก',
						btnClass: 'btn-blue',
						action: function() {
							$.ajax({
								type: method,
								url: action,
								data: formData ? formData : form.serialize(),
								async: true,
								processData: false,
								contentType: false,
								success: function(data) {
									console.log(data);
									$.alert({
										title: '',
										theme: 'modern',
										content: 'บันทึกข้อมูลเรียบร้อย',
										boxWidth: '30%',
										action: function() {
											location.reload(true);
										}
									});
									//$("#frm_edit_s").load(location.href + " #frm_edit_s");
									//alert("Data Save: " + data);												
									//self.location.href="article_list.php?cid="+data;											
									$('#box_popup').fadeOut();

								}
							});
						}

					},
					cancel: {
						text: 'ยกเลิก'

					}
				},
				animation: 'scale',
				type: 'blue'

			});
		}

	}

	function JQSet_lang_group(form) {

		var fail = CKSubmitData(form);

		if (fail == false) {
			var action = form.attr('action');
			//alert(form.serialize());															
			$.confirm({
				title: 'เพิ่มกลุ่มข่าว/บทความภาษาอื่นๆ',
				content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
				//content: 'url:form.html',
				boxWidth: '30%',
				icon: 'far fa-question-circle',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ยืนยันการบันทึก',
						btnClass: 'btn-blue',
						action: function() {
							$.ajax({
								type: 'POST',
								url: action,
								data: form.serialize(),
								success: function(data) {
									console.log(data);
									$.alert({
										title: '',
										theme: 'modern',
										content: 'บันทึกข้อมูลเรียบร้อย',
										boxWidth: '30%',
										action: function() {
											location.reload(true);
										}
									});
									//$("#frm_edit_s1").load(location.href + " #frm_edit_s1");
									//alert("Data Save: " + data);												
									//self.location.href="article_list.php?cid="+data;											
									$('#box_popup').fadeOut();
								}
							});
						}

					},
					cancel: {
						text: 'ยกเลิก'

					}
				},
				animation: 'scale',
				type: 'blue'

			});
		}

	}

	function sharing() {
		document.form1.Flag.value = "Share";
		form1.action = "article_share.php";
		form1.submit();
	}

	function txt_data(w, g) {
		$.ajax({
			type: 'GET',
			url: 'pop_set_lang.php?gid=' + g + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();

	}

	function txt_data1(w, g, lang) {
		$.ajax({
			type: 'GET',
			url: 'article_multilang_group.php?langid=' + g + '&lang=' + lang + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});
		$('#box_popup').fadeIn();
		//window.location.href='../multilangMgt/article_group.php?langid='+g+'&lang='+lang+'&id='+ w;
	}

	function txt_data2(w, g, lang) {
		$.ajax({
			type: 'GET',
			url: 'article_multilang_list.php?langid=' + g + '&lang=' + lang + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();
		//window.location.href='../multilangMgt/article_list.php?langid='+g+'&lang='+lang+'&id='+ w;
	}

	function txt_data3(w, g) {
		$.ajax({
			type: 'GET',
			url: 'pop_set_lang_list.php?gid=' + g + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();

	}

	function article_pin(id) {
		$.confirm({
			title: 'ปักหมุดข่าว/บทความ',
			content: 'คุณต้องการปักหมุดรายการนี้หรือไม่?',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-exclamation-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยัน',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'POST',
							url: 'article_function.php',
							data: {
								'n_id': id,
								'Flag': 'article_pin'
							},
							success: function(data) {
								$.alert({
									title: 'ปักหมุดเรียบร้อย',
									content: 'url:text.html',
									boxWidth: '30%',
									buttons: {
										cancel: {
											text: 'ตกลง',
											btnClass: 'btn-blue',
											action: function() {
												location.reload();
											}
										}
									}

								});

							}
						});
					}

				},
				cancel: {
					text: 'ยกเลิก'

				}
			},
			animation: 'scale',
			type: 'orange'

		});
		// });
	}

	function article_unpin(id) {
		$.confirm({
			title: 'ยกเลิกปักหมุด',
			content: 'คุณต้องการยกเลิกปักหมุดรายการนี้หรือไม่?',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-exclamation-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยัน',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'POST',
							url: 'article_function.php',
							data: {
								'n_id': id,
								'Flag': 'article_unpin'
							},
							success: function(data) {
								$.alert({
									title: 'ยกเลิกปักหมุดเรียบร้อย',
									content: 'url:text.html',
									boxWidth: '30%',
									buttons: {
										cancel: {
											text: 'ตกลง',
											btnClass: 'btn-blue',
											action: function() {
												location.reload();
											}
										}
									}

								});

							}
						});
					}

				},
				cancel: {
					text: 'ยกเลิก'

				}
			},
			animation: 'scale',
			type: 'orange'

		});
		// });
	}
</script>

<?php
## >> Include search modal

$search_button_class = "search_module_button";
$search_title        = "ค้นหา";
$search_action       = "../ArticleMgt/article_search.php";
$search_parameter    = array(array(
	"name" => "search_word",
	"type" => "text",
	"label" => "คำค้น"
));

include "../include/module_search.php";
?>