<?php
class menu
{
    public static function getMenu($s_mid = false, $s_msub = false)
    {
        $wh = "";
        if ($s_mid) {
            $wh .= "AND m_id = '$s_mid' ";
        }

        if ($s_msub) {
            $wh .= "AND mp_sub = '$s_msub' ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE 1=1 {$wh} ORDER BY mp_pos ASC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function getMenuView($s_mid)
    {
        $txt = '';
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '0'   ORDER BY mp_pos ASC ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            $txt .= '<a class="header__toggle-menu" href="#0" title="Menu"><span>Menu</span></a>';
            $txt .= '<nav class="header__nav-wrap">';
            $txt .= '<h2 class="header__nav-heading h6">Menu</h2>';
            $txt .= '<ul class="header__nav">';

            foreach ((array) $a_data as $_item) {
                if ($_item['Oubold'] == 'italic') {
                    $Oubold = 'font-style:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'bold') {
                    $Oubold = 'font-weight:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'underline') {
                    $Oubold = 'text-decoration:' . $_item['Oubold'] . ';';
                }
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<li class="has-children" ><a href="">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    //$txt .=$_item['mp_name'];
                    $txt .= ' <i class="ti-angle-down"></i>';
                    $txt .= '</a>';
                    $txt .= self::getMenuViewSub($s_mid, $_item['mp_pid']);
                    $txt .= '</li>';
                } else {
                    $txt .= '<li><a href="' . self::genLink($_item['Glink']) . '" title="">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    //$txt .=$_item['mp_name'];
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    $txt .= '</a>';
                    $txt .= '</li>';
                }
            }
            $txt .= '<li><a href="login.php" title=""><em class="fa fa-user"></em> เข้าสู่ระบบ</a></li>';
            $txt .= '</ul> <!-- end header__nav -->';
            $txt .= '<a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu">Close</a>';
            $txt .= ' </nav> <!-- end header__nav-wrap -->';
        }
        return $txt;
    }

    public static function getMenuViewSub($s_mid, $s_pid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid'  ORDER BY mp_pos ASC ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            $txt .= '<ul class="sub-menu">';
            foreach ((array) $a_data as $_item) {
                if ($_item['Oubold'] == 'italic') {
                    $Oubold = 'font-style:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'bold') {
                    $Oubold = 'font-weight:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'underline') {
                    $Oubold = 'text-decoration:' . $_item['Oubold'] . ';';
                }

                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<li><a href="">';
                    if (!empty($_item['Oubgpic'])) {
                        //$txt .='<i class="'.$_item['Oubgpic'].' "></i> ';
                    }
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    //$txt .=$_item['mp_name'];
                    $txt .= ' <i class="ti-angle-down"></i>';
                    $txt .= '</a>';
                    $txt .= self::getMenuViewSub($s_mid, $_item['mp_pid']);
                    $txt .= '</li>';
                } else {
                    $txt .= '<li><a href="' . self::genLink($_item['Glink']) . '">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    //$txt .=$_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= '</li>';
                }
            }
            $txt .= '</ul>';
        }
        return $txt;
    }

    public static function getSitemapView($s_mid)
    {
        $txt = '';
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '0'   ORDER BY mp_pos ASC ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {

            foreach ((array) $a_data as $_item) {
                if ($_item['Oubold'] == 'italic') {
                    $Oubold = 'font-style:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'bold') {
                    $Oubold = 'font-weight:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'underline') {
                    $Oubold = 'text-decoration:' . $_item['Oubold'] . ';';
                }
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    //$txt .='<li class="has-children" ><a href="">';
                    $txt .= '<div class="col-three md-four mob-full s-footer__sitelinks">';
                    $txt .= '<h4>';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    $txt .= '</h4>';
                    $txt .= self::getSitemapViewSub($s_mid, $_item['mp_pid']);
                    $txt .= '</div>';
                } else {
                    $txt .= '<div class="col-three md-four mob-full s-footer__sitelinks">';
                    $txt .= '<h4>';
                    $txt .= '<a href="' . self::genLink($_item['Glink']) . '" title="">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    //$txt .=$_item['mp_name'];
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    $txt .= '</a>';
                    $txt .= '</h4>';
                    $txt .= '</div>';
                }
            }
        }
        return $txt;
    }

    public static function getSitemapViewSub($s_mid, $s_pid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid'  ORDER BY mp_pos ASC ";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            $txt = '';
            $txt .= '<ul class="s-footer__linklist">';
            foreach ((array) $a_data as $_item) {
                if ($_item['Oubold'] == 'italic') {
                    $Oubold = 'font-style:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'bold') {
                    $Oubold = 'font-weight:' . $_item['Oubold'] . ';';
                } else if ($_item['Oubold'] == 'underline') {
                    $Oubold = 'text-decoration:' . $_item['Oubold'] . ';';
                }
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<li class="has-children" ><a href="">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    $txt .= self::getSitemapViewSub($s_mid, $_item['mp_pid']);
                    $txt .= '</li>';
                } else {
                    $txt .= '<li><a href="' . self::genLink($_item['Glink']) . '" title="">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '"></i> ';
                    }
                    $txt .= '<span style="' . $Oubold . '" >' . $_item['mp_name'] . '</span>';
                    $txt .= '</a>';
                    $txt .= '</li>';
                }
            }
            $txt .= '</ul>';
        }
        return $txt;
    }

    public static function genMenuCat($s_mid)
    {
        $wh = "";
        if ($s_mid) {
            $wh .= " m_id = '$s_mid' ";
            $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_list WHERE  {$wh} ";
            $a_row = db::getRowCount($_sql);
            $a_data = db::getFetchAll($_sql);
            if ($a_data) {
                return $a_data;
            }
        }
    }
    public static function genLink($link_html)
    {
        if (strstr($link_html, 'cid')) {
            $link = $link_html;
        } else if (strstr($link_html, 'http') || strstr($link_html, 'https') || strstr($link_html, 'wwww')) {
            $link = $link_html;
        } else if (strstr($link_html, 'n_id')) {
            $sub_link = explode("=", $link_html);

            $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE n_id = '$sub_link[1]' ";
            $a_data = db::getFetch($_sql);

            if ($a_data["link_html"] == "") {
                $link = "news_view.php?n_id=" . $sub_link[1];
            } else {
                //$link = glink($a_data["link_html"]);
            }
        } else if (strstr($link_html, 'news_view.php') || strstr($link_html, 'news_view.php')) {
            //$sub_link = explode("=",$link_html);

            $_sql = "SELECT * FROM " . E_DB_NAME . ".article_list WHERE link_html = '$link_html' ";
            $a_data = db::getFetch($_sql);

            $link = "news_view.php?n_id=" . $a_data["n_id"];
        } else {
            if ($link_html != "" && $link_html != "#") {
                $link = $link_html;
            } else {
                $link = "";
            }
        }
        return $link;
    }
    public static function genMenu($s_mid = false, $s_msub = false)
    {
        $wh = "";
        if ($s_mid) {
            $wh .= "AND m_id = '$s_mid' ";
        }

        if ($s_msub) {
            $wh .= "AND mp_sub = '$s_msub' ";
        }

        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE 1=1 {$wh} ORDER BY mp_pos ASC";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);
        if ($a_data) {
            return $a_data;
        }
    }

    public static function chkMenuSub($s_mid, $s_pid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid'";
        $a_row = db::getRowCount($_sql);
        $a_data = db::getFetchAll($_sql);

        if ($a_row) {
            return $a_data;
        }
    }

    public static function genMenuLen($s_data, $s_op)
    {
        $s = explode($s_op, $s_data);
        return count($s);
    }

    //เมนู templates รูปแบบที่ 2
    public static function genMenuView2($s_mid, $c_org = null)
    {
        $c_link = !empty($c_org) ? '&c_org=' . $c_org : null;
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '0' AND mp_show = 'Y' ORDER BY mp_pos ASC ";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            $txt1 = '';
            foreach ($a_data as $key => $_item) {
                $Glink = ($_item['mp_name'] == "หน้าหลัก" ? "index.php" : self::genLink($_item['Glink'])) . $c_link;

                //level1
                $txt1 .= '<a class="nav-link ' . ($key == 0 ? 'active' : null) . '" href="' . $Glink . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';">';
                if (!empty($_item['Oubgpic'])) {
                    $txt1 .= '<i class="' . $_item['Oubgpic'] . '" aria-hidden="true"></i>&nbsp;';
                }
                $txt1 .= '<span class="txt-white-nav">' . $_item['mp_name'] . '</span>';
                $txt1 .= '</a>';

                //level3
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<a data-toggle="collapse"  href="#collapseMenu' . $key . '" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';" role="button" aria-expanded="false" aria-controls="collapseMenu' . $key . '">';
                    $txt .= $_item['mp_name'];
                    $txt .= '<i class="fas fa-caret-down"></i>';
                    $txt .= '</a>';
                    $txt .= '<div class="collapse" id="collapseMenu' . $key . '">';
                    $txt .= '<div class="card card-body">';
                    $txt .= self::genMenuViewSub2($s_mid, $_item['mp_pid'], $c_link);
                    $txt .= '</div>';
                    $txt .= '</div>';
                } else {
                    $txt .= '<a href="' . $Glink . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '" aria-hidden="true"></i>&nbsp;';
                    }
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                }
            }

            return array(
                "level1" => $txt1,
                "level3" => $txt,
            );
        }
    }

    public static function genMenuViewSub2($s_mid, $s_pid, $c_org = null)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid' ORDER BY mp_pos ASC ";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            $txt .= '<ul>';
            foreach ((array) $a_data as $_item) {
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<li>';
                    $txt .= '<a href="#" class="pl-0 text-dark">';
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= '</li>';

                    $txt .= '<ul>';
                    //$txt .= '<li>';
                    $txt .= self::genMenuViewSub_2($s_mid, $_item['mp_pid'], $c_org = null);
                    //$txt .= '</li>';
                    $txt .= '</ul>';
                } else {
                    $txt .= '<li>';
                    $txt .= '<a href="' . self::genLink($_item['Glink']) . '' . $c_org . '" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';" class="pl-0 text-dark">';
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= '</li>';
                }
            }
            $txt .= '</ul>';
        }
        return $txt;
    }

    public static function genMenuViewSub_2($s_mid, $s_pid, $c_org = null)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid' ORDER BY mp_pos ASC ";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            // $txt = '';
            // $txt .= '<li>';
            // $txt .= '<ul>';
            // $txt .= '<a href="' . self::genLink($_item['Glink']) . '" class="pl-0 text-dark">';
            // $txt .= $_item['mp_name'];
            // $txt .= '</a>';
            // $txt .= '</ul>';
            // $txt .= '</li>';

            $txt = '';
            foreach ((array) $a_data as $_item) {
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<ul>';
                    $txt .= '<li>';
                    $txt .= '<a href="#" class="pl-0 text-dark">';
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= '</li>';
                    $txt .= '</ul>';
                } else {
                    $txt .= '<ul>';
                    $txt .= '<li>';
                    $txt .= '<a href="' . self::genLink($_item['Glink']) . '' . $c_org . '" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';" class="pl-0 text-dark">';
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= '</li>';
                    $txt .= '</ul>';
                }
            }
        }
        return $txt;
    }

    //เมนู templates รูปแบบที่ 3
    public static function genMenuView3($s_mid, $t_page = null)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '0' AND mp_show = 'Y' ORDER BY mp_pos ASC ";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            $txt .= '<ul class="navbar-nav ml-auto txt-color-menu">';
            foreach ((array) $a_data as $key => $_item) {
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<li class="nav-item dropdown font-nav-item">';
                    $txt .= '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '" aria-hidden="true"></i>&nbsp;';
                    }
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= self::genMenuViewSub3($s_mid, $_item['mp_pid']);
                    $txt .= '</li>';
                } else {
                    $Glink = ($_item['mp_name'] == "หน้าหลัก" ? getUrlTemplate(BASE_URL) : self::genLink($_item['Glink']));
                    $txt .= '<li class="nav-item ' . ($key == 0 ? "active" : "") . ' font-nav-item">';
                    $txt .= '<a class="nav-link" href="' . $Glink . '" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';">';
                    if (!empty($_item['Oubgpic'])) {
                        $txt .= '<i class="' . $_item['Oubgpic'] . '" aria-hidden="true"></i>&nbsp;';
                    }
                    $txt .= $_item['mp_name'];
                    $txt .= '<span class="sr-only">(current)</span>';
                    $txt .= '</a>';
                    $txt .= '</li>';
                }
            }

            if ($t_page == 1) {
            } else {
                $txt .= '<li class="nav-item pl-4 my-auto font-nav-item">';
                $txt .= '<a class="color-font-size pl-2" href="#">';
                // $txt .= '<span class="font-s" id="decrease" value="Decrease"> ก </span>';
                // $txt .= '</a>';
                // $txt .= '<a class="color-font-size pl-2" href="#">';
                // $txt .= '<span class="font-m" id="normal" value="normal"> ก </span>';
                // $txt .= '</a>';
                // $txt .= '<a class="color-font-size pl-2" href="#"> ';
                // $txt .= '<span class="font-l" id="increase" value="Increase"> ก </span>';
                // $txt .= '</a>';
                $txt .= '</li>';

                $txt .= '<li class="nav-item pl-4 my-auto font-nav-item">';
                $txt .= '<a class="#" href="search.php"> <em class="fa fa-search"></em> </a>';
                $txt .= '</li>';
                $txt .= '<li class="nav-item pl-4 my-auto font-nav-item">';
                $txt .= '<a class="#" href="#"  data-toggle="modal" data-target="#alert_mail"> <em class="far fa-envelope"></em> </a>';
                $txt .= '</li>';
                $txt .= '<li class="nav-item pl-4 my-auto font-nav-item">';
                $txt .= ' <a class="#" href="#" data-toggle="modal" data-target="#alert"> <em class="far fa-bell "> </em> </a>';
                $txt .= '</li>';
                $txt .= '</ul>';

                // $txt .= '<a class="#" href="search.php"> <em class=""></em> </a>';
            }
        }

        return $txt;
    }

    public static function genMenuViewSub3($s_mid, $s_pid)
    {
		dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
		
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid' AND mp_show = 'Y' ORDER BY mp_pos ASC ";
        $a_data = db::getFetchAll($_sql);
		
		// CHECK ว่า เป็น ข้าราชการ, พนักงานราชการ, ลูกจ้างประจำ
		$chk_per_type = "SELECT COUNT(*) AS C_CHK
						FROM USR_MAIN A
						LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
						WHERE (B.PER_TYPE IN (1,2,3) OR A.USR_ADM = 'Y')
						AND A.USR_USERNAME = '".$_SESSION['EWT_USERNAME']."' ";
		$q = dbdpis::execute($chk_per_type);
		$chk = dbdpis::Fetch($q);
		// CHECK ว่า อยู่ใน พระราม 6
		$chk_per_dep = "SELECT COUNT(*) AS C_CHK
						FROM USR_MAIN A
						LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
						WHERE ( B.DEP_LV1_ID IN (244,298,305,265,322,266,328) OR B.DEP_LV2_ID IN (362) OR A.USR_ADM = 'Y' )
						AND A.USR_USERNAME =  '".$_SESSION['EWT_USERNAME']."' ";
		$q_2 = dbdpis::execute($chk_per_dep);
		$chk_2 = dbdpis::Fetch($q_2);
		

        if ($a_data) {
            $txt = '';
            $txt .= '<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">';
            foreach ((array) $a_data as $_item) {
				$h_1 = "";
				$h_2 = "";
				if($_item['mp_pid'] == 7){// 7 คือ เมนูระบบขอหนังสือรับรอง
					if($chk['C_CHK'] < 1){
						$h_1 = "hidden";//ขอหนังสือรับรอง
					}
				}
				if($_item['mp_pid'] == 8 || $_item['mp_pid'] == 9){// 8,9 คือ เมนูระบบจองยาน ,จองห้อง
					if($chk_2['C_CHK'] < 1){
						$h_2 = "hidden";//จองยาน ,จองห้อง
					}
				}
				
                if (self::chkMenuSub($s_mid, $_item['mp_pid'])) {
                    $txt .= '<li class="dropdown-submenu">';
                    $txt .= '<a class="dropdown-item dropdown-toggle" href="#">';
                    $txt .= $_item['mp_name'];
                    $txt .= '</a>';
                    $txt .= '<ul class="dropdown-menu">';
                    $txt .= self::genMenuViewSub_3($s_mid, $_item['mp_pid']);
                    $txt .= '</ul>';
                    $txt .= '</li>';
                } else {
                    $txt .= '<li '.$h_1.$h_2.'>';
					
                    $txt .= '<a class="dropdown-item" href="' . self::genLink($_item['Glink']) . '" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';">';
                    $txt .= $_item['mp_name'];//.$r_chk_per_type['C_CHK']
                    $txt .= '</a>';
                    $txt .= '</li>';
                }
            }
            $txt .= '</ul>';
        }
        return $txt;
    }

    public static function genMenuViewSub_3($s_mid, $s_pid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_sub = '$s_pid' AND mp_show = 'Y' ORDER BY mp_pos ASC ";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            foreach ($a_data as $_item) {
                $txt .= '<li>';
                $txt .= '<a class="dropdown-item" href="' . self::genLink($_item['Glink']) . '" title="' . $_item['mp_name'] . '" target="' . $_item['Gtarget'] . '" style="text-align: ' . $_item['Oufont'] . '; font-weight: ' . $_item['Oubold'] . '; font-style: ' . $_item['Ouitalic'] . '; text-decoration: ' . $_item['Oubordercolor'] . ';">';
                $txt .= $_item['mp_name'];
                $txt .= '</a>';
                $txt .= '</li>';
            }
        }
        return $txt;
    }

    //เมนู Footer 1
    public static function getMenuFooter1($s_mid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_show = 'Y' ORDER BY mp_pos ASC";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            foreach ($a_data as $_item) {
                $txt .= '<li>';
                $txt .= '<i class="fa fa-chevron-right" aria-hidden="true" color="#e7c8ff"></i>&nbsp;';
                $txt .= '<a href="' . self::genLink($_item['Glink']) . '">';
                $txt .= $_item['mp_name'];
                $txt .= '</a>';
                $txt .= '</li>';
            }

            return $txt;
        }
    }

    //เมนู Footer 2
    public static function getMenuFooter2($s_mid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_show = 'Y' ORDER BY mp_pos ASC";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            foreach ($a_data as $key => $val) {
                $txt .= '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">';
                $txt .= '<div class="border-b-1 p-2">';
                $txt .= '<a class="text-muted" href="' . $val['Glink'] . '" title="' . $val['mp_name'] . '" target="' . $val['Gtarget'] . '"> ' . $val['mp_name'] . ' </a>';
                $txt .= '</div>';
                $txt .= '</div>';
            }

            return $txt;
        }
    }

    //เมนู Footer 3
    public static function getMenuFooter3($s_mid)
    {
        $_sql = "SELECT * FROM " . E_DB_NAME . ".menu_properties WHERE m_id = '$s_mid' AND mp_show = 'Y' ORDER BY mp_pos ASC";
        $a_data = db::getFetchAll($_sql);

        if ($a_data) {
            $txt = '';
            foreach ($a_data as $key => $val) {
                $txt .= '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">';
                $txt .= '<div class="border-b-1 p-2">';
                $txt .= '<a class="text-muted" href="' . $val['Glink'] . '" title="' . $val['mp_name'] . '" target="' . $val['Gtarget'] . '"> ' . $val['mp_name'] . ' </a>';
                $txt .= '</div>';
                $txt .= '</div>';
            }

            return $txt;
        }
    }
}
