<?php
include("../EWT_ADMIN/comtop_pop.php");
$db->query("USE " . $EWT_DB_USER);

##============================================================================================================##
$fullname = trim($_POST["fullname"]);
##============================================================================================================##
$where_user   = " AND 1=1 ";

if ($fullname != "") {
    $name_explode = explode(" ", $fullname);
    $fname = $name_explode[0];
    $lname = $name_explode[1];

    if (empty($lname)) {
        if (!preg_match('/[^A-Za-z0-9_\\-]/', $fullname)) {
            $where_user .= " AND name_eng LIKE '%" . $fullname . "%' ";
            $where_user .= " OR surname_eng LIKE '%" . $fullname . "%' ";
        } else {
            $where_user .= " AND name_thai LIKE '%" . $fullname . "%' ";
            $where_user .= " OR surname_thai LIKE '%" . $fullname . "%' ";
        }
    } else {
        if (!preg_match('/[^A-Za-z0-9_\\-]/', $fullname)) {
            $where_user .= " AND name_eng LIKE '%" . trim($fname) . "%' ";
            $where_user .= " OR surname_eng LIKE '%" . trim($lname) . "%' ";
        } else {
            $where_user .= " AND name_thai LIKE '%" . trim($fname) . "%' ";
            $where_user .= " OR surname_thai LIKE '%" . trim($lname) . "%' ";
        }
    }
}
##============================================================================================================##
$_GET['ug'] = $_SESSION["EWT_SUID"];
$sql_gen_user  = "SELECT * FROM gen_user WHERE status ='1' $where_user";
$sql_gen_user .= " ORDER BY gen_user_id";
$s_sql  = $db->query($sql_gen_user);
$a_rows = $db->db_num_rows($s_sql);

if ($a_rows > 0) {
    $i = 0;
    while ($a_data = $db->db_fetch_array($s_sql)) {
        $sql_chk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '{$_SESSION['EWT_SUID']}' AND ugm_type = 'U' AND ugm_tid = '{$a_data['gen_user_id']}' ");
        $C = $db->db_fetch_row($sql_chk);

        $sql_org = "SELECT name_org FROM {$EWT_DB_USER}.org_name WHERE org_id = '{$a_data["org_id"]}'";
        $query_org  = $db->query($sql_org);
        $a_data_org = $db->db_fetch_array($query_org);

        if ($C[0] == 0) { ?>
            <tr>
                <td>
                    <div class="checkbox">&nbsp;&nbsp;
                        <label>
                            <input type="checkbox" class="chk" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" value="Y" <?php echo ($C[0] > 0) ? "checked" : null; ?>>
                            <span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;
                            <b>
                                <input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $a_data['gen_user_id']; ?>">
                                <img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle">
                                <?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>
                            </b>
                        </label>
                    </div>
                </td>
                <td>
                    <?php echo $a_data_org["name_org"]; ?>
                    <?php
                    if ($a_data["ldap_user"] == '1') {
                        echo "(กำหนดโดยกลุ่ม LDAP )";
                    }
                    ?>
                </td>
            </tr>
        <?php } else { ?>
            <tr bgcolor="#FFFFFF">
                <td>
                    <div class="checkbox">&nbsp;&nbsp;
                        <label>
                            <input type="checkbox" checked disabled>
                            <span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;
                            <b>
                                <img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle">
                                <?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>
                                <font color="#FF0000">(กำหนดสิทธิ์แล้ว)</font>
                            </b>
                        </label>
                    </div>
                </td>

                <td>
                    <?php echo $department; ?>
                    <?php
                    if ($a_data["ldap_user"] == '1') {
                        echo "(กำหนดโดยกลุ่ม LDAP )";
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
        <?php $i++; ?>
    <?php  } ?>
<?php } else { ?>
    <tr align="center" bgcolor="#FFFFFF">
        <td height="40" colspan="2">
            <font color="#FF0000">ไม่มีรายชื่อสมาชิก</font>
        </td>
    </tr>
<?php } ?>
<input name="alli" type="hidden" value="<?php echo $i; ?>">