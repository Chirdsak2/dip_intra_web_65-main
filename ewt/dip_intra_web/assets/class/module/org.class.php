<?php
class org
{
    public static function getUser($s_uid)
    {
        db::setDB(E_DB_USER);
        $wh = "";
        if ($s_uid) {
            $wh .= " AND gen_user_id = '{$s_uid}'";
        }
        $_sql = "SELECT * FROM gen_user WHERE 1=1 {$wh}  ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getUserImg($s_uid)
    {
        db::setDB(E_DB_USER);
        $wh = "";
        if ($s_uid) {
            $wh .= " AND gen_user_id = '{$s_uid}'";
        }
        $_sql = "SELECT * FROM gen_user WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_row) {
            foreach ((array) $a_data as $_item) {
                $path_image = $_item['path_image'];
                $uploaddirDoc = E_DOC_ROOT . "ewt/pic_upload/";
                $uploaddir = E_IP_ROOT . "ewt/pic_upload/";
                if ($path_image != '') {
                    $path_image1 = $uploaddirDoc . $path_image;

                    if (file_exists($path_image1)) {
                        $a_image = $uploaddir . $path_image;
                    } else {
                        $a_image = E_IP_ROOT . 'EWT_ADMIN/images/user001.png';
                    }
                } else {
                    $a_image = E_IP_ROOT . 'EWT_ADMIN/images/user001.png';
                }
            }
        }
        return $a_image;
    }

    public static function getCalendarInvite($s_cid)
    {
        $wh = "";
        if ($s_cid) {
            $wh .= " AND event_id = '{$s_cid}'";
        }
        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM cal_invite WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getPollAswer($s_cid)
    {
        $wh = "";
        $s_limit = "";
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}'";
        }

        $perpage = $s_limit;

        if (isset($s_page)) {
            $page = $s_page;
        } else {
            $page = 1;
        }

        $start = ($page - 1) * $perpage;

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM poll_ans WHERE  1=1  {$wh}  ORDER BY a_position ASC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลกรุ๊ป
    public static function getArticleOrg($c_id)
    {
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = '$c_id' ";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM article_group WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data && $c_id != 0) {
            return $a_data;
        }
    }

    //เรียกข้อมูลกรุ๊ปย่อย
    public static function getArticleOrgSub($c_id)
    {
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = '$c_id' ";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM article_list WHERE n_approve = 'Y' {$wh}
        ORDER BY n_date DESC LIMIT 0,3";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data && $c_id != 0) {
            return $a_data;
        }
    }

    //เรียกข้อมูลซับย่อย
    public static function getSubArticleOrg($c_parent)
    {
        $wh = "";

        if ($c_parent) {
            $wh .= " AND c_parent = '$c_parent'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM article_group WHERE 1=1 {$wh}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data && $c_parent != 0) {
            return $a_data;
        }
    }

    //เรียกข่อมูลข่าวย่อย
    public static function getSubArticleList($start, $per_page, $s_cid)
    {
        $wh = "";

        if ($s_cid) {
            $sub_query = article::getArticleSub($s_cid);
            $wh .= " AND c_id IN ($sub_query) ";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM article_list WHERE n_approve = 'Y' {$wh}
		ORDER BY n_timestamp DESC, n_date DESC
		LIMIT {$start},{$per_page}";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูล Organization ทั้งหมด
    public static function getOrgContact($start, $perpage, $s_name = null, $org_id = null, $gen_user_id = null)
    {
        $wh = "";
        if ($gen_user_id) {
            $wh .= " AND gen_user.gen_user_id = '$gen_user_id' ";
        }

        if ($s_name) {
            $name_explode = explode(" ", $s_name);
            $name_thai = $name_explode[0];
            $surname_thai = $name_explode[1];

            if (empty($surname_thai)) {
                $wh .= " AND gen_user.name_thai LIKE '%" . trim($s_name) . "%' ";
                $wh .= " OR gen_user.surname_thai LIKE '%" . trim($s_name) . "%' ";
            } else {
                $wh .= " AND gen_user.name_thai LIKE '%" . trim($name_thai) . "%' ";
                $wh .= " OR gen_user.surname_thai LIKE '%" . trim($surname_thai) . "%' ";
            }
        }

        if ($org_id) {
            $wh .= " AND org_name.org_id = " . trim($org_id) . " ";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT * FROM gen_user
		LEFT JOIN position_name ON (gen_user.posittion = position_name.pos_id)
		LEFT JOIN org_name ON (gen_user.org_id = org_name.org_id)
		LEFT JOIN title ON (gen_user.title_thai = title.title_id)
		WHERE gen_user.status = 1 {$wh} ORDER BY position_name.pos_id IS NULL,
		position_name.pos_id ASC LIMIT {$start},{$perpage}";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        $_sql_all = "SELECT gen_user.org_id FROM gen_user
		LEFT JOIN position_name ON (gen_user.posittion = position_name.pos_id)
		LEFT JOIN org_name ON (gen_user.org_id = org_name.org_id)
		LEFT JOIN title ON (gen_user.title_thai = title.title_id)
		WHERE gen_user.status = 1 {$wh}";
        $a_row_all = db::getRowCount($_sql_all);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all 
            );
        }
    }

    //เรียกข้อมูลชื่อ Organization
    public static function getUserOrgContact($gen_user_id = null, $s_name = null)
    {
        $wh = "";
        if ($gen_user_id) {
            $wh .= " AND gen_user.gen_user_id = '$gen_user_id' ";
        }

        if ($s_name) {
            $wh .= " AND title.name_thai LIKE '%" . trim($s_name) . "%' OR surname_thai LIKE '%" . trim($s_name) . "%' ";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT * FROM gen_user
		LEFT JOIN position_name ON (gen_user.posittion = position_name.pos_id)
		LEFT JOIN title ON (gen_user.title_thai = title.title_id)
		WHERE gen_user.status = 1 {$wh} ORDER BY position_name.pos_id IS NULL,
		position_name.pos_id ASC";

        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลหน่วยงาน Organization
    public static function getOrg($n_org = null)
    {
        $wh = "";
        if ($n_org) {
            //$wh .= " AND gen_user.gen_user_id = $n_owner";
            $wh .= " AND org_id = '$n_org'";
        }

        db::setDB(E_DB_USER);
        // $_sql = "SELECT org_name.short_name, org_name.name_org FROM gen_user 
        // LEFT JOIN org_name ON (gen_user.org_id = org_name.org_id) 
        // WHERE 1=1 {$wh}";
        $_sql = "SELECT short_name, name_org FROM org_name WHERE 1=1 {$wh}";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return array(
                "name" => !empty($a_data["short_name"]) ? $a_data["short_name"] : $a_data["name_org"],
                "name_org" => $a_data["name_org"],
                "short_name" => $a_data["short_name"]
            );
        }
    }

    //เรียกข้อมูลหน่วยงาน
    public static function getOrgNameContact($org_id = null)
    {
        $wh = "";

        if ($org_id) {
            $wh .= " AND org_id = {$org_id} ";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT * FROM org_name WHERE 1=1 {$wh} ORDER BY org_id ASC";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลคำนำหน้า
    public static function getTitle($title_id = null)
    {
        $wh = "";

        if ($title_id) {
            $wh .= " AND title_id = {$title_id} ";
        }

        db::setDB(E_DB_USER);
        $_sql = "SELECT * FROM title WHERE 1=1 {$wh} ORDER BY title_order ASC";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    public static function getMenuOrg($s_mid)
    {
        $txt = '';
        db::setDB(E_DB_NAME);
        $_sql = "SELECT * FROM menu_properties WHERE m_id = '{$s_mid}' AND mp_sub = '0' AND mp_show = 'Y' ORDER BY mp_pos ASC ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            foreach ($a_data as $key => $value) {
                $txt .= '<a href="' . menu::genLink($value['Glink']) . '" 
                title="' . $value['mp_name'] . '" target="' . $value['Gtarget'] . '" 
                style="text-align: ' . $value['Oufont'] . '; 
                font-weight: ' . $value['Oubold'] . '; 
                font-style: ' . $value['Ouitalic'] . '; 
                text-decoration: ' . $value['Oubordercolor'] . ';">';
                // if(!empty($value['Oubgpic'])){
                //     $txt .= '<i class="'.$value['Oubgpic'].'" aria-hidden="true"></i>';
                // }
                $txt .= $value['mp_name'];
                $txt .= '</a>';
            }
            
        }

        return $txt;
    }

    public static function getAricleBanner($c_id, $banner_id = null)
    {
        $wh = "";

        if($c_id){
            $wh .= " AND article_group.c_id = {$c_id} AND article_group.c_parent = 5";
        }

        if($banner_id){
            $wh .= " AND banner.banner_id = {$banner_id}";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT article_group.c_show_org_banner, banner.banner_pic FROM article_group 
        INNER JOIN banner on (article_group.c_show_org_banner = banner.banner_id)
        WHERE 1=1 {$wh}";
        $a_row	= db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if($a_data){
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getAricleImage($c_id, $banner_id = null)
    {
        $wh = "";

        if($c_id){
            $wh .= " AND article_group.c_id = {$c_id} AND article_group.c_parent = 5";
        }

        if($banner_id){
            $wh .= " AND banner.banner_id = {$banner_id}";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT article_group.c_show_org_image, banner.banner_pic FROM article_group 
        INNER JOIN banner on (article_group.c_show_org_image = banner.banner_id)
        WHERE 1=1 {$wh}";
        $a_row	= db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if($a_data){
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }
}
