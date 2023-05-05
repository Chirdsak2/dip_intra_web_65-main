<?php
include("../EWT_ADMIN/comtop_pop.php");
$m_id = (int)(!isset($_GET['m_id']) ? 0 : $_GET['m_id']); 
	function chkMenuSub($s_mid,$s_pid)
	{ 
	global $db;  
		$_sql 	= $db->query("SELECT * 
				   FROM menu_properties 
				   WHERE m_id = '{$s_mid}' AND mp_sub = '{$s_pid}'  
				   ");		
		$a_row	=  $db->db_num_rows($_sql);
		if($a_row)
		{
			return true;	
			}
			else
			{
				return false;	
			}
	}
	function genMenuView($s_mid) 
	{	
	global $db; 
		/*$_sql 	= "SELECT * 
			       FROM menu_properties 
			       WHERE m_id = '{$s_mid}' AND mp_sub = '0' AND mp_show = 'Y' ORDER BY mp_pos ASC ";	 */ 	
		//$a_row	= ewtDB::getRowCount($_sql);
		//$a_data = ewtDB::getFetchAll($_sql,'',PDO::FETCH_ASSOC);	
		$_sql = $db->query("SELECT * 
							FROM menu_properties 
							WHERE m_id = '{$s_mid}' AND mp_sub = '0' AND mp_show = 'Y' ORDER BY mp_pos ASC ");
		$a_row = $db->db_num_rows($_sql);
		if($a_row > 0)
		{
		echo '<div class="stellarnav">';
		echo '<ul>';
		while($_item = $db->db_fetch_array($_sql))
		{
			if($_item['Ouitalic'] == 'italic')
			{
				$Ouitalic = 'font-style:'.$_item['Ouitalic'].';';
				}
				else
				{
					$Ouitalic = '';	
				}
			if($_item['Oubold'] == 'bold')
			{
				$Oubold = 'font-weight:'.$_item['Oubold'].';';
				}
				else
				{
					$Oubold = '';	
				}
			if($_item['Oubordercolor'] == 'underline')
			{
				$Oubordercolor = 'text-decoration:'.$_item['Oubordercolor'].';';
				}
				else
				{
					$Oubordercolor = '';	
				}
				 
		if($_item['mp_show'] == 'Y')
		{
		if(chkMenuSub($s_mid,$_item['mp_pid']))
		{
		echo '<li class="text-'.$_item['Oufont'].'"><a >';
			if(!empty($_item['Oubgpic']))
			{
				echo '<i class="'.$_item['Oubgpic'].'"></i> ';
				}				
		echo '<span style="'.$Oubold.$Ouitalic.$Oubordercolor.'"  >'.$_item['mp_name'].'</span>';
		echo '</a>';
				genMenuViewSub($s_mid,$_item['mp_pid']);
		echo '</li>';	
			}else{
			echo '<li class="text-'.$_item['Oufont'].'" ><a >';
			if(!empty($_item['Oubgpic']))
			{
				echo '<i class="'.$_item['Oubgpic'].'"></i> ';
				}

			echo '<span style="'.$Oubold.$Ouitalic.$Oubordercolor.'" class="text-'.$_item['Oufont'].'" >'.$_item['mp_name'].'</span>';
		    echo '</a>';
			echo '</li>';
				}
		}	
			}		
		echo '</ul>';
		echo '</div>';	
		}
	}
	
	function genMenuViewSub($s_mid,$s_pid)
	{
	global $db ; 		
		/*$_sql 	= "SELECT * 
			       FROM menu_properties 
			       WHERE m_id = '{$s_mid}' AND mp_sub = '{$s_pid}' AND mp_show = 'Y' ORDER BY mp_pos ASC ";	  	
		$a_row	= ewtDB::getRowCount($_sql);
		$a_data = ewtDB::getFetchAll($_sql,'',PDO::FETCH_ASSOC);*/	
		
		$_sql = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$s_mid}' AND mp_sub = '{$s_pid}' ORDER BY mp_pos ASC");
		$a_row = $db->db_num_rows($_sql);
		if($a_row)
		{
		echo '<ul>';
		while($_item = $db->db_fetch_array($_sql))
		{
	
			if($_item['Ouitalic'] == 'italic')
			{
				$Ouitalic = 'font-style:'.$_item['Ouitalic'].';';
				}
				else
				{
					$Ouitalic = '';	
				}
			if($_item['Oubold'] == 'bold')
			{
				$Oubold = 'font-weight:'.$_item['Oubold'].';';
				}
				else
				{
					$Oubold = '';	
				}
			if($_item['Oubordercolor'] == 'underline')
			{
				$Oubordercolor = 'text-decoration:'.$_item['Oubordercolor'].';';
				}
				else
				{
					$Oubordercolor = '';	
				}
		if($_item['mp_show'] == 'Y')
		{		
		if(chkMenuSub($s_mid,$_item['mp_pid']))
			{
		echo '<li class="text-'.$_item['Oufont'].'"><a >';
			if(!empty($_item['Oubgpic']))
				{
					echo '<i class="'.$_item['Oubgpic'].' "></i> ';
					} 
		echo '<span style="'.$Oubold.$Ouitalic.$Oubordercolor.'" >'.$_item['mp_name'].'</span>';
		echo '</a>';
				genMenuViewSub($s_mid,$_item['mp_pid']);
		echo '</li>';
		
			}else{
			echo '<li class="text-'.$_item['Oufont'].'"><a >';
			if(!empty($_item['Oubgpic']))
				{
					echo '<i class="'.$_item['Oubgpic'].'"></i> ';
					} 
			echo '<span style="'.$Oubold.$Ouitalic.$Oubordercolor.'" class="text-'.$_item['Oufont'].'" >'.$_item['mp_name'].'</span>';
		    echo '</a>';
			echo '</li>';
				}
		}
			}
		echo '</ul>';
		}
	}
	
$_sql_list   = $db->query("SELECT m_id,m_name FROM menu_list WHERE m_id = '{$m_id}' ");		  
$a_rows_list = $db->db_num_rows($_sql_list);		
$a_menu      = $db->db_fetch_array($_sql_list);	
?>  
  
<!--<span class="far fa-times-circle fa-2x" onclick="$('#box_popup').fadeOut();"  style="font-size:24px;position:absolute; top:10px; right : 20px; color:#FFFFFF;cursor:pointer;z-index:1000;" ></span>--> 
<div class="container" >    
<div class="modal-dialog modal-lg" style="width: 100%">  
<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<div class="blockico"><i class="fas fa-bars"></i> </div> <span class="color-white"><?php echo $a_menu['m_name'];?></span> 
</div>
 
<div class="modal-body">
<?php
genMenuView($m_id);
?>
</div>
</div>
</div>
</div>
	<!-- required -->
	<link rel="stylesheet" type="text/css" media="all" href="../js/stellarnav/css/stellarnav.css">
	<!-- required -->
	<!-- required -->
	<script type="text/javascript" src="../js/stellarnav/js/stellarnav.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{
			$('.stellarnav').stellarNav({
				theme: 'light'		
			});
		});
	</script>
	<!-- required -->

