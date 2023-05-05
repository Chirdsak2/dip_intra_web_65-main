<?php
class menu
{
    public static function getMenuList()
    {
        global $db;

        $_sql = $db->query("SELECT m_id,m_name FROM menu_list WHERE m_show = 'Y' OR m_show = 'N' ORDER BY m_id DESC");

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

    public static function getMenu($s_mid = null, $s_msub = null)
    {
        global $db;

        $wh = "";
        if ($s_mid) {
            $wh .= "AND m_id = '{$s_mid}' ";
        }
        
        if ($s_msub) {
            $wh .= "AND mp_sub = '{$s_msub}' ";
        }

        $_sql = $db->query("SELECT * FROM menu_properties WHERE 1=1 {$wh} ORDER BY mp_pos ASC");

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

    public static function genLink($link_html)
    {
        global $db;
        if (strstr($link_html, 'cid')) {
            $link = $link_html;
        } else if (strstr($link_html, 'http') || strstr($link_html, 'https') || strstr($link_html, 'wwww')) {
            $link = $link_html;
        } else if (strstr($link_html, 'nid')) {
            $sub_link = explode("=", $link_html);

            $_sql = $db->query("SELECT * FROM article_list WHERE n_id = '{$sub_link[1]}' ");
            while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
                $a_data[] = $row;
            }

            if ($a_data[0]["link_html"] == "") {
                $link = "news_view.php?nid=" . $sub_link[1];
            } else {
                //$link = glink($a_data["link_html"]);
            }
        } else if (strstr($link_html, 'news_view.php') || strstr($link_html, 'news_view.php')) {
            //$sub_link = explode("=",$link_html);

            $_sql = $db->query("SELECT * FROM article_list WHERE link_html = '{$link_html}' ");
            while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
                $a_data[] = $row;
            }

            $link = "news_view.php?nid=" . $a_data[0]["n_id"];
        } else {
            if ($link_html != "" && $link_html != "#") {
                $link = $link_html;
            } else {
                $link = "";
            }
        }
        return $link;
    }

    public static function chkMenuSub($s_mid, $s_pid)
    {
        global $db;
        $wh = "";

        if($s_mid){
            $wh .= " AND m_id = '{$s_mid}'";
        }

        if($s_pid){
            $wh .= " AND mp_sub = '{$s_pid}'";
        }

        $_sql = $db->query("SELECT * FROM menu_properties WHERE 1=1 {$wh}");

        while ($row = $db->db_fetch_array($_sql, MYSQLI_ASSOC)) {
            $a_data[] = $row;
        }

        $a_row = $db->db_num_rows($_sql);

        if($a_data){
            return array(
                "data" => $a_data,
                "count" => $a_row,
            );
        }
    }

    public static function genMenuLen($s_data, $s_op)
    {
        $s = explode($s_op, $s_data);
        return count($s);
    }
}
