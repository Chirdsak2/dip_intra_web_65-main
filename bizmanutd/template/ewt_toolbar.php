<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="E2AD02">
    <tr>
      
    <td align="right" background="mainpic/toolbars.gif" bgcolor="#FFCC66" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
		  <tr>
			
          <td>&nbsp;<input type="button" name="Button2" value="My Website ..." onClick="self.location.href='ewt_mysite.php';" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma"> <input type="button" name="Button2" value="Add To Favorites" onClick="win2=window.open('favorite_add.php?title_name=<?php echo $F["title"];?>','favorite','width=500,height=300,resizable=1;scrollbars=1');win2.focus();" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma"> <input type="button" name="Button2" value="Customize this page" onClick="self.location.href='main3.php?filename=<?php echo $_GET["filename"]; ?>';" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma"><input type="button" name="Button" value=" ออกจากระบบ " onClick="if(confirm('ยืนยันออกจากระบบ')){self.location.href='logout.php';}" style="FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma"></td>
          <td  align="right"><nobr><span style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma">ยินดีต้อนรับ 
            คุณ <?php echo $_SESSION["EWT_NAME"];?> </span> </nobr> </td>
		  </tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" height="1">
  <tr height="1">
    <td height="1" bgcolor="#D5C54F"></td>
  </tr>
</table>

		</td>
    </tr>
  </table>
