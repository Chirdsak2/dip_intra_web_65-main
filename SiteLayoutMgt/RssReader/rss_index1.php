<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("rss","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
	?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function DelForm(){
		if(confirm("Are you sure you want to delete selected data?")){
			article_data.form1.submit();
		}
	}
	
	function AddForm(){
		article_data.form1.rss_title.value=document.rssForm.rss_title.value;
		article_data.form1.rss_url.value=document.rssForm.rss_url.value;
		article_data.form1.rss_row.value=document.rssForm.rss_row.value;
		article_data.form1.cid.value=document.rssForm.cid.value;
		article_data.form1.submit();
		document.rssForm.rss_title.value='';
		document.rssForm.rss_url.value='';
		document.rssForm.rss_row.value='';
		document.rssForm.cid.value='';
		document.rssForm.savenew.value='Save';
	}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="E0DFE3">
<tr> 
    <td height="20" bgcolor="F3F3EE">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr> 
            <td> 
              <?php include("../ewt_menu.php"); ?>
               </td>
          <td width="19" align="center" ><img src="../images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = '../ewt_main.php';"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="60%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td align="center" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td width="100" align="center" background="../images/bg1_on.gif">RSS List </td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="30">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                          <tr> 
                            <td bgcolor="#FFFFFF"><iframe name="article_data" src="rss.php" frameborder="1"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="right"> 
                      <td height="25">
					  
					  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" >
                          <tr> 
                            <td width="70%">
							
								<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" >
								<?php
								if($cid){
								   $query=$db->query("SELECT * FROM rss WHERE rss_id = '$cid' "); 
								   $G = $db->db_fetch_array($query);
								   $button ="<input type=\"button\" name=\"savenew\"  value=\" Update \" onClick=\"article_data.form1.Flag.value='EditRSS'; AddForm();\">";
								}else{
								    $button ="<input type=\"button\" name=\"savenew\"  value=\" Save \" onClick=\"article_data.form1.Flag.value='AddNew'; AddForm();\">";
								}
								?>
								<form name="rssForm">
								<input type="hidden" name="cid" value="<?php echo $cid?>">
								  <tr> 
									<td width="10%">RSS Name : </td>
									<td  align="left"><input type="text" name="rss_title" size="50" value="<?php echo $G[rss_title] ?>"></td>
								  </tr>
								  <tr> 
									<td width="10%">RSS URL : </td>
									<td  align="left"><input type="text" name="rss_url" size="50"  value="<?php echo $G[rss_url] ?>"></td>
								  </tr>
								  <tr> 
									<td width="10%">RSS Row : </td>
									<td  align="left"><input type="text" name="rss_row" size="5"  value="<?php echo $G[rss_row] ?>"></td>
								  </tr>
								  <tr> 
									<td width="10%"></td>
									<td  align="left"><?php echo $button?></td>
								  </tr>
								  </form >
								</table>
							
							</td>
							
						  <td  align="right" valign="top">  <a name="deloff" style="display:none"><img src="../images/article_del_off.gif" width="20" height="20" border="0" align="absmiddle"> 
							<font color="#999999">Delete Selected</font></a><a name="delon" href="#del" onClick="DelForm()"><img src="../images/article_del.gif" width="20" height="20" border="0" align="absmiddle"> 
							Delete Selected</a>
							</td>
                          </tr>
                        </table>
					      
					  
					
						
						</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
