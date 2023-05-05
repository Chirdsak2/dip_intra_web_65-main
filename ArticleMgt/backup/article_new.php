<?php
include("../EWT_ADMIN/comtop.php");
$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);
$nid = (int)(!isset($_GET['nid']) ? '' : $_GET['nid']);
function article_backto($cid){
	global $db;
	$s_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$cid}' ");
	 	if($db->db_num_rows($s_group)){
	 		$a_data = $db->db_fetch_array($s_group);
			if($a_data['c_parent'] != "0"){
			$txt = "article_list.php?cid={$a_data['c_parent']}";
			}else{
				$txt = "article_group.php";
			}
		}else{
			$txt = "article_group.php";
		}
	return $txt;
	
}
$time_H = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');	
$time_s = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');	

$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$cid}' ");
$G = $db->db_fetch_array($sql_group);
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
?>
<style type="text/css">

.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
.style1 {color: #FF0000}

</style>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><?=$txt_article_add;?></h4>
<p></p> 
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="article_group.php"><?=$txt_article_group;?></a></li>
<li class=""><?=$txt_article_add;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	

<a href="<?=article_backto($cid);?>" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>


</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
			<li><a href="<?=article_backto($cid);?>" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<div class="card-body">
<div class="row ">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"></div>
</div>

<div class="card-body" >

<form id="form_main" name="form1" action="article_function.php" method="post" enctype="multipart/form-data" onSubmit="return chk();">

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><b><?="หัวข้อข่าว";?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>        
<textarea name="topic" cols="60" rows="5"  id="topic" class="form-control" ><?=$R['n_topic'];?></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="c_name"><b><?="กลุ่มข่าว";?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>
<div class="form-inline"> 
<span id="txtshow"><?=$G['c_name']; ?></span>
<a href="#browse" onClick="boxPopup('<?=linkboxPopup();?>pop_article_select.php?cid=<?=$cid;?>');" >
<!--<a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_select.php?cid=<?=$_GET['cid']; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();">-->		
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-folder-open"></i>&nbsp;เลือกกลุ่มข่าว
</button>
</a> 
<input name="cid" type="hidden" id="cid" value="<?=$cid;?>">
</div>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><b><?="รายละเอียดหัวข้อข่าว";?> : </b></label>        
<textarea name="description" cols="60" rows="5"  id="description" class="form-control" ></textarea>
</div>
</div>

<div class="form-group row">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<label for="date_n"><b><?="วันที่ข่าว";?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>  
		<!--<input class="form-control" style="width:60%;" name="date_n" type="text" id="date_n" value="<?php //echo date("d")."/".date("m")."/".(date("Y")+543); ?>" size="10" readonly="true"> 
		<a href="#date" onClick="return show_calendar('form1.date_n');" title="เลือกวันที่ข่าว" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
		<span class="glyphicon glyphicon-calendar text-success" style="font-size:24px;color:#"></span>
		</a> -->
		<div class='input-group date ' id='datetimepicker' >
		<input name="date_n" id="date_n" type="text"  class="form-control form-control-sm datepicker " value="" readonly="readonly" required >
		<span class="input-group-addon">
		<a href="#date" onClick="return show_calendar('form1.date_n');" >
		<i class="far fa-calendar-alt"></i>
		</a>
		</span>
		</div>

	</div>				
	<div class="col-md-2 col-sm-2 col-xs-12">	
		<label for="time_n"><b><?="เวลาข่าว";?> : </b></label>  			
		<div class="form-inline"> 
			<div class="checkbox">
				<label>
				<input name="checkbox" id="checkbox"  type="checkbox"  value="Y" onClick="chktime(this);" checked /> 
				<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;แสดงเวลา 
				</label>
			</div>
			<input name="time_n" type="text" id="time_n" _style="display:none;width:50%;" class="form-control"   />    
		</div>
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12">
		<label for="file"><b><?="รูปประกอบข่าวในหน้าแรก";?> : </b></label>
		<input type="file" name="file" id="file" class="form-control" onchange="JSCheck_Img(this.id,this.value);" />
		<?php 
		$sql_Imsize = "SELECT site_info_max_img,site_type_img_file FROM site_info";
		$query_Imsize = $db->query($sql_Imsize);
		$rec_Imsize = $db->db_fetch_array($query_Imsize);
		?>
		<span class="text-danger">
		<code>
		<?=$rec_Imsize['site_type_img_file'];?>
		</code>
		</span>
		<br>
		<span class="text-danger"><code>
		ขนาดไฟล์ไม่เกิน <?=$rec_Imsize['site_info_max_img']; ?> MB.
		</code></span>
	</div>

	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<label for="article_tag">
			<b> Tags : <br>
				<span style="color:red">ใช้เครื่องหมาย , เพื่อแยก tag หรือคลิกนอกช่องใส่ tag</span>
			</b>
		</label>
		
		<input type="text" name="article_tag" id="article_tag" class="form-control" data-role="tagsinput" value="">
	</div>
</div>

<!--<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="source"><?//="ที่มา/แหล่งข่าว";?> : </label>        
<input name="source" type="text" id="source" onKeyUp="txt_data(this.value);"  autocomplete="off" class="form-control" />
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="source_url"><?//="URL ของที่มา/แหล่งข่าว";?> : </label>  
<input name="source_url" type="text" id="source_url" class="form-control"  />  
</div>
</div>
<div class="clearfix">&nbsp;</div>-->

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="detail_use"><b><?="Link ของข่าว/บทความ";?> : </b></label>  

<div class="radio">
          <label>
			<input name="detail_use" type="radio" id="at_id_1" value="1" checked onClick="tab('1');" /> 
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;แบบเชื่อมต่อไปยังหน้าเว็บหรือไฟล์เอกสาร 
          </label>
</div>
<div class="radio">
          <label>
			<input name="detail_use" type="radio" id="at_id_2" value="2" onClick="tab('2');" /> 
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;แบบ Template
          </label>
</div>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="";?>  </label>  
<div class="form-inline">  
<table width="100%" >
<tr valign="top" id="trb01"> 
            <td bgcolor="#FFFFFF"></td>
            <td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" class="table table-bordered">
               
			   <tr valign="top"> 
                <td width="30%" bgcolor="#FFFFFF">
				<div class="radio">
				<label>
				<input name="browsefile" type="radio" id="browsefile_1" value="1" checked="checked"  /> 
				<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;เลือก  URL ของเว็บหรือไฟล์ 
				</label>
				</div>
				</td>
				<td width="70%" bgcolor="#FFFFFF">
				<input class="form-control" style="width:80%;" name="link" type="text" id="link" onFocus="document.form1.browsefile[0].checked=true" />
				<a href="#browse" onClick="win2 = window.open('../FileMgt/article_main.php?stype=link&Flag=Link&o_value=window.opener.document.form1.link.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');document.form1.browsefile[0].checked=true;win2.focus();">
				<button type="button" class="btn btn-info  btn-sm " >
				<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
				</button>
				</a>
				</td>
				</tr>
				
                <tr valign="top" style="width:100%;">
				<td width="30%" bgcolor="#FFFFFF">
				<div class="radio">
				<label>
				<input name="browsefile" type="radio" id="browsefile_2" value="2"  c  /> 
				<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;เลือกไฟล์จากเครื่อง 
				</label>
				</div>				
				</td>
				<td bgcolor="#FFFFFF" style="width:100%;">
				
				<input type="file" name="filebrowse" id="filebrowse" style="width:100%;" onchange="JSCheck_file(this.id,this.value);"  onClick="document.form1.browsefile[1].checked=true" class="form-control" />
<br>
<?php 
$sql_file = "SELECT site_info_max_file,site_type_file FROM site_info";
$query_file = $db->query($sql_file);
$rec_file = $db->db_fetch_array($query_file);
?>
<span class="text-danger"><code>
<?=$rec_file['site_type_file'];?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ไม่เกิน <?=$rec_file['site_info_max_file']; ?> MB.
</code></span>
				</td>
                </tr>
				
				<tr bgcolor="#FFFFFF">
				<td colspan="2" >
				<div class="checkbox">
				<label>
				<input name="chk_show_count_level1" type="checkbox" id="chk_show_count_level1" value="3"   /> 
				<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;แสดงจำนวนการดาวน์โหลด[ครั้ง]
				</label>
				</div>
				</td>
				</tr>
				
			</table> 
				</td>
				</tr>
<tr valign="top" id="trb02" style="display:none;"> 
<td bgcolor="#FFFFFF"></td>
<td bgcolor="#FFFFFF">		
<table width="100%" border="0" class="table table-bordered">
<tr bgcolor="#F7F7F7"> 
<td bgcolor="#F7F7F7">
<img src="../images/arrow_r.gif" width="7" height="7" align="middle" />&nbsp;Template รูปแบบ Block</td>
</tr>
<tr align="center" bgcolor="#FFFFFF"> 
<td align="center" >
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<?php
$sql_at = $db->query("SELECT * FROM article_template where at_id = '3' ORDER BY at_id");
$a=0;
while($AT = $db->db_fetch_array($sql_at)){
if($a%3==0){
echo "<tr>";
	}
?>
						<td width="80%" align="center" bgcolor="#FFFFFF">
						
						<div align="center">
						<div class="radio">
						<label>
						<input name="at_id" type="radio" value="<?=$AT['at_id'];?>" <?php if($a == 0){ echo "checked"; } ?> onClick="document.form1.detail_use[1].checked=true"  /> 
						<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;Template
						</label>
						</div>
						
						</div>
						<img src="../article_template/pic/<?=$AT['at_pic']; ?>" width="64" height="64" />
					    </td>
<?php
							   if($a%3==2){
						  echo "</tr>";
						  }
					   $a++; } 
					   ?>
</table>
</td>
</tr>
</table></td>
</tr>
	  
</table>

</div>
</div>
</div>

<?php /*<div class="form-group row" style="display:none" id="vdomore">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><b><?="ประเภทไฟล์วิดีโอ";?> : </b></label>
<div class="form-inline">  
<div class="radio">
						<label>
						<input name="showvdo" type="radio"id="showvdo"  onclick="show();" value="1"  /> 
						<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>นำเข้าจากไฟล์ VIDEO
</div>
<div class="radio">
						<label>
						<input name="showvdo" type="radio"id="showvdo1"  onclick="show();" value="2"  /> 
						<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>นำเข้าจาก YOUTUBE	
</div>
</div>
</div>
</div> */ ?>

<?php
/*<div class="form-group row" style="display:none" id="vdomore2">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><b><?="ไฟล์วิดีโอ";?> : </b></label> 
<table width="100%" border="0" align="center">
<tr >
<td bgcolor="#FFFFFF"></td>
<td bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" id="vdo" class="table table-bordered">
<tr valign="top" id="tr_1"> 
<td bgcolor="#FFFFFF" class="form-inline" >
<input type="file" name="filevdo[]" class="form-control" style="width:100%;" />
&nbsp;<span style="cursor:pointer" onclick="fncaddRow();">
<button type="button" class="btn btn-success" >
<i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม
</button>
</span>
<br><span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น  (ขนาดไฟล์ต้องไม่เกิน 10 MB)</span>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</div>*/
?>

<?php /*<div class="form-group row" style="display:none" id="vdomore3">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><b><?="URL YOUTUBE";?> : </b></label> 
<table width="100%" border="0" align="center">
<tr>
<td bgcolor="#FFFFFF"></td>
<td bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" id="vdo2" class="table table-bordered">
<tr valign="top" bgcolor="#FFFFFF" id="tr2_1" > 
<td bgcolor="#FFFFFF" class="form-inline">
<input name="vdo_youtube[]" type="text" class="form-control" style="width:50%;" />
&nbsp;<span style="cursor:pointer" onclick="fncaddRow2();">
<button type="button" class="btn btn-success" >
<i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม
</button>
<!--<img src="../theme/main_theme/g_add.gif" width="16" height="16" align="" border="0">-->
</span>
<br><span class="style1">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span></td>
</tr> 
</table>
</td>
</tr>
</table>
</div>
</div>

<div style="display:none" id="experiences">
<div class="form-group row" id="vdomore1_1" >
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="address1"><b><?="แหล่งที่มาไฟล์วิดีโอ";?> : </b></label> 
<input name="address1[]" type="text" value=""  class="form-control"  />
</div>
<div class="col-md-5 col-sm-5 col-xs-12">	
<label for="address2"><b><?="Url";?> : </b></label> 
<input name="address2[]" type="text" value=""  class="form-control"  />
</div>
<div class="col-md-1 col-sm-1 col-xs-12">
<label for=""></label>
<a href="#experiences"  onclick="fncaddRow3();" >
	<button type="button" class="btn btn-success" >
	<i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่ม";?>
	</button>
	</a>	
</div>
</div>
</div> */ ?>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="target"><b><?="ลักษณะการเชื่อมต่อ";?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>        
<select name="target" id="select" class="form-control" >
<option value="_blank">เปิดหน้าต่างใหม่</option>
<option value="_self">เปิดหน้าต่างเดิม</option>
</select>
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="icon"><b><?="Icon ท้ายข่าว";?> : </b></label>  
<div class="form-inline"> 	
<span id="iconname">เลือกรูป</span>
<input type="hidden" name="icon" id="icon" value="<?=$R['logo'];?>">
<a href="#browse" onClick="boxPopup('<?=linkboxPopup();?>pop_article_icon.php?cid=<?=$cid;?>');" >
<!--<a href="#browse" title="เลือก Icon" onClick="win2 = window.open('article_icon.php?iconname='+window.form1.icon.value,'WebsiteLink','top=100,left=100,width=500,height=500,resizable=1,status=0,scrollbars=1');win2.focus();">-->
<button type="button" class="btn btn-info  btn-sm">
<i class="fas fa-folder-open"></i>&nbsp;เลือก Icon
</button>
</a>  
</div>    
</div>
<?php
$dateshowl= date ("Y-m-d", mktime (0,0,0,date("m"),date("d")+5,date("Y")));
$date = explode("-",$dateshowl);
?>
<div class="col-md-4 col-sm-4 col-xs-12">
<label for="date_e"><b><?="วันสิ้นสุดการแสดงไอคอน";?> : </b></label>    
                <div class='input-group date ' id='datetimepicker1' >
                     <input name="date_e" id="date_e" type="text"  class="form-control form-control-sm datepicker-icon" value="" readonly="readonly"  />
                    <span class="input-group-addon">
                         <a href="#date" onClick="return show_calendar('form1.date_e');" >
						 <i class="far fa-calendar-alt"></i>
						 </a>
                    </span>
                </div>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>

<div class="form-group row">
<div class="col-md-4 col-sm-4 col-xs-12">
<label for="date_start"><b><?="วันที่เริ่มต้นแสดงข่าว";?> : </b></label> 
       
<!--<input name="date_start" type="text" id="date_start" value="" size="10" class="form-control" > 
<a href="#date" onClick="return show_calendar('form1.date_start');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
<img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle">
</a>-->
<div class='input-group date ' id='datetimepicker2' >
                     <input name="date_start" id="date_start" type="text"  class="form-control form-control-sm datepicker-icon" value=""  readonly="readonly" />
                    <span class="input-group-addon">
                         <a href="#date" onClick="return show_calendar('form1.date_start');" >
						 <i class="far fa-calendar-alt"></i>
						 </a>
                    </span>
                </div>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="time_H_start"><b><?="เวลาเริ่มต้นแสดงข่าว";?> : </b></label>
<div class="form-inline"> 
<select name="time_H_start" id="time_H_start" class="form-control" >
<option value=""></option>
			  <?php for($i=0;$i<count($time_H);$i++){ ?>
			  <option value="<?php echo $time_H[$i];?>"><?php echo $time_H[$i];?></option>
			  <?php }?>
</select>
              :
              <select name="time_s_start" class="form-control" >
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_s);$i++){ ?>
			  <option value="<?php echo $time_s[$i];?>"><?php echo $time_s[$i];?></option>
			  <?php }?>
              </select>.น 
          
</div>
</div>
<div class="col-md-4 col-sm-4 col-xs-12">
<label for="date_end"><b><?="วันที่สิ้นสุดแสดงข่าว";?> : </b></label> 
       
<!--<input name="date_end" type="text" id="date_end" value="" size="10" class="form-control" style="width:20%;"> 
<a href="#date" onClick="return show_calendar('form1.date_end');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
<img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle">
</a>-->
<div class="input-group date " id='datetimepicker3' >
                    <input name="date_end" id="date_end" type="text"  class="form-control form-control-sm datepicker-icon" value="" readonly="readonly" />
                    <span class="input-group-addon">
                         <a href="#date" onClick="return show_calendar('form1.date_end');" >
						 <i class="far fa-calendar-alt"></i>
						 </a>
                    </span>
                </div>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="time_H_end"><b><?="เวลาสิ้นสุดแสดงข่าว";?> : </b></label>
<div class="form-inline"> 
<select name="time_H_end" id="time_H_end" class="form-control" >
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_H);$i++){ ?>
			  <option value="<?php echo $time_H[$i];?>"><?php echo $time_H[$i];?></option>
			  <?php }?>
              </select>
              :
             <select name="time_s_end" id="time_s_end" class="form-control" >
			  <option value=""></option>
			  <?php for($i=0;$i<count($time_s);$i++){ ?>
			  <option value="<?php echo $time_s[$i];?>"><?php echo $time_s[$i];?></option>
			  <?php }?>
              </select>.น
</div>
</div>


<div class="form-group row "  >	  
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;top:50px;">
<button type="submit" class="btn btn-success  btn-ml " >
<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?="บันทึก";?>
</button>
<input name="Flag" type="hidden" id="Flag" value="AddArticle">
<input name="apl" type="hidden" id="apl" value="">
<button type="reset" class="btn btn-warning  btn-ml " >
<span class="glyphicon glyphicon-repeat"></span>&nbsp;<?="ยกเลิก";?>
</button>
<input type="hidden" id="temp_num" name="temp_num" value="1" />
<input type="hidden" id="temp_num2" name="temp_num2" value="1" />
<input type="hidden" id="temp_num3" name="temp_num3" value="1" />
</div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
</div>

</div>
</div>
</div>

</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script >
$(document).ready(function() {
	chktime(document.getElementById("checkbox"));	
	var today = new Date();
	$('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			autoclose: true,
			todayHighlight: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate","0");   
		 
$('.datepicker-icon').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			autoclose: true,
			todayHighlight: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		
});

function show(){
	var b =document.getElementById("showvdo").value;
	var bc =document.getElementById("showvdo1").value;
	if(document.getElementById("showvdo").checked==true){
	document.getElementById("vdomore2").style.display='';
	document.getElementById("vdomore3").style.display='none';
    }if(document.getElementById("showvdo1").checked==true){
	document.getElementById("vdomore2").style.display='none';
    document.getElementById("vdomore3").style.display='';
	}
}

function tab(id){

if(id=='2'){	
//document.getElementById("vdomore").style.display='';
//document.getElementById("experiences").style.display='';
document.getElementById("trb01").style.display='none';
document.getElementById("trb02").style.display='';
//document.getElementById("trb04").style.display='none';
document.getElementById("trb05").style.display='none';

}else{
//document.getElementById("vdomore").style.display='none';
//document.getElementById("experiences").style.display='none';
//document.getElementById("vdomore2").style.display='none';
//document.getElementById("vdomore3").style.display='none';
document.getElementById("trb01").style.display='';
document.getElementById("trb02").style.display='none';
//document.getElementById("trb04").style.display='none';
document.getElementById("trb05").style.display='none';
	
	}
}


function del_row(id){
		if(confirm('คุณต้องการลบรายการ?')){
		$('#tr_'+id).remove();
		$('#filevdo'+id).val('del');

	}
}	

function del_row3(id){
		if(confirm('คุณต้องการลบรายการ?')){
		$('#vdomore1_'+id).remove();
		$('#address1'+id).val('del');
		$('#address2'+id).val('del');

	}
}

function del_row2(id){
		if(confirm('คุณต้องการลบรายการ?')){
		$('#tr2_'+id).remove();
		$('#vdo_youtube'+id).val('del');

	}
}

	
function fncaddRow(){
	var run=parseInt($('#temp_num').val())+parseInt(1);
	var html='';
	html+='<tr valign="top" bgcolor="#FFFFFF" id="tr_'+run+'" >';
	//html+='<td>&nbsp;</td>';
	html+='<td width="100%" class="form-inline">';
	html+='<input name="filevdo[]"  id="filevdo'+run+'" type="file"  class="form-control" style="width:50%;"  />';
	html+='&nbsp;&nbsp;<span style="cursor:pointer" onclick="del_row('+run+')">';
	//html+='<img border="0" src="../theme/main_theme/g_del.gif" width="16" height="16">
	html+='<button type="button" class="btn btn-danger" >';
	html+='<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;ลบ';
	html+='</button>';
	html+='</span>';
	html+='</td>';
	html+='</tr>';
	$("#vdo").append(html);
	$('#temp_num').val(run);
   
	}
	
function fncaddRow2(){
	var run=parseInt($('#temp_num2').val())+parseInt(1);
	var html='';
	html+='<tr valign="top" bgcolor="#FFFFFF" id="tr2_'+run+'" >';
	//html+='<td>&nbsp;</td>';
	html+='<td width="100%" class="form-inline">';
	html+='<input name="vdo_youtube[]" id="vdo_youtube'+run+'" type="text"  class="form-control" style="width:50%;" />';
	html+='&nbsp;&nbsp;<span style="cursor:pointer" onclick="del_row2('+run+')">';
	//html+='<img border="0" src="../theme/main_theme/g_del.gif" width="16" height="16">';
	html+='<button type="button" class="btn btn-danger" >';
	html+='<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;ลบ';
	html+='</button>';
	html+='</span>';
	html+='</td>';
	html+='</tr>';
	$("#vdo2").append(html);
	$('#temp_num2').val(run);
   
	}
	
function fncaddRow3(){
	var run=parseInt($('#temp_num3').val())+parseInt(1);
	var html='';	
html+='<div class="form-group row" id="vdomore1_'+run+'" >';
html+='<div class="col-md-6 col-sm-6 col-xs-12">';
html+='<label for="address1">แหล่งที่มาไฟล์วิดีโอ  : </label>';
html+='<input name="address1[]" id="address1'+run+'" type="text" value=""  class="form-control"  />';
html+='</div>';
html+='<div class="col-md-5 col-sm-5 col-xs-12">';	
html+='<label for="address2">Url : </label> ';
html+='<input name="address2[]" id="address2'+run+'" type="text" value=""  class="form-control"  />';
html+='</div>';
html+='<div class="col-md-1 col-sm-1 col-xs-12">';
html+='<label for=""></label>';
html+='<a href="#experiences"  onclick="del_row3('+run+')"  >';
html+='<button type="button" class="btn btn-danger" >';
html+='<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;ลบ';
html+='</button>';
html+='</a>	';
html+='</div>';
html+='</div>';
$("#experiences").append(html);
$("#experiences").focus;
$('#temp_num3').val(run);
   
	}	
	

	
function chktime(c){
current_local_time = new Date();
	var nhours = current_local_time.getHours();
	var nmin = current_local_time.getMinutes();
	var nsec = current_local_time.getSeconds();
		if(nhours < 10){
	nhours = "0" + nhours;
	}
		if(nmin < 10){
	nmin = "0" + nmin;
	}
		if(nsec < 10){
	nsec = "0" + nsec;
	}
	 var ntime = nhours + ":" + nmin + ":" +nsec;
	if(c.checked == true){
		document.form1.time_n.style.display = '';
		document.form1.time_n.value = ntime;
	}else{
		document.form1.time_n.style.display = 'none';
		document.form1.time_n.value = "";
	}
}
function chk(){
		/*var objDiv = document.getElementById("nav");
					url='app_list.php?cid='+ document.form1.cid.value;
					AjaxRequest.get(
						{
							'url':url
							,'onLoading':function() { }
							,'onLoaded':function() { }
							,'onInteractive':function() { }
							,'onComplete':function() { }
							,'onSuccess':function(req) { 
							}
						}
					);*/
	if(document.form1.topic.value == ""){
		$('#topic').focus();	
		$.alert({
						title: 'กรุณากรอกหัวข้อข่าว',
						content: '',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
						
		//document.form1.topic.focus();
		return false;
	}
	if(document.form1.cid.value == ""){
		//alert("Please choose group!");
		$('#cid').focus();	
		$.alert({
						title: 'กรุณาเลือกกลุ่มข่าว',
						content: '',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
		win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();
		return false;
	}
	if(document.form1.date_n.value == ""){
		$('#date_n').focus();	
		$.alert({
						title: 'กรุณากรอกวันที่ข่าว',
						content: '',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
						
		//document.form1.date_n.focus();
		return false;
	}
	if(document.form1.detail_use[0].checked == true){
		if(document.form1.browsefile[0].checked == true){
				if(document.form1.link.value == ""){
					$('#link').focus();	
					$.alert({
						title: 'กรุณากรอก URL ของเว็บหรือไฟล์',
						content: '',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
					//alert("Please insert link!!");
					//document.form1.link.focus();
					return false;
				}
		}
		if(document.form1.date_start.value != "" && document.form1.date_end.value == ''){
					alert("โปรดใส่วันที่สิ้นสุด!!");
					document.form1.date_end.focus();
					return false;
		}
		
		if(document.form1.date_start.value == "" && document.form1.date_end.value != ''){
					alert("โปรดใส่วันที่เริ่มต้น!!");
					document.form1.date_start.focus();
					return false;
		}
		if(document.form1.browsefile[1].checked == true){
					if(document.form1.filebrowse.value == ""){
					$('#filebrowse').focus();	
					$.alert({
						title: 'กรุณาเลือกไฟล์จากเครื่อง',
						content: '',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
					//alert("Please insert file!!");
					//document.form1.filebrowse.focus();
					return false;
					}
			}
	}
			
			if(document.form1.detail_use[3].checked == true){
					if(document.form1.filedl.value == ""){
					alert("Please insert file!!");
					document.form1.filedl.focus();
					return false;
					}
			}
	article_chkp.location.href = "article_check_p.php?cid="+document.form1.cid.value;		
	return false;
}
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data(w) {
	var mytop = findPosY(document.form1.source) +document.form1.source.offsetHeight;
	var myleft = findPosX(document.form1.source);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='plan_list.php?d='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
			}
		}
	);

}
</script>


<script src="../js/bootstrap-tagsinput.js"></script>