<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
@include("language/language.php");
$process=$HTTP_POST_VARS['process'];
$a_url=$HTTP_POST_VARS['a_url'];
$a_site=$HTTP_POST_VARS['a_site'];
$a_description=$HTTP_POST_VARS['a_description'];
$gid=$HTTP_POST_VARS['gid'];
$id=$HTTP_POST_VARS['id'];

?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function ChkAddress(f){
	if (f.a_site.value==''){
	  alert("<?php echo $text_genaddress_alertsitename;?>");
	  f.a_site.focus();
	}else if (f.a_url.value=='http://'){
	  alert("<?php echo $text_genaddress_alertUrl;?>");
	  f.a_url.focus();
	}else {
	  return true;
	}
	return false;
}
	function checkfeeall(totalrec){
		if(document.getElementById('chkfeeall').checked == true){
			for(i=1; i<=totalrec.value; i++){
				document.getElementById("chkfee"+i).checked=true;		
			}
		}else{
			for(i = 1; i<=totalrec.value;i++){
				document.getElementById("chkfee"+i).checked=false;
			}
		}
	}
	function checkfeeeach(totalrec){
		var num = 0
		for(i = 1; i<=totalrec.value;i++){
			if(document.getElementById("chkfee"+i).checked==true){
				num = num+1
			}
		}
		if(num==totalrec.value){
			document.getElementById('chkfeeall').checked = true;
		}else{
			document.getElementById('chkfeeall').checked = false;
		}
	}	

</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="447" valign="top"><?php 
				if($process=='save'){ 
					$Chk_Duplicate=$db->db_num_rows($db->query("SELECT id FROM n_address WHERE a_url like '".$a_url."'"));
					if($Chk_Duplicate==0){
						$db->query("insert into n_address
														( gen_user_id, a_site, a_description, a_url,a_groupid)
														values
														( '".$HTTP_SESSION_VARS['EWT_MID']."', '".$a_site."', '".$a_description."', '".$a_url."','".$gid."')");
						?>
            <form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
              <script language="javascript">
								alert('<?php echo $text_genaddress_alertconf;?>');
								document.formreturn.submit();
							</script>
            </form>
          <?php
					}
					else
					{
					?>
            <form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
              <input type="hidden" name="process" value="add">
              <input type="hidden" name="a_site" value="<?php echo $a_site;?>">
              <input type="hidden" name="a_description" value="<?php echo $a_description;?>">
              <input type="hidden" name="chkgid" value="<?php echo $gid;?>">
              <script language="javascript">
							alert('<?php echo $text_genaddress_alertUrl_repeatedly;?>');
							document.formreturn.submit();
						</script>
            </form>
          <?php
					}
				}else if($process=='add'){
				?>
            <form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" onSubmit="return ChkAddress(this);">
              <input type="hidden" name="process2" value="save">
              <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td bgcolor="#CCCCCC" colspan="2"><strong><?php echo $text_genaddress_textadd;?></strong></td>
                </tr>
                <tr>
                  <td width="11%" bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textsitename;?> :</strong></td>
                  <td width="89%" bgcolor="#FFFFFF"><input type="text" name="a_site" class="textbox" size="50" id="a_site" value="<?php echo $a_site;?>"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textDescription;?> : </strong></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="a_description" class="textbox" size="50" id="a_description" value="<?php echo $a_description;?>"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textURL;?> :</strong></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="a_url" class="textbox" size="50" value="<?php if($a_url==''){ echo 'http://';}else{ echo $a_url;}?>" id="a_url"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" valign="top"><strong><?php echo $text_genaddress_textGroup;?> :</strong></td>
                  <td bgcolor="#FFFFFF"><iframe name="list_send" src="groupaddress_list.php?chkgid=<?php echo $chkgid;?>" frameborder="0" width="100%" align="top" height="100" scrolling="yes"></iframe>
                      <input type="hidden" name="gid" id="gid">
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" align="center" colspan="2"><input type="submit"name="Input2" class="submit" value="<?php echo $text_genaddress_buttonSave;?>">
                    &nbsp;
                    <input  type="reset" name="Input2" class="submit" value="<?php echo $text_genaddress_buttonCancel;?>">
                    <input type="button" name="reset" value=" <?php echo $text_genaddress_buttonback = "back";;?> " onClick="window.location.href='address_manage.php'"></td>
                </tr>
              </table>
            </form>
          <?php
				}else if($process=='delete'){
				$numdata=1+count($chkdata);
					for($del=1;$del<$numdata;$del++){
						if($chkdata[$del]!=''){
								$db->query("DELETE FROM n_address WHERE id = '".$chkfee[$del]."'  ");
									?>
            <form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
              <script language="javascript">
													alert('<?php echo $text_gentaddress_alertdel;?>');
													document.formreturn.submit();
												</script>
            </form>
          <?php
							}
					}
				}else if($process=='update'){  
					$Chk_Duplicate=$db->db_num_rows($db->query("SELECT id FROM n_address WHERE a_url like '".$a_url."' AND id!='".$id."' AND gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' "));
					if($Chk_Duplicate==0){
							$db->query("update n_address set a_site='".$a_site."',a_description='".$a_description."', a_url='".$a_url."',a_groupid='".$gid."' WHERE id = '".$id."'");
							?>
            <form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
              <script language="javascript">
											alert('<?php echo $text_gentaddress_alertedit;?>');
											document.formreturn.submit();
										</script>
            </form>
          <?php
					}else{
					?>
            <form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
              <input type="hidden" name="process2" value="edit">
              <input type="hidden" name="return_value" value="value">
              <input type="hidden" name="a_site" value="<?php echo $a_site;?>">
              <input type="hidden" name="a_description" value="<?php echo $a_description;?>">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <input type="hidden" name="chkgid" value="<?php echo $gid;?>">
              <script language="javascript">
							alert('<?php echo $text_genaddress_alertUrl_repeatedly;?>');
							document.formreturn.submit();
						</script>
            </form>
          <?php
					}
				}else if($process=='edit'){
			?>
            <form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" onSubmit="return ChkAddress(this);">
              <input type="hidden" name="process2" value="update">
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <?php
				if($return_value!='value'){
						$recedit=$db->db_fetch_array($db->query("SELECT * FROM n_address WHERE id='".$id."'"));
						$a_site=$recedit['a_site'];
						$a_description=$recedit['a_description'];
						$a_url=$recedit['a_url'];
						$chkgid=$recedit['a_groupid'];
					}
				?>
              <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td bgcolor="#CCCCCC" colspan="2"><strong><?php echo $text_genaddress_textedit;?></strong></td>
                </tr>
                <tr>
                  <td width="11%" bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textsitename;?> :</strong></td>
                  <td width="89%" bgcolor="#FFFFFF"><input type="text" name="a_site" class="textbox" size="50" id="a_site" value="<?php echo $a_site;?>"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textDescription;?> : </strong></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="a_description" class="textbox" size="50" id="a_description" value="<?php echo $a_description;?>"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textURL;?> :</strong></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="a_url" class="textbox" size="50" value="<?php if($a_url==''){ echo 'http://';}else{ echo $a_url;}?>" id="a_url"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" valign="top"><strong><?php echo $text_genaddress_textGroup;?> :</strong></td>
                  <td bgcolor="#FFFFFF"><iframe name="list_send" src="groupaddress_list.php?chkgid=<?php echo $chkgid;?>" frameborder="0" width="100%" align="top" height="100" scrolling="yes"></iframe>
                      <input type="hidden" name="gid" id="gid" value="<?php echo $chkgid;?>">
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" align="center" colspan="2"><input type="submit"name="Input2" class="submit" value="<?php echo $text_genaddress_buttonSave;?>">
                    &nbsp;
                    <input  type="reset" name="Input2" class="submit" value="<?php echo $text_genaddress_buttonCancel;?>">
                    <input type="button" name="reset" value="<?php echo $text_genaddress_buttonback;?>" onClick="window.location.href='address_manage.php'">
                  </td>
                </tr>
              </table>
            </form>
          <?php	
			}else{
			$sql="SELECT *,n_address.id AS id ,n_groupaddress.id AS gid FROM n_address LEFT OUTER JOIN n_groupaddress ON n_address.a_groupid = n_groupaddress.id WHERE n_address.gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY  n_groupaddress.ganame,a_site ";
			$query=$db->query($sql);
			$rows=$db->db_num_rows($query);		
			//start ส่วนการคำนวณตัดหน้า
			if($limit == ""){ $limit = 20;} //ทำการกำหนดค่าการแสดงเรกคอร์ดต่อpage
			if (empty($offset) || $offset < 0) { $offset=0; }//ทำการกำหนดค่าเริ่มต้นpage
			$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
			// end ส่วนการคำนวณตัดหน้า
			$querylist = $db->query($sqllist);
			$numlist = $db->db_num_rows($querylist);
			?>
            <form name="form1" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post">
              <input type="hidden" name="process2" value="">
              <input type="hidden" name="id" value="">
              <input name="allrecord" type="hidden" value="<?php echo $rows;?>">
              <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#FFFFFF">
                  <td colspan="2" bgcolor="#FFFFFF" align="right"><a href="groupaddress_manage.php"><strong><?php echo $text_genaddress_textgroupmanage;?></strong></a></td>
                  <td colspan="1" align="right"><a href="#" onClick="document.form1.process.value='add';document.form1.submit();"><strong><img src="mainpic/document_new.gif"align="absmiddle" border="0"><?php echo $test_genaddress_testaddgroup;?></strong></a></td>
                </tr>
                <tr>
                  <td width="6%" align="center" bgcolor="#CCCCCC"><?php if($numlist!=0){?>
                      <input id="chkfeeall" name="chkfeeall" type="checkbox" value="Y" onClick="checkfeeall(document.getElementById('allrecord'));">
                      <?php }?>
                  </td>
                  <td width="87%" bgcolor="#CCCCCC" align="center"><strong><?php echo $text_genaddress_textdetail;?></strong></td>
                  <td width="7%" align="center" bgcolor="#CCCCCC"><strong><?php echo $text_genaddress_texteditbutton;?></strong></td>
                </tr>
                <?php
				if($numlist>0){
				$i=1;
				while($reclist=$db->db_fetch_array($querylist)){
				$gid=$reclist['a_groupid'];
				if($chkgid!=$gid){
					$chkgid=$gid;
				?>
                <tr>
                  <td bgcolor="#FFFFFF" colspan="3"><strong>
                    <?php if($reclist['ganame']){ echo 'Group : '.$reclist['ganame'];}else{ echo 'No Group';}?>
                  </strong> </td>
                </tr>
                <?php	
				}
			  ?>
                <tr>
                  <td bgcolor="#FFFFFF" align="center" valign="top"><input name="chkfee[<?php echo $i;?>]" id="chkfee<?php echo $i;?>" type="checkbox" value="<?php echo $reclist['id'];?>" onClick="checkfeeeach(document.getElementById('allrecord'));">
                      <input type="hidden" name="chkdata[<?php echo $i?>]" value="<?php echo $reclist['id'];?>">
                  </td>
                  <td bgcolor="#FFFFFF" valign="top"><a href="<?php echo $reclist['a_url'];?>" target="_blank"><?php echo $reclist['a_site'];?>
                        <?php if($reclist['a_description']){ echo '<br>'.$reclist['a_description'];}?>
                  </a></td>
                  <td bgcolor="#FFFFFF" valign="top" align="center"><img src="mainpic/cal_edit.gif" align="absmiddle" border="0" style="cursor:hand" alt="แก้ไข" onClick="document.form1.process.value='edit';document.form1.id.value='<?php echo $reclist['id'];?>';document.form1.submit();"></td>
                </tr>
                <?php
			  $i++;
			  	}
			  ?>
                <tr>
                  <td bgcolor="#FFFFFF" align="center"><input name="button"  type="button" value="Delete"  onClick="if(confirm('<?php echo $text_gentaddress_alertdelconfirm;?>')){document.form1.process.value='delete';document.form1.submit();}"></td>
                  <td bgcolor="#FFFFFF" colspan="1" align="right"nowrap><?php echo $text_genaddress_textpage;?> <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
                  <td bgcolor="#FFFFFF" align="center"><input type="button" name="reset" value=" <?php echo $text_genaddress_buttonback;?> " onClick="window.location.href='address.php'"></td>
                </tr>
                <?php
			  	}else{
			  ?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="3"align="center"><font color="#FF0000"><strong><?php echo $text_genaddress_textNodata;?></strong></font></td>
                </tr>
                <?php
			  	}
			  ?>
              </table>
            </form>
          <?php
			}
		?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
<?php  $db->db_close(); ?>
