<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "NewsDetail"){
//echo $_POST["nid"].addslashes(stripslashes($_REQUEST["dx1y0"]));

				$db->query("UPDATE article_list 
				SET
					d_id_w3c = '".$_POST["template_w3c"]."'  ,
					show_group = '".$_POST["chk_group"]."',
					show_topic = '".$_POST["chk_topic"]."',
					show_date = '".$_POST["chk_date"]."',
					show_newstop = '".$_POST["chk_newsshow"]."',
					show_vote = '".$_POST["chk_vote"]."',
					show_comment = '".$_POST["chk_comment"]."',
					comment_type='".$_POST["comment_type"]."',
					show_textsize='".$_POST[chk_textsize]."',
					show_count='".$_POST["chk_show_count"]."' 
					WHERE n_id = '".$_POST["nid"]."' ");

//multi search function
if($search_center == "Y"){    
	$db->ms_module='A'; 
	$db->ms_link_id=$_POST["nid"];
	$db->multi_search_update();
}

				$x=1;
				$y=0;
				$chsize = "Y";
				$ad_pic_h = $_POST["hx".$x."y".$y];
				$ad_pic_w = $_POST["wx".$x."y".$y];
				//$ad_des = eregi_replace(" ","&nbsp;",$_POST["dx".$x."y".$y]);
				$ad_des = addslashes(stripslashes($_REQUEST["dx".$x."y".$y]));
				///$ad_des = eregi_replace(" ","&nbsp;",$ad_des);
				$ad_font = $_POST["fx".$x."y".$y];
				$ad_size = $_POST["sx".$x."y".$y];
				$ad_bold = $_POST["bx".$x."y".$y];
				$ad_italic = $_POST["ix".$x."y".$y];
				$ad_color = $_POST["cx".$x."y".$y];
				$ad_align = $_POST["ax".$x."y".$y];
				$ad_pic_s = $_POST["spx".$x."y".$y];
				$ad_pic_b = $_POST["bpx".$x."y".$y];
				$remove = $_POST["rx".$x."y".$y];
				$ad_id = $_POST["adx".$x."y".$y];
				$create_t = $_POST["tx".$x."y".$y];
	
				$update = "UPDATE article_detail SET ad_pic_s = '$ad_pic_s', ";
				if($chsize != "N"){
$update .= "ad_pic_h = '$ad_pic_h', ad_pic_w = '$ad_pic_w', ";
				}
$update .= "ad_pic_b = '$ad_pic_b',
ad_des = '$ad_des',
ad_font = '$ad_font',
ad_size = '$ad_size',
ad_bold = '$ad_bold',
ad_italic = '$ad_italic',
ad_color = '$ad_color',
ad_align = '$ad_align' WHERE article_detail.ad_id ='$ad_id' ";

				$db->query($update);
				
				//write file
								$url2 = "../ewt/".$EWT_FOLDER_USER."/ewt_news_body.php?nid=".$_POST["nid"];
								$line = "";
								$fp = @fopen($url2 ,"r");
								if($fp){ 
									while($html = @fgets($fp, 1024)){
									$line .= $html;
									}
								}
								@fclose($fp);
								$line = eregi_replace("images/article/news","phpThumb.php?src=../".$EWT_FOLDER_USER."/images/article/news",$line);
								$fw = @fopen("../ewt/".$EWT_FOLDER_USER."/article/TEMP".$_POST["nid"].".html", "w");
								$FlagW = fwrite($fw, $line);
								@fclose($fw);
				//end
	if($_POST["n_action"] == "save"){
	       $db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '".$_POST["nid"]."' ");
			
			//multi search function
			if($search_center == "Y"){   
				$db->ms_module='A'; 
				$db->ms_link_id=$_POST["nid"];
				$db->multi_search_update();
			}
			?>
			<script language="javascript">
				self.location.href = "../ewt/<?php echo $EWT_FOLDER_USER; ?>/article_freestype.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
	}
	if($_POST["n_action"] == "preview"){
			?>
			<script language="javascript">
				window.open("../ewt/<?php echo $EWT_FOLDER_USER; ?>/ewt_news.php?nid=<?php echo $_POST["nid"]; ?>","artpv","width=800,height=550,resizable=1,scrollbars=1");
				self.location.href = "../ewt/<?php echo $EWT_FOLDER_USER; ?>/article_freestype.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
	}
	if($_POST["n_action"] == "cancel"){
        $db->query("Delete FROM article_list  WHERE  n_id = '".$_POST["nid"]."'");
			?>
			<script language="javascript"> 
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
	}
	if($_POST["n_action"] == "exit"){
	$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '".$_POST["cid"]."' ");

	//multi search function
if($search_center == "Y"){   
	$db->ms_module='A'; 
	$db->ms_link_id=$_POST["cid"];
	$db->multi_search_update();
}
			?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
	}

}

$db->db_close(); ?>
