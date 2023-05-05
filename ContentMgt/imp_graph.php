<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Import graph</title>
<SCRIPT LANGUAGE="JavaScript">
function customize(form,Flag) { 

var op_wid = document.form1.wid.value; 
var op_heigh = document.form1.hei.value; 
var op_url = document.form1.xmlurl.value; 
var op_type = document.form1.mytype.value; 

var fulltext = "<div align=\"center\"><OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\""+op_wid+"\" height=\""+op_heigh+"\" id=\"Column3D\" ><param name=\"movie\" value=\"chart/"+op_type+"\" /><param name=\"FlashVars\" value=\"&dataURL="+op_url+"&chartWidth="+op_wid+"&chartHeight="+op_heigh+"\">  <param name=\"quality\" value=\"high\" /><embed src=\"chart/"+op_type+"\" quality=\"high\" name=\"Column3D\"    flashVars=\"&dataURL="+op_url+"&chartWidth="+op_wid+"&chartHeight="+op_heigh+"\" width=\""+op_wid+"\" height=\""+op_heigh+"\"type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" /></object></div>";
window.opener.document.htmlform.contentHtml.value = window.opener.document.htmlform.contentHtml.value + fulltext;
window.close();

}

</SCRIPT>
</head>

<body>
<table width="96%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC" style="font-family:Tahoma; font-size:13px">
<FORM name="form1"   METHOD="POST">
  <tr>
    <td colspan="4" bgcolor="#FFFFFF"><strong>ตั้งค่าการนำเข้ากราฟจากภายนอก</strong></td>
    </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF">รูปแบบกราฟ<table width="100%" border="0" cellspacing="0" cellpadding="4"  style="font-family:Tahoma; font-size:13px">
                            <tr align="center"> 
							<td width="10%" align="right" ><input name="g_type" type="radio" value="FCF_MSArea2D.swf" checked  onClick="document.form1.mytype.value = this.value"></td>
                              <td width="40%" align="left"><img src="../images/graph_area.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Area Graph</td>
								<td width="10%" align="right" ><input type="radio" name="g_type" value="FCF_MSLine.swf" onClick="document.form1.mytype.value = this.value"></td>
                              <td width="40%" align="left"><img src="../images/graph_line.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Line Graph</td>
                            </tr>
                            <tr align="center"> 
							<td align="right" ><input type="radio" name="g_type" value="FCF_MSColumn2D.swf"  onClick="document.form1.mytype.value = this.value"></td>
                              <td align="left"><img src="../images/graph_column.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Column Graph</td>
								
                              <td align="right" ><input type="radio" name="g_type" value="FCF_MSColumn3D.swf"  onClick="document.form1.mytype.value = this.value"></td>
                              <td align="left"><img src="../images/graph_column.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Column Graph 3D</td>
                            </tr>
                            <tr align="center"> 
							<td align="right" ><input type="radio" name="g_type" value="FCF_MSBar2D.swf"  onClick="document.form1.mytype.value = this.value"></td>
                              <td align="left"><img src="../images/graph_row.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Bar Graph</td>
								<td align="right" ><input type="radio" name="g_type" value="FCF_MSBar2D.swf"  onClick="document.form1.mytype.value = this.value"></td>
                              <td align="left"><img src="../images/graph_row.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Bar Graph 3D</td>
                            </tr>
                            <tr align="center">
							<td align="right" ><input type="radio" name="g_type" value="FCF_Pie2D.swf"  onClick="document.form1.mytype.value = this.value"></td>
                              <td align="left"><img src="../images/graph_pie.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Pie Graph</td>
								<td align="right" ><input type="radio" name="g_type" value="FCF_Pie3D.swf"  onClick="document.form1.mytype.value = this.value"></td>
                              <td align="left"><img src="../images/graph_pie.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Pie Graph 3D</td>
                            </tr>
                            
                          </table></td>
    </tr>
  <tr>
    <td width="23%" bgcolor="#FFFFFF">URL ไฟล์ xml 
      <input name="mytype" type="hidden" id="mytype" value="FCF_MSArea2D.swf"></td>
    <td width="77%" colspan="3" bgcolor="#FFFFFF"><INPUT NAME="xmlurl" TYPE="text" id="xmlurl" size="50" > 
      <a href="#help" onClick="window.open('imp_graph_help.php','','width=500,height=400,scrollbars=1');"><img src="../images/help.gif" width="16" height="16" border="0" align="absmiddle"> help</a></td>
  </tr>
  <tr>
    <td width="23%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="77%" colspan="3" bgcolor="#FFFFFF">กว้าง <INPUT NAME="wid" TYPE="text" value="500" size="5" > 
 สูง <INPUT NAME="hei" TYPE="text" id="hei" value="400" size="5" > </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td colspan="3" bgcolor="#FFFFFF"><input type="button" name="Submit2" value="  Save  " OnClick="customize(this.form,'1')"></td>
  </tr></FORM>
</table>
</CENTER>
</body>
</html>
