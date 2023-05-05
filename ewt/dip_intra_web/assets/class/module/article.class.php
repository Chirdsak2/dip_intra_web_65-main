<?php
class article
{
    public static function getArticleMoreLimit($s_cid, $s_page, $s_limit)
    {
        $wh = "";
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

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh} ORDER BY n_top DESC, n_date DESC, n_timestamp DESC ,n_id DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getArticleCate($s_cid)
    {
        $wh = '';
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}' ";
        }
        //$date_now =  date('Y-m-d');
        //$wh    = "AND ((banner_show_start = '' AND banner_show_end = '')";
        //$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getArticle($s_nid)
    {
        $wh = '';

        $date_now =  date('Y-m-d H:i');

        if ($s_nid) {
            $wh .= " AND n_id = '{$s_nid}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' 
        AND ((n_date_start = '' AND n_date_end = '')
        OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end)) {$wh}";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    public static function getHashtag($s_tid, $s_limit)
    {
        $wh = "";
        if ($s_tid) {
            $wh .= "AND tag_id = '{$s_tid}'";
        }
        $perpage = $s_limit;
        if (isset($s_page)) {
            $page = $s_page;
        } else {
            $page = 1;
        }
        $start = ($page - 1) * $perpage;
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_tagcount WHERE  1=1 {$wh}  ORDER BY tag_count DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    public static function getArticleTag($s_nid)
    {
        $wh = "";
        if ($s_nid) {
            $wh .= "AND n_id = '{$s_nid}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_taglist WHERE  1=1 {$wh}  ORDER BY taglist_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getArticleComment($s_nid)
    {
        $wh = "";
        if ($s_nid) {
            $wh .= " AND news_id = '{$s_nid}' ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".news_comment WHERE 1=1 {$wh} ORDER BY id_comment DESC";
        $a_data = db::getFetchAll($_sql);
        $a_row = db::getRowCount($_sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    public static function getArticleMedia($nid, $temp)
    {
        $txt = "";
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_detail WHERE n_id = '{$nid}' ORDER BY at_type_row ASC ";
        $a_detail = db::getFetchAll($_sql);
        $a_row = db::getRowCount($_sql);

        if ($a_row) {
            $txt .= '<div class="pb-4 font-content">' . self::getArticleDetail($nid, $temp, '', '11', '1') . '</div>' . PHP_EOL;
            $txt .= '<div class="row pb-2">' . PHP_EOL;
            $i = '1';

            foreach ($a_detail as $_itemDetail) {

                if ($_itemDetail['ad_pic_b'] != "" or $_itemDetail['ad_des'] != "" and $_itemDetail['at_type_row'] != "11") {
                    if ($_itemDetail['ad_pic_b'] != "") {
                        $ad_pic_b = HTTP_HOST . "images/article/news" . $nid . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                        $ad_pic_b = HTTP_HOST . "images/news/1-1.jpg";
                    }

                    if ($_itemDetail['ad_pic_s'] != "") {
                        $ad_pic_s = HTTP_HOST . "images/article/news" . $nid . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                        $ad_pic_s = HTTP_HOST . "images/news/1-1.jpg";
                    }
                    //$txt .='<div class="col-lg-4 col-md-4 col-xs-6 thumb pb-3">'.PHP_EOL;
                    $txt .= '<div class="s-content__media col-full">' . PHP_EOL;
                    $txt .= '<div class="s-content__post-thumb text-center">' . PHP_EOL;
                    //$txt .='<a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="" data-image="'.$ad_pic_b.'" data-target="#image-gallery">'.PHP_EOL;
                    $txt .= '<img src="' . getImgbase64($ad_pic_s) . '" alt="Another alt text">' . PHP_EOL;
                    //$txt .='<div class="detial-pic">';
                    //$txt .=article_detail($nid,$temp,$a_detail['ad_id'],$a_detail['at_type_row'],$a_detail['at_type_col']);
                    //$txt .='</div>';
                    //$txt .='</a>';
                    $txt .= '</div>' . PHP_EOL;
                    $txt .= '</div>' . PHP_EOL;
                    //$txt .='</div>'.PHP_EOL;
                    $txt .= self::getArticleDetail($nid, $temp, $_itemDetail['ad_id'], $_itemDetail['at_type_row'], $_itemDetail['at_type_col']);
                }
                $i++;
            }
            $txt .= "</div>" . PHP_EOL;
            return $txt;
        }
    }

    public static function getArticleListDetail($nid, $temp)
    {
        $txt_detail = "";
        $txt_image = "";
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_detail WHERE n_id = '{$nid}' ORDER BY at_type_row ASC ";
        $a_detail = db::getFetchAll($_sql);
        $a_row = db::getRowCount($_sql);

        if ($a_row) {
            $txt_detail .= '<div class="pb-4 font-content">' . self::getArticleDetail($nid, $temp, '', '11', '1') . '</div>';
            $i = '1';

            $txt_image .= '<div class="container">';
            $txt_image .= '<div class="gal">';
            foreach ($a_detail as $key => $_itemDetail) {
                if ($_itemDetail['ad_pic_b'] != "" or $_itemDetail['ad_des'] != "" and $_itemDetail['at_type_row'] != "11") {
                    if ($_itemDetail['ad_pic_b'] != "") {
                        $ad_pic_b = HTTP_HOST . "images/article/news" . $nid . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                        $ad_pic_b = HTTP_HOST . "images/news/1-1.jpg";
                    }

                    if ($_itemDetail['ad_pic_s'] != "") {
                        $ad_pic_s = HTTP_HOST . "images/article/news" . $nid . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                        $ad_pic_s = HTTP_HOST . "images/news/1-1.jpg";
                    }

                    $txt_image .= '<figure>';
                    $txt_image .= '<img src="' . $ad_pic_s . '" alt="' . $_itemDetail['ad_pic_b'] . '" onclick="openModal();currentSlide' . $nid . '" class="hover-shadow cursor" />';
                    $txt_image .= '<figcaption><small id="article_text' . $key . '">' . $_itemDetail['ad_des'] . '</small></figcaption>';
                    $txt_image .= '</figure>';
                }
                $i++;
            }

            $txt_image .= '</div>';
            $txt_image .= '</div>';

            return array(
                "data" => $a_detail,
                "txt_detail" => $txt_detail,
                "txt_image" => $txt_image
            );
        }
    }

    public static function getNewArticleListDetail($nid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_detail WHERE n_id = '{$nid}' ORDER BY at_type_row ASC ";
        $a_data = db::getFetchAll($_sql);
        $a_row = db::getRowCount($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    public static function getArticleDetail($nid, $temp, $adid, $x, $y)
    {
        if ($x) {
            $wh = "AND at_type_row = '{$x}' AND at_type_col = '{$y}'";
        } else {
            $wh = "AND ad_id = '{$adid}'";
        }

        $txt = "";

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_detail WHERE n_id = '{$nid}' {$wh}  ";
        $a_detail = db::getFetchAll($_sql);
        $a_row = db::getRowCount($_sql);

        if ($a_row) {
            foreach ($a_detail as $_itemDetail) {
                if ($_itemDetail['ad_des'] != '') {
                    //$txt .= nl2br(stripslashes($a_detail["ad_des"]));
                    $txt .= preg_replace('#' . preg_quote('ewt_admin/ewt/prd_intra_web/') . '#i', '', $_itemDetail["ad_des"]);
                    //$txt .= $_itemDetail["ad_des"];
                }
            }
        }
        return $txt;
    }

    public static function getArticleTagMoreLimit($s_tag, $s_page, $s_limit)
    {
        $wh = "";

        if ($s_tag) {
            $wh .= "AND article_taglist.tag_name LIKE '%" . trim($s_tag) . "%' ";
        }
        $perpage = $s_limit;
        if (isset($s_page)) {
            $page = $s_page;
        } else {
            $page = 1;
        }
        $start = ($page - 1) * $perpage;

        $_sql = "SELECT * FROM  " . E_DB_NAME . ".article_list 
        INNER JOIN " . E_DB_NAME . ".article_taglist ON article_list.n_id = article_taglist.n_id 
        WHERE article_list.n_approve = 'Y' {$wh} ORDER BY article_list.n_id DESC 
        LIMIT {$start},{$perpage}  ";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getArticleKM($s_cid)
    {
        $s_limit = 3;
        $s_page = 1;
        $txt = "";
        $wh = "";
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

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh} ORDER BY n_top DESC, n_date DESC, n_timestamp DESC ,n_id DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        $txt .= '<div class="pageheader-content row">' . PHP_EOL;
        $txt .= '<div class="col-full">' . PHP_EOL;
        $txt .= '<div class="featured">' . PHP_EOL;
        $count = 0;
        $end = 1;
        foreach ($a_data as $_itemDetail) {
            $count++;
            if (is_file('images/article/news' . $_itemDetail['n_id'] . '/' . $_itemDetail['picture'] . '') && $_itemDetail['picture']) {
                $img = 'images/article/news' . $_itemDetail['n_id'] . '/' . $_itemDetail['picture'];
            }
            $txt .= '<div class="featured__column featured__column--big">' . PHP_EOL;
            $txt .= '<div class="entry" style="background-image:url(' . getImgbase64($img) . ');">' . PHP_EOL;
            $txt .= '<div class="entry__content">' . PHP_EOL;
            $a_Cate = article::getArticleCate($_itemDetail['c_id']);
            if ($a_Cate) {
                foreach ($a_Cate as $_itemCate) {
                    $txt .= '<span class="entry__category"><a href="more_news.php?cid=' . $_itemCate['c_id'] . '">' . $_itemCate['c_name'] . '</a></span>' . PHP_EOL;
                }
            }

            $txt .= '<h1><a href="news_view.php?nid=' . $_itemDetail['n_id'] . '" title="">' . $_itemDetail['n_topic'] . '</a></h1>' . PHP_EOL;
            $txt .= '<div class="entry__info">' . PHP_EOL;

            if ($_itemDetail['n_owner'] != '0') {
                $a_User = org::getUser($_itemDetail['n_owner']);
                foreach ($a_User as $_itemUser) {

                    $txt .= '<a href="#0" class="entry__profile-pic">' . PHP_EOL;
                    $txt .= '<img class="avatar" src="' . getImgbase64(org::getUserImg($_itemDetail['n_owner'])) . '" alt="">' . PHP_EOL;
                    $txt .= '</a>' . PHP_EOL;
                    $txt .= '<ul class="entry__meta">' . PHP_EOL;
                    $txt .= '<li><a href="#0">' . $_itemUser['name_thai'] . ' ' . $_itemUser['surname_thai'] . '</a></li>' . PHP_EOL;
                }
            } else {

                $txt .= '<a href="#0" class="entry__profile-pic">' . PHP_EOL;
                $txt .= '<img class="avatar" src="' . getImgbase64('assets/img/avatars/user-03.jpg') . '" alt="">' . PHP_EOL;
                $txt .= '</a>' . PHP_EOL;
                $txt .= '<ul class="entry__meta">' . PHP_EOL;
                $txt .= '<li><a href="#0">Admin</a></li>' . PHP_EOL;
            }

            $txt .= '<li>' . convDateShowEN($_itemDetail['n_date'], 'F d, Y') . '</li>' . PHP_EOL;
            $txt .= '</ul>' . PHP_EOL;
            $txt .= '</div>' . PHP_EOL;
            $txt .= '</div> <!-- end entry__content -->' . PHP_EOL;
            $txt .= '</div> <!-- end entry -->' . PHP_EOL;
            $txt .= '</div> <!-- end featured__big -->' . PHP_EOL;
            if ($count == $end) {
                break;
            }
        }

        $txt .= '<div class="featured__column featured__column--small">' . PHP_EOL;
        $count2 = 0;
        $end2 = 3;
        foreach ($a_data as $_itemDetail2) {
            if ($count2 != 0) {

                if (is_file('images/article/news' . $_itemDetail2['n_id'] . '/' . $_itemDetail2['picture'] . '') && $_itemDetail2['picture']) {
                    $img = 'images/article/news' . $_itemDetail2['n_id'] . '/' . $_itemDetail2['picture'];
                }

                $txt .= '<div class="entry" style="background-image:url(' . getImgbase64($img) . ');" >' . PHP_EOL;
                $txt .= '<div class="entry__content">' . PHP_EOL;

                $a_Cate = article::getArticleCate($_itemDetail2['c_id']);
                if ($a_Cate) {
                    foreach ($a_Cate as $_itemCate) {
                        $txt .= '<span class="entry__category"><a href="more_news.php?cid=' . $_itemCate['c_id'] . '">' . $_itemCate['c_name'] . '</a></span>' . PHP_EOL;
                    }
                }

                $txt .= '<h1><a href="news_view.php?nid=' . $_itemDetail2['n_id'] . '" title="">' . $_itemDetail2['n_topic'] . '</a></h1>' . PHP_EOL;
                $txt .= '<div class="entry__info">' . PHP_EOL;

                if ($_itemDetail2['n_owner'] != '0') {
                    $a_User2 = org::getUser($_itemDetail2['n_owner']);
                    foreach ($a_User2 as $_itemUser2) {
                        $txt .= '<a href="#0" class="entry__profile-pic">' . PHP_EOL;
                        $txt .= '<img class="avatar" src="' . getImgbase64(org::getUserImg($_itemDetail2['n_owner'])) . '" alt="">' . PHP_EOL;
                        $txt .= '</a>' . PHP_EOL;
                        $txt .= '<ul class="entry__meta">' . PHP_EOL;
                        $txt .= '<li><a href="#0">' . $_itemUser2['name_thai'] . ' ' . $_itemUser2['surname_thai'] . '</a></li>' . PHP_EOL;
                    }
                } else {
                    $txt .= '<a href="#0" class="entry__profile-pic">' . PHP_EOL;
                    $txt .= '<img class="avatar" src="' . getImgbase64('assets/img/avatars/user-03.jpg') . '" alt="">' . PHP_EOL;
                    $txt .= '</a>' . PHP_EOL;
                    $txt .= '<ul class="entry__meta">' . PHP_EOL;
                    $txt .= '<li><a href="#0">Admin</a></li>' . PHP_EOL;
                }
                $txt .= '<li>' . convDateShowEN($_itemDetail2['n_date'], 'F d, Y') . '</li>' . PHP_EOL;
                $txt .= '</ul>' . PHP_EOL;
                $txt .= '</div>' . PHP_EOL;
                $txt .= '</div> <!-- end entry__content -->' . PHP_EOL;
                $txt .= '</div> <!-- end entry -->' . PHP_EOL;
            }
            if ($count2 == $end2) {
                break;
            }

            $count2++;
        }

        $txt .= '</div> <!-- end featured__small -->' . PHP_EOL;

        $txt .= '</div> <!-- end featured -->' . PHP_EOL;
        $txt .= '</div> <!-- end col-full -->' . PHP_EOL;
        $txt .= '</div> <!-- end pageheader-content row -->' . PHP_EOL;

        return $txt;
    }

    public static function genArticle($s_nid)
    {
        $wh = '';
        //$date_now =  date('Y-m-d');
        //$wh    = "AND ((banner_show_start = '' AND banner_show_end = '')";
        //$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_id = '{$s_nid}' AND n_approve = 'Y' {$wh} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleDetail($s_nid)
    {

        //$date_now =  date('Y-m-d');
        //$wh    = "AND ((banner_show_start = '' AND banner_show_end = '')";
        //$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
        $_sql = "SELECT * FROM article_detail WHERE n_id = '{$s_nid}' ORDER BY at_type_row ASC  ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleCate($s_cid)
    {
        $wh = '';
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}' ";
        }
        //$date_now =  date('Y-m-d');
        //$wh    = "AND ((banner_show_start = '' AND banner_show_end = '')";
        //$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleAttach($s_nid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_attach WHERE n_id = '{$s_nid}' ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    public static function genArticleMore($s_cid, $s_search = null)
    {
        $wh = "";

        if ($s_cid) {
            $wh .= " AND c_id = '$s_cid'";
        }

        if ($s_search) {
            $wh .= " AND n_topic LIKE '%" . trim($s_search) . "%' ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh} ORDER BY n_date DESC, n_timestamp DESC, n_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleMoreLimit($s_cid, $s_page, $s_limit)
    {
        $wh = "";
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

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh} ORDER BY n_date DESC, n_timestamp DESC ,n_id DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleSearch($s_search, $s_date, $s_cid)
    {
        $wh = "";

        if ($s_search) {
            $wh .= "AND n_topic LIKE '%" . trim($s_search) . "%' ";
        }
        if ($s_date) {
            $s_ndate = date('Y-m-d', strtotime($s_date));
            $s_year = date('Y', strtotime($s_date));
            $s_ndate = str_replace($s_year, ($s_year + 543), $s_ndate);
            $wh .= "AND n_date = '{$s_ndate}' ";
        }
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}' ";
        }

        if ($s_search || $s_date || $s_cid) {
            $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh} ORDER BY n_date DESC, n_timestamp DESC ,n_id DESC  ";
            $a_row = db::getRowCount($_sql);
            $a_data = db::getFetchAll($_sql);
            if ($a_data) {
                return $a_data;
            }
        } else {
            return '';
        }
    }

    public static function genArticleSearchLimit($s_search, $s_date, $s_cid, $s_page, $s_limit)
    {
        $wh = "";

        if ($s_search) {
            $wh .= "AND n_topic LIKE '%" . trim($s_search) . "%' ";
        }
        if ($s_date) {
            $s_ndate = date('Y-m-d', strtotime($s_date));
            $s_year = date('Y', strtotime($s_date));
            $s_ndate = str_replace($s_year, ($s_year + 543), $s_ndate);

            $wh .= "AND n_date = '{$s_ndate}' ";
        }
        if ($s_cid) {
            $wh .= "AND c_id = '{$s_cid}' ";
        }
        if ($s_search || $s_date || $s_cid) {
            $perpage = $s_limit;
            if (isset($s_page)) {
                $page = $s_page;
            } else {
                $page = 1;
            }
            $start = ($page - 1) * $perpage;
            $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh} ORDER BY n_date DESC, n_timestamp DESC ,n_id DESC LIMIT {$start},{$perpage} ";
            $a_row = db::getRowCount($_sql);
            $a_data = db::getFetchAll($_sql);
            if ($a_data) {
                return $a_data;
            }
        } else {

            return '';
        }
    }

    public static function genArticleTag($s_nid)
    {
        $wh = "";
        if ($s_nid) {
            $wh .= "AND n_id = '{$s_nid}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_tag WHERE  1=1 {$wh}  ORDER BY tag_id DESC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleTagSearch($s_search)
    {
        $wh = "";

        if ($s_search) {
            $wh .= "AND tag_id = '" . trim($s_search) . "' ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list INNER JOIN article_tag ON article_list.n_id =  article_tag.n_id WHERE  n_approve = 'Y' {$wh} ORDER BY article_list.n_id DESC  ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genArticleTagSearchLimit($s_search, $s_page, $s_limit)
    {
        $wh = "";

        if ($s_search) {
            $wh .= "AND tag_id = '" . trim($s_search) . "' ";
        }
        $perpage = $s_limit;
        if (isset($s_page)) {
            $page = $s_page;
        } else {
            $page = 1;
        }
        $start = ($page - 1) * $perpage;
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list INNER JOIN " . E_DB_NAME . ".article_tag ON article_list.n_id =  article_tag.n_id WHERE  n_approve = 'Y' {$wh} ORDER BY article_list.n_id  DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genHashtag($s_tid, $s_limit)
    {
        $wh = "";
        if ($s_tid) {
            $wh .= "AND tag_id = '{$s_tid}'";
        }
        $perpage = $s_limit;
        if (isset($s_page)) {
            $page = $s_page;
        } else {
            $page = 1;
        }
        $start = ($page - 1) * $perpage;
        $_sql = "SELECT * FROM " . E_DB_NAME . ".tag WHERE tag_status = 'Y' {$wh}  ORDER BY tag_count DESC LIMIT {$start},{$perpage} ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function genViewArticle($s_nid)
    {
        if ($s_nid) {
            $_sql = "UPDATE " . E_DB_NAME . ".article_list SET n_count = n_count+1 WHERE n_id = '{$s_nid}' ";
            $a_row = db::getRowCount($_sql);
            if ($a_row) {
                return $a_row;
            }
        }
    }

    public static function genLikeArticle($s_nid, $s_rank)
    {
        if ($s_nid) {
            if ($_SERVER['REMOTE_ADDR']) {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip_address = $_SERVER['REMOTE_HOST'];
            }

            $strSessionID = session_id();
            $_sql = "SELECT * FROM " . E_DB_NAME . ".like_map WHERE nid = '{$s_nid}'  AND sessionid = '{$strSessionID}' ";
            $a_data = db::getFetchAll($_sql);
            if ($a_data) {
                return '';
            } else {

                $_insert = "INSERT INTO " . E_DB_NAME . ".like_map (nid,ip,sessionid,rank,create_date) VALUES ('{$s_nid}','{$ip_address}','{$strSessionID}','{$s_rank}',NOW() )";
                $a_result = db::getRowCount($_insert);
                if (!empty($a_result)) {
                    switch ($s_rank) {
                        case "1":
                            $_update = "UPDATE " . E_DB_NAME . ".article_list SET n_like = n_like+1 WHERE n_id = '{$s_nid}' ";
                            break;
                        case "-1":
                            //$update_query ="UPDATE links SET votes = votes-1 WHERE id='" . $_POST["id"] . "'";
                            break;
                    }
                    $a_update = db::getRowCount($_update);
                }
                return $a_data;
            }
        }
    }

    public static function CheckLikeArticle($s_nid)
    {
        if ($s_nid) {
            if ($_SERVER['REMOTE_ADDR']) {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip_address = $_SERVER['REMOTE_HOST'];
            }
            $strSessionID = session_id();
            $_sql = "SELECT * FROM " . E_DB_NAME . ".like_map  WHERE nid = '{$s_nid}'  AND  sessionid = '{$strSessionID}' ";
            $a_data = db::getFetchAll($_sql);
            if ($a_data) {
                return $a_data;
            }
        }
    }

    public static function genLogSearch($s_text)
    {
        if ($s_text) {
            if ($_SERVER["REMOTE_ADDR"]) {
                $ip_address = $_SERVER["REMOTE_ADDR"];
            } else {
                $ip_address = $_SERVER["REMOTE_HOST"];
            }
            $_sql = "insert into " . E_DB_NAME . ".search_stat (search_word,search_date,search_time,search_ip,search_module)  values ('{$s_text}','" . date("Y-m-d") . "','" . date("H:i:s") . "','{$ip_address}','2')";

            //$_sql     = "UPDATE article_list SET n_count = n_count+1 WHERE n_id = '{$s_nid}' ";
            $a_row = db::getRowCount($_sql);
            if ($a_row) {
                return $a_row;
            }
        }
    }

    //เปิดปิดการค้นหา
    public static function getCheckSearch($c_id)
    {
        $_sql = "SELECT COUNT('*') AS count FROM " . E_DB_NAME . ".article_group WHERE c_id = '{$c_id}' AND c_show_search = 'Y'";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data["count"];
        }
    }

    //เปิดปิดหมวดย่อย
    public static function getCheckGroup($c_id)
    {
        $_sql = "SELECT COUNT('*') AS count FROM " . E_DB_NAME . ".article_group WHERE c_id = '{$c_id}' AND c_show_sub = 'Y' ";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data["count"];
        }
    }

    //เปิดปิดข่าวภายใต้หมวดย่อย
    public static function getCheckGroupSub($c_id)
    {
        $wh = "";
        if ($c_id) {
            $wh .= " AND c_id = '{$c_id}'";
        }

        $_sql = "SELECT COUNT('*') AS count FROM " . E_DB_NAME . ".article_group WHERE c_show_subnew = 'Y' {$wh}";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data["count"];
        }
    }

    //เปิดปิดรูปภาพ
    public static function getCheckImage($c_id)
    {
        $_sql = "SELECT COUNT('*') AS count FROM " . E_DB_NAME . ".article_group WHERE c_id = '{$c_id}' AND c_show_pic = 'Y' ";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data["count"];
        }
    }

    //เช็คเปิดปิดวันที่, จำนวนการเข้าอ่าน[ครั้ง], บทความ 5 อันดับสูงสุด, โหวตคะแนนให้ข่าว/บทความ, คอมเมนต์
    public static function getArticleChkShow($c_id, $n_id)
    {
        $wh = "";
        if ($c_id) {
            $wh .= " AND c_id = {$c_id}";
        }

        if ($n_id) {
            $wh .= " AND n_id = {$n_id}";
        }

        $_sql = "SELECT show_newstop, show_count, show_date, show_vote, show_comment FROM " . E_DB_NAME . ".article_list WHERE 1=1 {$wh}";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข่อมูลข่าว
    public static function getArticleList($start, $per_page, $s_cid)
    {
        $wh = "";

        if ($s_cid) {
            $wh .= " AND c_id = {$s_cid} ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' {$wh}
		ORDER BY CASE WHEN pinned = 'Y' THEN pinned END DESC,
        n_date DESC, n_timestamp DESC LIMIT {$start},{$per_page}";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลข่าว เก็บเป็น Array แล้ว Where หาด้วยไอดีของ Group 
    public static function getArticleArray($s_cid, $start, $perpage)
    {
        $wh = "";

        if ($s_cid) {
            $wh .= " AND c_id = {$s_cid} ";
        }

        $date_now =  date('Y-m-d H:i');
        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' 
        AND ((n_date_start = '' AND n_date_end = '')
        OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end)) {$wh}
        ORDER BY CASE WHEN pinned = 'Y' THEN pinned END DESC,
        n_date DESC, n_timestamp DESC LIMIT {$start},{$perpage}";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลข่าวและกรุ๊ป
    public static function getArticleAll($c_id, $start, $perpage)
    {
        $wh = "";
        if ($c_id) {
            $wh .= "  AND article_group.c_id in(" . implode(',', $c_id) . ")";
        }

        $date_now =  date('Y-m-d H:i');

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_group
		INNER JOIN " . E_DB_NAME . ".article_list ON (article_group.c_id = article_list.c_id)
		WHERE article_list.n_approve = 'Y' AND article_group.c_show_document = 'Y'
        AND ((article_list.n_date_start = '' AND article_list.n_date_end = '')
        OR (article_list.n_date_start != '' AND article_list.n_date_end = '')
        OR ('{$date_now}' between article_list.n_date_start AND article_list.n_date_end)) {$wh}
        ORDER BY CASE WHEN article_list.pinned = 'Y' THEN article_list.pinned END DESC, 
        article_list.n_date DESC, article_list.n_timestamp DESC
		LIMIT {$start},{$perpage}";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียข้อมูลข่าวทั้งหมด ทำการแบ่งหน้า และสามารถ ค้นหาได้
    public static function getArticleLimit($start, $per_page, $s_cid, $s_search = null, $n_date_start = null, $n_date_end = null, $org_name = null)
    {
        $wh = "";
        $date_now =  date('Y-m-d H:i');

        if ($s_cid) {
            $sub_query = self::getArticleSub($s_cid);
            $wh .= " AND c_id IN ($sub_query) ";
        }

        if ($s_search) {
            $wh .= " AND n_topic LIKE '%" . trim($s_search) . "%' ";
        }

        if ($n_date_start) {
            $date_start = convDateAd($n_date_start);
            $wh .= " AND n_date >= '{$n_date_start}'";
        }

        if ($n_date_end) {
            $date_end = convDateAd($n_date_end);
            $wh .= " AND n_date <= '{$n_date_end}'";
        }

        if ($org_name) {
            $wh .= " AND n_owner_org LIKE '%" . trim($org_name) . "%' ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list 
        WHERE n_approve = 'Y' {$wh} 
        AND ((n_date_start = '' AND n_date_end = '') 
        OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end))
        ORDER BY CASE WHEN pinned = 'Y' THEN pinned END DESC,
        n_date DESC, n_timestamp DESC 
        LIMIT {$start},{$per_page}";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        //นับจำนวนข่าวทั้งหมด
        $_sql_all = "SELECT n_id FROM " . E_DB_NAME . ".article_list 
        WHERE n_approve = 'Y' {$wh} 
        AND ((n_date_start = '' AND n_date_end = '') 
        OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end)) ";

        $a_row_all = db::getRowCount($_sql_all);
        $rss = self::getArticleFirstGroup($s_cid)['c_rss'];

        if ($rss == "Y") {
            $url = HTTP_HOST . "rss/group" . $s_cid . ".xml";
        } else {
            $url = "";
        }

        if ($a_data) {
            return array(
                "statement" => $_sql_all,
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all,
                "url" => $url
            );
        }
    }

    //เรียกข้อมูลข่าว และ ข่าวในหมวดย่อย เก็บเป็น array
    public static function getArticleSub($c_id)
    {
        $wh = "";
        $s_cid = array();
        array_push($s_cid, $c_id);

        if ($c_id) {
            $wh .= " AND c_parent = '{$c_id}'";
        }

        $a_data = self::getCheckGroupSub($c_id);

        if ($a_data > 0) {
            $_sql_sub = "SELECT c_id FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
            $a_data_sub = db::getFetchAll($_sql_sub);

            foreach ($a_data_sub as $value) {
                array_push($s_cid, self::getArticleSub($value['c_id']));
            }
        }

        return implode(",", array_unique($s_cid));
    }

    //เรียกข่อมูลข่าวย่อย
    public static function getSubArticleList($start, $per_page, $s_cid)
    {
        $wh = "";

        if ($s_cid) {
            $sub_query = self::getArticleSub($s_cid);
            $wh .= " AND c_id IN ($sub_query)";
        }

        $date_now =  date('Y-m-d H:i');

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' 
        {$wh} AND ((n_date_start = '' AND n_date_end = '')
        OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end)) 
		ORDER BY CASE WHEN pinned = 'Y' THEN pinned END DESC, 
        n_date DESC, n_timestamp DESC
		LIMIT {$start},{$per_page}";

        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข่อมูลข่าวย่อย แบ่งหน้า
    public static function getSubArticleListLimit($start, $per_page, $s_cid)
    {
        $wh = "";

        if ($s_cid) {
            $sub_query = self::getArticleSub($s_cid);
            $wh .= " AND c_id IN ($sub_query)";
        }

        $date_now =  date('Y-m-d H:i');

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' 
        {$wh} AND ((n_date_start = '' AND n_date_end = '') OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end)) ORDER BY CASE WHEN pinned = 'Y' THEN pinned END DESC, 
        n_date DESC, n_timestamp DESC LIMIT {$start},{$per_page}";

        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        //นับจำนวนข่าวทั้งหมด
        $_sql_all = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' 
        {$wh} AND ((n_date_start = '' AND n_date_end = '') OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end)) ";

        $a_row_all = db::getRowCount($_sql_all);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row,
                "countAll" => $a_row_all,
            );
        }
    }

    //นับจำนวนข่าวย่อย
    public static function getCoutSubArticleList($s_cid)
    {
        $wh = "";
        if ($s_cid) {
            $sub_query = self::getArticleSub($s_cid);
            $wh .= " AND c_id IN ($sub_query) ";
        }

        $date_now = date("Y-m-d H:i");

        $_sql = "SELECT c_id FROM " . E_DB_NAME . ".article_list WHERE n_approve = 'Y' 
        {$wh} AND ((n_date_start = '' AND n_date_end = '') 
        OR (n_date_start != '' AND n_date_end = '')
        OR ('{$date_now}' between n_date_start AND n_date_end))";
        $a_row = db::getRowCount($_sql);

        if ($a_row) {
            return $a_row;
        }
    }

    //เรียกข้อมูลกรุ๊ปข่าวตาม c_id
    public static function getArticleFirstGroup($s_cid, $s_nid = null)
    {
        $wh = "";

        if ($s_cid) {
            $wh .= " AND c_id = '{$s_cid}'";
        }

        if ($s_nid) {
            //Where n_id
            $_sql2 = "SELECT c_id FROM " . E_DB_NAME . ".article_list WHERE n_id = '{$s_nid}'";
            $a_data2 = db::getFetch($_sql2);
            //Where c_id
            $wh .= "AND c_id = '{$a_data2['c_id']}'";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //เรียกข้อมูลกรุ๊ป
    public static function getArticleGroup($c_id = null)
    {
        $wh = "";
        if ($c_id) {
            $wh .= " AND c_id IN (" . implode(',', $c_id) . ")";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh} ORDER BY FIELD(c_id, " . implode(',', $c_id) . ")";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    // หา หัวข้อย่อยทั้งหมด จากหัวข้อใหญ่
    public static function getArticleHeadSubGroup($c_id)
    {
        $wh = "";
        $data = "";
        $Hid = self::getArticleHead($c_id);
        if ($c_id) {
            $wh .= " AND  c_parent = '$Hid' And c_parent != 0";
        }

        $_sql = "SELECT c_id, c_name, c_show_document,c_parent FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        // return $_sql;
        $a_data = db::getFetchAll($_sql);
        foreach ($a_data  as $key => $value) {
            $data = $data . "," . $value["c_id"];
        }
        if ($data) {
            return $data;
        }
    }

    // หา c_id จาก c_parent
    public static function getArticleHead($c_id)
    {
        $wh = "";
        $data = "";
        if ($c_id) {
            $sub_query = self::getArticleSub($c_id);
            $wh .= " AND  c_id= '$c_id'";
        }

        $_sql = "SELECT c_id, c_name, c_show_document,c_parent FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        // return $_sql;
        $a_data = db::getFetchAll($_sql);
        foreach ($a_data  as $key => $value) {
            $data = $value["c_parent"];
        }
        if ($data) {
            return $data;
        }
    }

    //เรียกข้อมูลกรุ๊ปหมวดย่อย
    public static function getArticleSubGroup($c_id)
    {

        $headsub  =  article::getArticleHeadSubGroup($c_id);

        // return($headsub );
        $wh = "";
        if ($c_id) {
            $sub_query = self::getArticleSub($c_id);
            if ($headsub) {
                $sub_query = $sub_query . "" . $headsub;
            }
            $wh .= " AND c_id IN ($sub_query)";
        }

        $_sql = "SELECT c_id, c_name, c_show_document FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        // return ($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }



    //เรียกข้อมูลกรุ๊ปหมวดย่อย
    public static function getArticleSubGroupList($c_id)
    {
        $wh = "";
        if ($c_id) {
            $sub_query = self::getArticleSub($c_id);
            $wh .= " AND c_id IN ($sub_query) AND c_id != {$c_id}";
        }

        $_sql = "SELECT c_id, c_name, c_show_document FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //นับข้อมูลกรุ๊ปหมวดย่อย
    public static function getCountArticleSubGroup($c_id)
    {
        $date_now =  date('Y-m-d H:i');
        $_sql = "SELECT article_group.c_id FROM " . E_DB_NAME . ".article_group
		INNER JOIN " . E_DB_NAME . ".article_list ON (article_group.c_id = article_list.c_id)
		WHERE article_group.c_parent = '$c_id' AND article_group.c_show_document = 'Y'
        AND ((article_list.n_date_start = '' AND article_list.n_date_end = '')
        OR (article_list.n_date_start != '' AND article_list.n_date_end = '')
        OR ('{$date_now}' between article_list.n_date_start AND article_list.n_date_end))";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $data = array();
            foreach ($a_data as $value) {
                $data[$value["c_id"]][] = $value["c_id"];
            }

            return $data;
        }
    }

    //เรียกข้อมูล navigation 
    public static function article_group_parent($c_id, $c_org = null)
    {
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = '{$c_id}'";
        }

        $s_parent = "SELECT c_id,c_parent,c_name FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        $c_orgs = !empty($c_org) ? '&c_org=' . $c_org : null;

        if (db::getRowCount($s_parent)) {
            $a_parent = db::getFetch($s_parent);
            $txt = " >> <a href =\"more_news.php?c_id=" . $a_parent['c_id'] . "" . $c_orgs . "\" class=\"article_nvt\">" . $a_parent['c_name'] . "</a>";
            if ($a_parent['c_parent'] != "0" and $a_parent['c_parent'] != "") {
                $txt = self::article_group_parent($a_parent['c_parent']) . $txt;
            }
        }
        return $txt;
    }

    //เรียกข้อมูล navigation 
    public static function article_sub_group_option($c_id)
    {
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = '{$c_id}'";
        }

        $s_parent = "SELECT c_id,c_parent,c_name FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        if (db::getRowCount($s_parent)) {
            $a_parent = db::getFetch($s_parent);
            $txt = "<option value=" . $a_parent['c_id'] . "> >> " . $a_parent['c_name'] . "</option>";
            if ($a_parent['c_parent'] != "0" and $a_parent['c_parent'] != "") {
                $txt = self::article_sub_group_option($a_parent['c_parent']) . $txt;
            }
        }
        return $txt;
    }

    //เรียกข้อมูลหมวดภายใต้
    public static function find_sub_group($c_id)
    {
        $wh = "";

        $article_subnew_array["detail"] = array();
        $article_subnew_array["list"]   = array();

        if ($c_id) {
            $wh .= " AND c_parent = '{$c_id}'";
        }

        $_sql = "SELECT c_id, c_name FROM " . E_DB_NAME . ".article_group WHERE c_show_document = 'Y' {$wh}";
        $a_data = db::getFetchAll($_sql);

        foreach ($a_data as $ar_sub) {
            array_push($article_subnew_array["detail"], array("c_id" => $ar_sub['c_id'], "c_name" => $ar_sub['c_name']));
            array_push($article_subnew_array["list"], $ar_sub['c_id']);
            self::find_sub_group($ar_sub['c_id']);
        }
        return $article_subnew_array;
    }

    //เรียกข้อมูลติดตามข่าวสารหมวด
    public static function getFavoriteLog($c_id = null, $fav_userid = null)
    {
        $wh = "";

        if ($c_id) {
            $wh .= " AND c_id = '{$c_id}'";
        }

        if ($fav_userid) {
            $wh .= " AND fav_userid = '{$fav_userid}'";
        }

        $sql = "SELECT * FROM " . E_DB_NAME . ".article_favorite_log WHERE 1=1 {$wh}";
        $a_data = db::getFetchAll($sql);
        $a_row = db::getRowCount($sql);

        if ($a_data) {
            return array(
                "data" => $a_data,
                "count" => $a_row
            );
        }
    }

    //เรียกข้อมูลหน่วยงาน Organization
    public static function getOrg($n_org = null)
    {
        $wh = "";
        if ($n_org) {
            $wh .= " AND org_id = '{$n_org}'";
        }

        $_sql = "SELECT short_name, name_org FROM " . E_DB_USER . ".org_name WHERE 1=1 {$wh}";
        $a_data = db::getFetch($_sql);

        if ($a_data) {
            return array(
                "name" => !empty($a_data["short_name"]) ? $a_data["short_name"] : $a_data["name_org"],
                "name_org" => $a_data["name_org"],
                "short_name" => $a_data["short_name"]
            );
        }
    }

    public static function getOrgName($org_id = null, $org_name = null)
    {
        $wh = "";

        if ($org_id) {
            $wh .= " AND org_id = '{$org_id}'";
        }

        if ($org_name) {
            $wh .= " AND name_org LIKE '%' . trim($org_name) . '%'";
        }

        $_sql = "SELECT * FROM " . E_DB_USER . ".org_name WHERE 1=1 {$wh} ORDER BY org_id ASC";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            return $a_data;
        }
    }
}
