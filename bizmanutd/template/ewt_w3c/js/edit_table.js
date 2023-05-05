path = '../';
function edit_table05(action, pter, s , fromDB, member_id, unit_id, act_id, detail_id, detail_name, subdetail_type, children, content05_id, cmd_act05) { // 
	//if(action=='add') {
		var myObj = opener.document.getElementById('tb_status_a'+s);	
	//} else {
	//	var myObj = document.getElementById('tb_status_a'+s);	
	//}
	var numRows = myObj.rows.length;	
//	var numCols = myObj.rows[0].cells.length; // ถ้าไม่มีหัวตารางมาก่อน ก็อ้างไม่ได้
	var cellData   = new Array ();	
	var cellTb = new Array ();
	var cellAlign = new Array ();
	var rowTb;
	var amtCell = 1; // ** ถ้าไม่มีหัวตารางมาก่อน ก็ต้อง fix ไปเอง
	
		cellAlign[0] ='left'; 				
		rowIndex = numRows+1;
	   //alert('แถวทั้งหมด = '+rowIndex);
	    rowTBI = rowIndex-1;
 	cellData[0]='&bull; '+detail_name+'<input name="detail_name'+s+'_'+rowIndex+'" type="hidden" value="'+detail_name+'" /><input name="detail_con05_id'+s+'_'+rowIndex+'" type="hidden" /><input name="children'+s+'_'+rowIndex+'" type="hidden" value="'+children+'"  /><input name="use_act_id'+s+'_'+rowIndex+'" type="hidden" value="'+act_id+'"  /><input name="detail_id'+s+'_'+rowIndex+'" type="hidden" value="'+detail_id+'" /><input name="subdetail_type'+s+'_'+rowIndex+'" type="hidden" value="'+subdetail_type+'" /><br>';
		if( children == '0' ) { // ถ้า $detail_group_id ไม่มีรายการลูก
			cellData[0]+='<strong>ผลการติดตาม</strong> <input name="result_follow'+s+'_'+rowIndex+'" type="radio" value="1" /> ดีขึ้น <input name="result_follow'+s+'_'+rowIndex+'" type="radio" value="2" /> ไม่เปลี่ยนแปลง <br />';
			cellData[0]+='<table bgcolor="#99CCFF" border="0" cellspacing="0" cellpadding="2"><tr><td valign="top">สรุปสภาพโดยย่อ<br>	';
			cellData[0]+='<textarea name="summary'+s+'_'+rowIndex+'" rows="3" cols="40" ></textarea></td><td valign="top">ข้อเสนอแนะ<br>';	
			cellData[0]+='<textarea name="comment'+s+'_'+rowIndex+'" rows="3" cols="40" ></textarea></td></tr></table>';
		 } // end  ถ้า $detail_group_id ไม่มีรายการลูก
//	cellData[0]+='<img src="'+path+'images/delete24.gif" alt="ลบกิจกรรมหลักและย่อย" width="20" height="20" border="0" align="absmiddle" style="cursor:pointer"  onClick=" if(confirm(\'ยืนยันการลบหรือไม่?\')) { edit_table05(\'del\','+rowTBI+',\''+s+'\', 0); } ">';
	cellData[0]+='<img src="'+path+'images/add.gif"  onClick="new_win_def_print (\'choose_act_child05.php?status_a='+s+'&member_id='+member_id+'&select_unit='+unit_id+'&content05_id='+content05_id+'&detail_id='+detail_id+'&subdetail_type='+subdetail_type+'&cmd_act05='+cmd_act05+'\', \'list1\', 600, 500, 1,0,\'no\')" style="cursor:hand" alt="เพิ่มกิจกรรมย่อย"><br>';
	cellData[0]+='<table id="tb_child'+s+'_'+rowIndex+'"  width="100%" border="0" cellspacing="3"></table><input name="total_child'+s+'_'+rowIndex+'" type="hidden" />';
	

		//alert(action);
		 if(action=='add') {
				rowTb = myObj.insertRow(numRows);				
				
				for (i=0;i<amtCell;i++) { 
					cellTb[i] = rowTb.insertCell(i);
					cellTb[i].bgColor =""; // **
					cellTb[i].innerHTML= cellData[i];
					cellTb[i].align = cellAlign[i];
					//cellTb[0].width = "50"; 
				}//for
				// alert('เพิ่มแถวตารางที่ '+rowTBI+'; แถวข้อมูลที่ = '+rowIndex+'\n'+cellData[0]);			
		 }// action add
		else if(action=='del') {			
							
				alert('จะลบแถวตารางที่ = '+pter+'; แถวข้อมูลที่ = '+eval(pter+1));		
																			
				myObj.deleteRow(pter);		
				alert('จะเลื่อนขึ้นตั้งแต่แถวข้อมูลที่ = '+eval(pter+1)+' ถึง ก่อนแถวที่ '+numRows);				
				tag='';
				// จำไว้ว่า บรรทัดสุดท้าย จะไม่ต้องเข้ามาทำ loop for นี้  เพราะบรรทัดสุดท้าย ไม่มีข้อมูลให้เลื่อนขึ้นอีกแล้ว					
				
				   for(j=eval(pter+1);j<(numRows-1);j++){
						numj = parseInt(j)+1;
						
						 alert('เก็บค่าของแถวที่ = '+numj+' เข้า object ของแถวที่ '+j);
						next_detail_name = opener.document.frm['detail_name'+s+'_'+numj].value; 
						next_children = opener.document.frm['children'+s+'_'+numj].value; 
						next_use_act_id = opener.document.frm['use_act_id'+s+'_'+numj].value;
						next_detail_id = opener.document.frm['detail_id'+s+'_'+numj].value;
						next_subdetail_type = opener.document.frm['subdetail_type'+s+'_'+numj].value;
					//	next_result_follow = document.frm['result_follow'+s+'_'+numj].checked; 
						next_summary = opener.document.frm['summary'+s+'_'+numj].value; 
						next_comment = opener.document.frm['comment'+s+'_'+numj].value; 

						if(fromDB==1) {
							next_detail_con05_id = opener.document.frm['detail_con05_id'+s+'_'+numj].value; 
						}	else {
							next_detail_con05_id ='';
						}									
						
				tag='&bull; '+next_detail_name+'<input name="detail_name'+s+'_'+j+'" type="hidden" value="'+next_detail_name+'" /><input name="detail_con05_id'+s+'_'+j+'" type="hidden" value="'+next_detail_con05_id+'" /><input name="children'+s+'_'+j+'" type="hidden" value="'+next_children+'"  /><input name="use_act_id'+s+'_'+j+'" type="hidden" value="'+next_use_act_id+'"  /><input name="detail_id'+s+'_'+j+'" type="hidden" value="'+next_detail_id+'" /><input name="subdetail_type'+s+'_'+j+'" type="hidden" value="'+next_subdetail_type+'" /><br>';
					if( next_children == '0'  ) { // ถ้า $detail_group_id ไม่มีรายการลูก
						tag+='<strong>ผลการติดตาม</strong> <input name="result_follow'+s+'_'+j+'" type="radio" value="1" /> ดีขึ้น <input name="result_follow'+s+'_'+j+'" type="radio" value="2" /> ไม่เปลี่ยนแปลง <br />';
						tag+='<table bgcolor="#99CCFF" border="0" cellspacing="0" cellpadding="2"><tr><td valign="top">สรุปสภาพโดยย่อ<br>	';
						tag+='<textarea name="summary'+s+'_'+j+'" rows="3" cols="40" >'+next_summary+'</textarea></td><td valign="top">ข้อเสนอแนะ<br>';	
						tag+='<textarea name="comment'+s+'_'+j+'" rows="3" cols="40" >'+next_comment+'</textarea></td></tr></table>';
					 } // end  ถ้า $detail_group_id ไม่มีรายการลูก
//				tag+='<img src="'+path+'images/delete24.gif" alt="ลบกิจกรรมหลักและย่อย" width="20" height="20" border="0" align="absmiddle" style="cursor:pointer"  onClick=" if(confirm(\'ยืนยันการลบหรือไม่?\')) { edit_table05(\'del\','+(j-1)+',\''+s+'\', '+fromDB+'); } ">';
				tag+='<img src="'+path+'images/add.gif"  onClick="new_win_def_print (\'choose_act_child05.php?status_a='+s+'&member_id='+member_id+'&select_unit='+unit_id+'&content05_id='+content05_id+'&detail_id='+detail_id+'&subdetail_type='+subdetail_type+'&cmd_act05='+cmd_act05+'\', \'list1\', 600, 500, 1,0,\'no\')" style="cursor:hand" alt="เพิ่มกิจกรรมย่อย"><br>';
				tag+='<table id="tb_child'+s+'_'+j+'"  width="100%" border="0" cellspacing="3">';
			
			/*  loop for k  นี้เป็นของ สร02 ต้องมาแก้อีกที 
				var next_status_sh = new Array();
																
					   for(k=1;k<=document.frm['tot_stg_subhelp_ids'+s+'_'+eval(j+1)].value;k++) {
					   		
							numk = parseInt(k); // +1; ลืมไปว่าถ้าลบที่ ตารางนอก แต่ตารางในไม่ได้ลบแถว จึงไม่ต้อง +1
							
							//alert('เก็บค่าของแถวข้อมูลที่ = '+numk+' เข้า object ของแถวที่ '+k);
							
							//next_para[k] = document.frm['paraF'+eval(j+1)+'_'+numk].value; 
							next_status_sh[k] = document.frm['status_sh'+s+'_'+eval(j+1)+'_'+numk].checked; 
							next_subhelp_id = document.frm['subhelp_id'+s+'_'+eval(j+1)+'_'+numk].value; 
							next_subhelp_text = document.frm['subhelp_text'+s+'_'+eval(j+1)+'_'+numk].value; 
							//next_message = document.frm['message'+s+'_'+num].value; 
							
							//alert('เก็บค่าของตารางลำดับที่ '+eval(j+1)+' แถวข้อมูลที่ = '+numk+' เข้า object ของแถวข้อมูลที่ '+k);
							// ใช้ check ตัวแปร ได้เข้าใจง่าย
							
							if(fromDB==1) {
								next_stg_subhelp_id = document.frm['stg_subhelp_id'+s+'_'+eval(j+1)+'_'+numk].value; 	
							}	else {
								next_stg_subhelp_id ='';
							}									
					
						tag+='<tr ><td class="form_thai" width="35" align="center"><input name="stg_subhelp_id'+s+'_'+j+'_'+k+'" type="hidden" value="'+next_stg_subhelp_id+'"><input name="status_sh'+s+'_'+j+'_'+k+'" type="checkbox" value="1"></td><td class="form_thai" width="400" align="left"><input name="subhelp_id'+s+'_'+j+'_'+k+'" type="hidden" value="'+next_subhelp_id+'"><input name="subhelp_text'+s+'_'+j+'_'+k+'" type="text" class="Form-TextClick" readonly size="70" value="'+next_subhelp_text+'"  onClick=" if(!this.disabled) { window.open(\'<?=$path;?>libs/choose_subhelp.php?obj_name_id=subhelp_id'+s+'_'+j+'_'+k+'&obj_name_text=subhelp_text'+s+'_'+j+'_'+k+'&help_id=\'+document.frm[\'help_id'+s+'_'+j+'\'].value,\'choose_subhelp\',\'menubars=no,toolbars=no,resizable=yes,scrollbars=yes,status=yes,width=450,height=300\') }" ></td><td class="form_thai" align="center"><img src="../images/delete.gif" alt="ลบ" border="0" align="absmiddle" style="cursor:pointer"  onClick=" if(confirm(\'ยืนยันการลบหรือไม่?\')) {  if( \''+next_stg_subhelp_id+'\' != \'\' )	{	document.frm[\'del_stg_subhelp_ids'+s+'_'+j+'\'].value+=\''+next_stg_subhelp_id+',\';   } edit_tableF(\'del\', '+(k-1)+', '+j+', '+s+', '+fromDB+'); } "></td></tr>';
							//tag+='<tr align="center"><td class="form_thai"><SELECT  class="Form-TextField"  name="paraF'+j+'_'+k+'" size="1" onChange="loadvalue(this, document.frm[\'std_valueF'+j+'_'+k+'\'], document.frm[\'std_idF'+j+'_'+k+'\'] )"><option value="">--โปรดเลือก--</option>'+document.frm.opt_paraset.value+'</SELECT><input name="time_para_idF'+j+'_'+k+'" type="hidden" value="'+next_time_para+'"></td><td class="form_thai"><input name="std_valueF'+j+'_'+k+'" type="text"  size="10" maxlength="20" class="qty" onKeyPress="return NoDbCode()" value="'+next_std_value+'"><input name="std_idF'+j+'_'+k+'" type="hidden" value="'+next_std_id+'"></td><td class="form_thai"><input name="test_valueF'+j+'_'+k+'" type="text"  size="10" maxlength="20" class="qty" onKeyPress="return NoDbCode()" value="'+next_test_value+'"></td><td class="form_thai"><img src="'+path+'images/delete.gif" alt="ลบ" width="16" height="16" border="0" align="absmiddle" style="cursor:pointer" onClick=" if(confirm(\'ยืนยันการลบหรือไม่?\')) { if(\''+next_time_para+'\' != \'\') { document.frm[\'del_idsF'+j+'\'].value+=\''+next_time_para+',\'; }  edit_tableF(\'del\','+(k-1)+',\''+j+'\', '+fromDB+' ); } "></td></tr>';							
							//alert(tag);										   					
							
					  } // end for k
				//	tag+='</table></td></tr></table><input name="del_idsF'+j+'" type="hidden"><input name="tot_paraF'+j+'" type="hidden" value="'+(--k)+'" >';
			*/
				tag+='</table><input name="del_detail_con05_ids'+s+'_'+j+'" type="hidden"><input name="total_child'+s+'_'+j+'" type="hidden"  >'; // value="'+(--k)+'"
	
				
				
					//alert(tag);	
					
					myObj.rows[j-1].cells[0].innerHTML=tag;
					
						/*document.frm['status_h'+s+'_'+j].checked = next_status_h; 	
						
						for(k=1;k<=document.frm['tot_stg_subhelp_ids'+s+'_'+j].value;k++) { 
							 // document.frm['tot_paraF'+eval(j+1)].value โดนแทนที่ไปด้วย innerHTML=tag; ไปแล้ว จึงต้องอ้าง j แทน
							document.frm['status_sh'+s+'_'+j+'_'+k].checked = next_status_sh[k]; 
							//list_selected(document.frm['paraF'+j+'_'+k], next_para[k]);	 // ต้องย้ายมา list_selected ทีหลังจาก
							// ใช้ innerHTML  เพราะใน loop for เก็บค่า tag ยังไม่ได้ set innerHTML
						}		*/
				  }
				 
		}
		opener.document.frm['total_mom'+s].value = myObj.rows.length; // 
}	