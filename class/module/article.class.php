<?php
class article
{
    public static function getImgbase64($s_fullname)
    {
        // Get the image and convert into string 
        $img = file_get_contents($s_fullname);
        if ($img) {
            $Extension = getExtension($s_fullname);
            // Encode the image string data into base64 
            $imgbase64 = base64_encode($img);
            return 'data:image/' . $Extension . ';base64,' . $imgbase64;
        } else {
            return $s_fullname;
        }
    }

    public static function getAricleCheckOrg($c_id)
    {
        global $db;
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = {$c_id}";
        }

        $_sql = $db->query("SELECT * FROM article_group WHERE 1=1 {$wh}");

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getAricleGroup($c_id)
    {
        global $db;

        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = {$c_id}";
        }

        $_sql = $db->query("SELECT * FROM article_group WHERE 1=1 {$wh}");

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getAricleSubGroup($c_id)
    {
        global $db;

        $wh = "";

        if ($c_id) {
            $wh .= " AND c_parent = {$c_id}";
        }

        $_sql = $db->query("SELECT * FROM article_group WHERE 1=1 {$wh}");
        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getAricleList($n_id)
    {
        global $db;

        $wh = "";

        if ($n_id) {
            $wh .= " AND n_id = {$n_id}";
        }

        $_sql = $db->query("SELECT * FROM article_list WHERE 1=1 {$wh}");
        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getAricleListView($c_id = null, $limit = null)
    {
        global $db;

        $wh = "";
        $lm = "";

        if ($c_id) {
            $wh .= " AND c_id = {$c_id}";
        }

        if ($limit) {
            $lm .= " LIMIT 0,{$limit}";
        }

        $_sql = $db->query("SELECT n_id,n_topic,n_date,n_new_modi,
        n_last_modi,n_owner,news_use,n_share,n_shareuse,n_sharename,
        n_approve,c_id,link_html,pinned,view_count FROM article_list 
        WHERE n_approve <> 'D' AND n_id != '' {$wh} 
        ORDER BY view_count DESC {$lm}");

        while ($row = $db->db_fetch_array($_sql)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getArticleListDetail($nid, $temp)
    {
        global $db;
        $txt_detail = "";
        $txt_image = "";

        $_sql = $db->query("SELECT * FROM article_detail WHERE n_id = '{$nid}' ORDER BY at_type_row ASC ");
        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_detail[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_row) {
            $txt_detail .= '<div class="pb-4 font-content">' . self::getArticleDetail($nid, $temp, '', '11', '1') . '</div>';
            $i = '1';

            $txt_image .= '<div class="container">';
            $txt_image .= '<div class="gal">';
            foreach ($a_detail as $key => $_itemDetail) {
                if ($_itemDetail['ad_pic_b'] != "" or $_itemDetail['ad_des'] != "" and $_itemDetail['at_type_row'] != "11") {
                    if ($_itemDetail['ad_pic_b'] != "") {
                        $ad_pic_b = "../ewt/prd_intra_web/images/article/news" . $nid . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                        $ad_pic_b = "../ewt/prd_intra_web/images/news/1-1.jpg";
                    }

                    if ($_itemDetail['ad_pic_s'] != "") {
                        $ad_pic_s = "../ewt/prd_intra_web/images/article/news" . $nid . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                        $ad_pic_s = "../ewt/prd_intra_web/images/news/1-1.jpg";
                    }

                    $txt_image .= '<figure>';
                    $txt_image .= '<img src="' . self::getImgbase64($ad_pic_s) . '" alt="' . $_itemDetail['ad_pic_b'] . '" id="article_image' . $key . '" onclick="getModalImageNew(' . $key . ')" style="cursor: pointer;" />';
                    $txt_image .= '<figcaption><small id="article_text' . $key . '">' . $_itemDetail['ad_des'] . '</small></figcaption>';
                    $txt_image .= '</figure>';
                }
                $i++;
            }

            $txt_image .= '</div>';
            $txt_image .= '</div>';

            return array(
                "txt_detail" => $txt_detail,
                "txt_image" => $txt_image
            );
        }
    }

    public static function getArticleDetail($nid, $temp, $adid, $x, $y)
    {
        global $db;

        if ($x) {
            $wh = "AND at_type_row = '{$x}' AND at_type_col = '{$y}'";
        } else {
            $wh = "AND ad_id = '{$adid}'";
        }

        $txt = "";

        $_sql = $db->query("SELECT * FROM article_detail WHERE n_id = '{$nid}' {$wh}  ");
        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_detail[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if ($a_row) {
            foreach ($a_detail as $_itemDetail) {
                if ($_itemDetail['ad_des'] != '') {
                    $txt .= $_itemDetail["ad_des"];
                }
            }
        }
        return $txt;
    }

    public static function getAricleBanner($c_id, $banner_id = null)
    {
        global $db;

        $wh = "";

        if ($c_id) {
            $wh .= " AND article_group.c_id = {$c_id} AND article_group.c_parent = 5";
        }

        if ($banner_id) {
            $wh .= " AND banner.banner_id = {$banner_id}";
        }

        $select = "SELECT article_group.c_show_org_banner, banner.banner_pic FROM article_group 
        INNER JOIN banner on (article_group.c_show_org_banner = banner.banner_id)
        WHERE 1=1 {$wh} LIMIT 1";

        $_sql = $db->query($select);
        $a_data = $db->db_fetch_array($_sql, MYSQLI_ASSOC);
        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function getAricleImage($c_id, $banner_id = null)
    {
        global $db;

        $wh = "";

        if ($c_id) {
            $wh .= " AND article_group.c_id = {$c_id} AND article_group.c_parent = 5";
        }

        if ($banner_id) {
            $wh .= " AND banner.banner_id = {$banner_id}";
        }

        $select = "SELECT article_group.c_show_org_image, banner.banner_pic FROM article_group 
        INNER JOIN banner on (article_group.c_show_org_image = banner.banner_id)
        WHERE 1=1 {$wh} LIMIT 1";

        $_sql = $db->query($select);
        $a_data = $db->db_fetch_array($_sql, MYSQLI_ASSOC);
        $a_row = $db->db_num_rows($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }
}
