<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");

if ($email_data == 'Y') {
	$just .= '#zz#Y';
} else if ($email_data == 'N') {
	$just .= '#zz#N';
} else {
	$just .= '#zz#';
}
if ($no_replate == 'QNR') {
	$just .= '#zz#QNR';
} else {
	$just .= '#zz#';
}
if ($Flag == "Q") {
	$ch = addslashes($ch);
	$name = addslashes($name);
	$SQL = $db->query("update p_question set q_name = '$ch',q_des = '$name',q_pos = '$pos' ,q_req = '$just' where q_id = '$qid'");
	$db->write_log("update", "servey", "แก้ไขคำถาม " . $ch . "." . $name);
?>
	<script language="javascript">
		window.opener.location.reload();
		window.close();
	</script>
	<?php
} elseif ($Flag == "P") {
	$t = 0;
	$SQL2 = $db->query("SELECT q_id FROM p_question WHERE p_question.c_id = '$path' ORDER BY q_pos ASC");
	while ($R = $db->db_fetch_row($SQL2)) {
		$X = $db->query("DELETE FROM p_ans WHERE q_id = '$R[0]'");
		for ($i = 0; $i < $all; $i++) {
			$an = "an" . $i;
			$an = $$an;
			$pos = "pos" . $i;
			$pos = $$pos;
			$del = "del" . $i;
			$del = $$del;
			$weight = "weight" . $i;
			$weight = $$weight;
			if ($del != "Y") {
				$X1 = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,a_weight) VALUES ('','$R[0]','$an','','$pos','$weight')");
				$t++;
			}
		}
	}

	$QQQ = $db->query("UPDATE `p_cate` SET `option2` = '$t' WHERE `c_id` = '$path' ");
	if ($Submit == "??") {
	?>
		<script language="javascript">
			window.close();
		</script>
	<?php
	} else {
	?>
		<script language="javascript">
			window.location.href = 'edit_ans1.php?post=<?php echo $post; ?>&path=<?php echo $path; ?>&type=<?php echo $type; ?>';
		</script>
	<?php
	}
} elseif ($Flag == "A") {
	$SQL0 = $db->query("UPDATE p_question SET q_anstype = '$sel' WHERE q_id = '$qid' ");
	$SQL = $db->query("DELETE FROM p_ans WHERE q_id = '$qid'");
	if ($sel == "D") {
		if ($de == "S") {
			$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$qid','$def','$de','$wor','$wid2')");
		} elseif ($de == "M") {
			$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$qid','$def','$de','$line','$wid1')");
		}
	?> <script language="javascript">
			window.close();
		</script>
	<?php
	} elseif ($sel == "E") {
		$db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$qid','$stype','$sdef','','')");
	?> <script language="javascript">
			window.close();
		</script>
		<?php
	} else {
		if ($FlagA == "A") {
			$all = $all + 1;
		}
		$Current_Dir = "../ewt/" . $_SESSION["EWT_SUSER"] . "/images/form_pic";
		if (!(file_exists($Current_Dir))) {
			mkdir($Current_Dir, 0777);
			@chmod($Current_Dir, 0777);
		}
		for ($i = 0; $i < $all; $i++) {
			$an = "an" . $i;
			$an = $$an;
			$ch = "ch" . $i;
			$ch = $$ch;
			$pos = "pos" . $i;
			$pos = $$pos;
			$del = "del" . $i;
			$del = $$del;
			$pic = "pic" . $i;
			$pic = $$pic;
			$dpic = "dpic" . $i;
			$dpic = $$dpic;
			$weight = "weight" . $i;
			$weight = $$weight;

			if ($_FILES["file" . $i]["size"] > 0) {
				copy($_FILES["file" . $i]["tmp_name"], $Current_Dir . "/" . $_FILES["file" . $i]["name"]);
				@chmod($Current_Dir . "/" . $_FILES["file" . $i]["name"], 0777);
				$an = $an . "#@form#img@#" . "images/form_pic/" . $_FILES["file" . $i]["name"];
			} else {
				$an = $an . "#@form#img@#" . $pic;
			}

			if ($dpic) {
				$an = '';
				@unlink("../ewt/" . $_SESSION["EWT_SUSER"] . "/" . $pic);
			}

			if ($del != "Y") {
				$z = $i + 1;
				if ($defa == $z) {
					$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4,a_weight) VALUES ('','$qid','$an','$ch','$pos','Y','$weight')");
				} else {
					$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,a_weight) VALUES ('','$qid','$an','$ch','$pos','$weight')");
				}
			}
			$db->write_log("update", "servey", "แก้ไขคำตอบ " . $an);
		}
		if ($SubmitY == "Finish") {
		?>
			<script language="javascript">
				window.close();
			</script>
		<?php
		} else {
		?>
			<script language="javascript">
				window.location.href = 'edit_ans.php?qname=<?php echo $qname; ?>&qid=<?php echo $qid; ?>';
			</script>
<?php
		}
	}
}
?>
<?php @$db->db_close(); ?>