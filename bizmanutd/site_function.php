<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
function phpxcopy($s, $d){
$l = "/"; // Plz Change to '/' when your OS is Unix.
if(!file_exists($d)){ 
	mkdir($d,0777);
	chmod($d,0777);
	}
if(is_dir($s)){
	$dp = opendir($s);
	while($file = readdir($dp)){
	if(!($file == "." || $file == ".." || $file == "Thumbs.db")){
		$SPath = $s.$l.$file;
		$DPath = $d.$l.$file;
		if(is_dir($SPath)){
			phpxcopy($SPath, $DPath);
		}else{
			if(!copy($SPath, $DPath)){
					echo "Error : Failed to copy the folder or files";
					exit();
			}else{
			chmod($DPath,0777);
			}
      }
	}
	}
	closedir($dp);
}
return true;
}

if($_POST["Flag"] == "NewSite"){

		$sql_chk = $db->query("SELECT UID FROM user_info WHERE EWT_User = '".$_POST["u_name"]."' ");

		if($db->db_num_rows($sql_chk) > 0){
			?>
			<script language="javascript">
			alert("User \"<?php echo $_POST["u_name"]; ?>\" already exist!!");	
			self.location.href = "site_new.php";
			</script>
			<?php
				exit;
		}

		$sql_chk = $db->query("SELECT gen_user_id FROM gen_user WHERE gen_user = '".$_POST["u_name"]."' ");

		if($db->db_num_rows($sql_chk) > 0){
			?>
			<script language="javascript">
			alert("User \"<?php echo $_POST["u_name"]; ?>\" already exist!!");	
			self.location.href = "site_new.php";
			</script>
			<?php
				exit;
		}

		$wname = stripslashes(htmlspecialchars($_POST["w_name"],ENT_QUOTES));

		$db->query("INSERT INTO user_info (WebsiteName,StartDate,EWT_User,EWT_Pass,db_db,EWT_Status) VALUES ('".$wname."','".date("Y-m-d")."','".$_POST["u_name"]."','".$_POST["u_pass"]."','','N')");
		$sql_id = $db->query("SELECT UID FROM user_info WHERE EWT_User = '".$_POST["u_name"]."' ");
		$R = $db->db_fetch_row($sql_id);
		$UID = $R[0];
		$db_new = "db_".$UID."_".$_POST["u_name"];
			$db->query("create database if not exists ".$db_new." CHARACTER SET 'utf8' ;");
			$db->query("USE ".$db_new);
			 /*
			 $file = fopen("db/db.sql", 'r');
            $query = fread($file, filesize("db/db.sql"));
            fclose($file);
			*/
			$query = "";
			$fd = fopen ("db/db.sql", "r");
			while (!feof ($fd)) {
				$query .= fgets($fd, 4096);
			}
			fclose ($fd);

			$q = explode(";",$query);
			for($i=0;$i<=count($q);$i++){
				if(trim($q[$i]) != ""){
				mysql_query(trim($q[$i]));
				}
			}
			mkdir ("../ewt/".$_POST["u_name"], 0777);
			phpxcopy("template","../ewt/".$_POST["u_name"]);

			$fp = @fopen("template/lib/user_config.php", "r");
				if(!$fp){ die("Cannot open source"); }
					while($html = @fgets($fp, 1024)){
					$line .= $html;
					}
				@fclose($fp);
				$line = eregi_replace ( "##db##" , $db_new , $line ) ;
				$line = eregi_replace ( "##user##" , $_POST["u_name"] , $line ) ;
				$fw = @fopen("../ewt/".$_POST["u_name"]."/lib/user_config.php", "w");
				if(!$fw){ die("Cannot write target"); }
				$FlagW = fwrite($fw, $line);
			@fclose($fw);
			$db->query("USE ".$EWT_DB_NAME);
			$db->query("UPDATE user_info SET db_db = '".$db_new."' , EWT_Status = 'Y' WHERE UID = '$UID'");
		?>
			<script language="javascript">
			var r = confirm("Register & Install your website complete.\nDo you want to go to Register page?");	
			if(r == true){
			self.location.href = "site_new.php";
			}else{
			self.location.href = "site_main.php";
			}
			</script>
			<?php
}

$db->db_close();
?>
