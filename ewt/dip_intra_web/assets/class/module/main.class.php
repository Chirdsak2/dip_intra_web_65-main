<?php
class main
{
    //เรียกข้อมูลแสดงวันนี้มีอะไร template3
    public static function getAllmaintopIndex($sso)
    {
        $ecard_user = $sso->getEcardUser(date('Y-m-d'));
        $calendar = calendar::getManagerCalendar();
        $calendar_e = calendar::getMoreCalendar(0, 10)["data"];
        $vocab = $sso->getChitChat()["dataAll"];

        // foreach ($ecard_user['dataAll'] as $key => $value) {
        //     $user_image = getImgbase64("profile/" . $value["USR_PICTURE"], "images/user_profile_empty.png");
        //     $title1 = '';
        //     $title1 .= '<div class="col-lg-4 col-md-6 col-sm-12 col-12">';
        //     $title1 .= '<div class="media mb-2">';
        //     $title1 .= '<img src="' . $user_image . '" class="mr-3 max-width-pic-today border-ra-10px">';
        //     $title1 .= '<div class="media-body font12px text-left">';
        //     $title1 .= '<div> สุขสันต์วันเกิด </div>';
        //     $title1 .= '<div><i class="fa fa-birthday-cake" aria-hidden="true"></i> '.$ecard_user["count"].' ท่าน</div>';
        //     $title1 .= '<div>คุณ ' . $value['USR_FNAME'] . '</div>';
        //     $title1 .= '<a href="#" data-toggle="modal" data-target="#modal_birth_date" onclick="setEventEcardId(' . $value['USR_ID'] . ',' . $_SESSION['EWT_MID'] . ')">';
        //     $title1 .= '<div class="btn-hbd-gift txt-white"> ส่งการ์ดอวยพร </div>';
        //     $title1 .= '<img src="assets/img/icon-gift.png" alt="gift" title="gift" class="position-gift">';
        //     $title1 .= '</a>';
        //     $title1 .= '</div>';
        //     $title1 .= '</div>';
        //     $title1 .= '</div>';
        //     $group1[] = array(
        //         "title" => $title1,
        //     );
        // }

        $title1 = '';
        if (!empty($ecard_user)) {
            $title1 .= '<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="padding-left: 30px;">';
            $title1 .= '<a href="send_hbd.php" target="_blank">';
            $title1 .= '<div class="row p-2 mb-3 bg-box-hbd width100per-small">';
            $title1 .= '<div class="col-lg-6 col-md-6 col-sm-12 col-12 font25px text-center width-hbd-100per-tablet">';
            $title1 .= '<img src="assets/img/icon-gift.png" alt="gift" title="gift" class="py-2">';
            $title1 .= '</div>';
            $title1 .= '<div class="col-lg-8 col-md-8 col-sm-12 col-12 pl-1 text-center width-hbd-100per-tablet">';
            $title1 .= '<div class="font12px"> ท่านที่เกิดวันนี้ </div>';
            $title1 .= '<div class="font20px"> ' . $ecard_user["count"] . ' <span class="font15px"> ท่าน </span> </div>';
            $title1 .= '</div>';
            $title1 .= '</div>';
            $title1 .= '</a>';
            $title1 .= '</div>';

            $group1[] = array(
                "title" => $title1,
            );
        }

        foreach ($calendar as $key => $value) {
            $calendar_event = calendar::getEventCalendar()[$value["cat_id"]];
            $m_image = (empty($value['m_images']) ? "images/user001.png" : 'assets/images/calendar/' . $value['m_images']);

            if (!empty($calendar_event)) {
                $title2 = '';
                $title2 .= '<div class="col-lg-6 col-md-6 col-sm-12 col-12">';
                $title2 .= '<div class="media mb-2">';
                $title2 .= '<img src="' . $m_image . '" alt="' . $m_image . '" class="mr-3 max-width-pic-today border-ra-10px">';

                $title2 .= '<div class="media-body font12px text-left">';
                $title2 .= '<div>' . $value['m_pos'] . '</div>';

                if ($calendar_event[0]['event_time_start'] != "00:00" && $calendar_event[0]['event_time_end'] != "00:00") {
                    $title2 .= '<div>' . $calendar_event[0]['event_time_start'] . '-' . $calendar_event[0]['event_time_end'] . '</div>';
                }

                $title2 .= '<div>' . mb_strimwidth($calendar_event[0]['event_title'], 0, 50, '...') . '</div>';
                $title2 .= '</div>';

                $title2 .= '</div>';
                $title2 .= '</div>';
                $group2[] = array(
                    "title" => $title2,
                );
            }
        }

        foreach ($calendar_e as $key => $value) {
            $image = "images/calendar/calendar_icon.png";
            $title3 = '';
            $title3 .= '<div class="col-lg-6 col-md-6 col-sm-12 col-12">';
            $title3 .= '<div class="media mb-2">';
            $title3 .= '<img src="' . $image . '" alt="' . $image . '" class="mr-3 max-width-pic-today border-ra-10px">';

            $title3 .= '<div class="media-body font12px text-left">';
            $title3 .= '<div>' . $value['event_title'] . '</div>';
            $title3 .= '<div>' . date("H:i", strtotime($value['event_time_start'])) . '-' . date("H:i", strtotime($value['event_time_end'])) . '</div>';
            $title3 .= '<div class="btn-en-chitchat"> <a href="calendar_view.php?event_id=' . $value["event_id"] . '" style="cursor: pointer;">ดูรายละเอียด </a></div>';
            $title3 .= '</div>';

            $title3 .= '</div>';
            $title3 .= '</div>';
            $group2[] = array(
                "title" => $title3,
            );
        }

        foreach ($vocab as $key => $value) {
            $sound = $sso->getSound($value["VOCAB_ID"], 'VOCAB_FILE1')["data"]["FILE_SAVE_NAME"];
            $title4 = '';
            $title4 .= '<div class="col-lg-6 col-md-6 col-sm-12 col-12">';
            $title4 .= '<div class="media mb-2">';
            $title4 .= '<audio id="player' . $value["VOCAB_ID"] . '" src="' . HOST_SSO . 'attach/w17/' . $sound . '"></audio>';
            $title4 .= '<input type="image" src="assets/img/en_chitchat.jpg" onclick="audio(' . $value["VOCAB_ID"] . ');" class="mr-3 max-width-pic-today border-ra-10px">';
            $title4 .= '<div class="media-body font12px text-left">';
            $title4 .= '<div> ' . $value["VOCAB_TITLE1"] . ' </div>';
            $title4 .= '<div> ' . $value["VOCAB_READ1"] . ' </div>';
            //$title4 .= '<div class="btn-en-chitchat"> <a href="vocabulary.php" target="_blank">English Chitchat </a></div>';
            $title4 .= '<div class="btn-en-chitchat"> <a href="#" data-toggle="modal" data-target="#vocabPop" data-target="#staticBackdrop" onclick="c_chat(' . $value["VOCAB_ID"] . ')" style="cursor: pointer;">English Chit chat </a></div>';
            $title4 .= '</div>';
            $title4 .= '</div>';
            $title4 .= '</div>';

            $group3[] = array(
                "title" => $title4,
            );
        }

        $all_array = array_merge(!empty($group1) ? $group1 : array(), !empty($group2) ? $group2 : array(), !empty($group3) ? $group3 : array(), !empty($group4) ? $group4 : array());
        $array_data = array_chunk($all_array, 2);
        $array_count = count($array_data);

        $txt = '';

        for ($i = 0; $i < $array_count; $i++) {
            $txt .= '<div class="carousel-item py-1 ' . ($i == 0 ? "active" : null) . '">';
            $txt .= '<div class="row">';
            foreach ($array_data[$i] as $key => $value) {
                $txt .= $value['title'];
            }
            $txt .= '</div>';
            $txt .= '</div>';
        }

        $array_list["data"] = $txt;
        $array_list["count"] = $array_count;
        return $array_list;
    }

    //เรียกข้อมูลแสดงวันนี้มีอะไร template1
    public static function getAllmaintopIndext1($sso)
    {
        $ecard_user = $sso->getEcardUser(date('Y-m-d'));
        $calendar = calendar::getManagerCalendar();
        $calendar_e = calendar::getMoreCalendar(0, 10)["data"];
        $vocab = $sso->getChitChat()["dataAll"];
        // foreach ($ecard_user['dataAll'] as $key => $value) {
        //     $user_image = getImgbase64("profile/" . $value["USR_PICTURE"], "images/user_profile_empty.png");
        //     $group1[] = array(
        //         "image" => '<img src="' . $user_image . '" class="mr-3 max-width-pic-today border-ra-10px card-img-top">',
        //         "class" => 'hbd-t1',
        //         "icon" => '<i class="fas fa-birthday-cake"></i> สุขสันต์วันเกิด',
        //         "card-text" => '<div class="card-text">คุณ ' . $value['USR_FNAME'] . ' ' . $value['USR_LNAME'] . '</div>',
        //         "other" => '<div class="box-hbd-t1 border-ra-15-bottom">
        //             <a href="#" data-toggle="modal" data-target="#modal_birth_date"
        //                 onclick="setEventEcardId(' . $value['USR_ID'] . ',' . $_SESSION['EWT_MID'] . ')">
        //                 <div class="btn-hbd-gift-t1 txt-white">ส่งการ์ดอวยพร</div>
        //             </a>
        //         </div>'
        //     );
        // }

        if (!empty($ecard_user)) {
            $group1[] = array(
                "image" => '<img src="assets/images/ecard/ecard_ec_images_20220127105749.jpg" class="mr-3 max-width-pic-today border-ra-10px card-img-top">',
                "class" => 'hbd-t1',
                /*"icon" => '<i class="fas fa-birthday-cake"></i> ท่านที่เกิดวันนี้',*/
                "card-text" => '<div class="card-text font20px"> <span class="font15px">  อวยพรวันเกิด </span>' . $ecard_user["count"] . '<span class="font15px"> ท่าน </span> <a href="send_hbd.php"> <div class="txt-purple">ส่งการ์ดอวยพร</div> </a> </div>'
                /*"other" => '<div class="box-hbd-t1 border-ra-15-bottom">
                <a href="send_hbd.php">
                    <div class="btn-hbd-gift-t1 txt-white">ส่งการ์ดอวยพร</div>
                </a>
            </div>'*/
            );
        }

        foreach ($calendar as $key => $value) {
            $calendar_event = calendar::getEventCalendar()[$value["cat_id"]];
            if (!empty($calendar_event)) {
                $m_image = (empty($value['m_images']) ? "images/user001.png" : 'assets/images/calendar/' . $value['m_images']);
                $group2[] = array(
                    "image" => '<img src="' . $m_image . '" class="mr-3 max-width-pic-today border-ra-10px card-img-top">',
                    "class" => 'meeting-t1',
                    /*"icon" => '<i class="fas fa-user"></i> ประชุมผู้บริหาร',*/
                    "card-text" => '<div class="card-text">' . $value['m_pos'] . '</div>
                    <div class="card-text">' . $calendar_event[0]['event_time_start'] . '-' . $calendar_event[0]['event_time_end'] . '</div>
                    <div class="card-text">' . mb_strimwidth($calendar_event[0]['event_title'], 0, 50, '...') . '</div>',
                    "other" => null
                );
            }
        }


        foreach ($calendar_e as $key => $value) {
            $m_image = "images/calendar/calendar_icon.png";
            $group3[] = array(
                "image" => '<img src="' . $m_image . '" class="mr-3 max-width-pic-today border-ra-10px card-img-top">',
                "class" => 'meeting-t1',
                /*"icon" => '<i class="fas fa-user"></i> ประชุมผู้บริหาร',*/
                "card-text" => '<div class="card-text">' . $value['m_pos'] . '</div>
                    <div class="card-text">' . date("H:i", strtotime($value['event_time_start'])) . '-' . date("H:i", strtotime($value['event_time_end'])) . '</div>
                    <div class="card-text">' . $value['event_title'] . '</div>',
                "other" => null
            );
        }

        foreach ($vocab as $key => $value) {
            $sound = $sso->getSound($value["VOCAB_ID"], 'VOCAB_FILE1')["data"]["FILE_SAVE_NAME"];
            $group4[] = array(
                "image" => '<input type="image" src="assets/img/en_chitchat.jpg" onclick="audio(' . $value["VOCAB_ID"] . ');"
                class="mr-3 max-width-pic-today border-ra-10px"> 
                <audio id="player' . $value["VOCAB_ID"] . '" src="' . HOST_SSO . 'attach/w17/' . $sound . '"></audio>',
                "class" => 'en-t1',
                /*"icon" => '<i class="fas fa-comment-dots"></i> English chitchat',*/
                "card-text" => '<div class="card-text">' . $value["VOCAB_TITLE1"] . '</div>
                <div class="card-text">' . $value["VOCAB_READ1"] . '</div>
                <a href="#" data-toggle="modal" data-target="#vocabPop" data-target="#staticBackdrop" onclick="c_chat(' . $value["VOCAB_ID"] . ')" style="cursor: pointer;">
                <div class="btn-enchitchat-t1 txt-white">English chitchat</div>
                </a>',
                "other" => null
            );
        }

        $all_array = array_merge(!empty($group1) ? $group1 : array(), !empty($group2) ? $group2 : array(), !empty($group3) ? $group3 : array(), !empty($group4) ? $group4 : array());
        $array_data = array_chunk($all_array, 4);
        $array_count = count($array_data);

        $txt = '';

        for ($i = 0; $i < $array_count; $i++) {
            $txt .= '<div class="carousel-item py-1 ' . ($i == 0 ? "active" : null) . '">';
            $txt .= '<div class="row">';
            foreach ($array_data[$i] as $key => $value) {
                $txt .= '<div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-2">';
                $txt .= '<div class="font18px h-' . $value["class"] . '">';
                $txt .= $value["icon"];
                $txt .= '</div>';
                $txt .= '<div class="row box-' . $value["class"] . ' border-ra-15-top p-2 mx-0">';
                $txt .= '<div class="col-lg-3 col-md-4 col-sm-6 col-12">';
                $txt .= $value["image"];
                $txt .= '</div>';
                $txt .= '<div class="col-lg-9 col-md-8 col-sm-6 col-12">';
                $txt .= $value["card-text"];
                $txt .= '</div>';
                $txt .= '</div>';
                $txt .= $value["other"];
                $txt .= '</div>';
            }
            $txt .= '</div>';
            $txt .= '</div>';
        }

        $array_list["txt"] = $txt;
        $array_list["data"] = $array_data;
        $array_list["count"] = $array_count;
        return $array_list;
    }

    //หัวข้อในการค้นหา
    public static function getTitleTag($type = null)
    {
        $array = array(
            "1" => "ข่าวสาร/บทความ",
            "4" => "Tag"
        );

        return (!empty($type) ? $array[$type] : $array);
    }

    //เรียกข้อมูล Tag จากคำค้นหา
    public static function getTagList($type = null)
    {

        $wh = "";
        if ($type && $type != 5) {
            $wh .= " AND search_module = '$type'";
        }

        db::setDB(E_DB_NAME);
        $_sql = "SELECT search_word, COUNT(*) AS count_word FROM search_stat 
        WHERE 1=1 {$wh} GROUP BY search_word ORDER BY count_word DESC, 
        search_date DESC, search_time DESC LIMIT 0,10";
        $a_data = db::getFetchAll($_sql);
        $a_row = db::getRowCount($_sql);

        if ($a_data) {
            return $a_data;
        }
    }

    //ค้นหาข้อมูลจาก 4 Module
    public static function getTagSearch($start, $per_page, $s_search = null, $date_start = null, $date_end = null, $search_type = null)
    {
        db::setDB(E_DB_NAME);
        //เพิ่มข้อมูลการค้นหา
        if (!empty($s_search) && $start == 0) {
            $array_insert = array(
                'search_word' => $s_search,
                'search_date' => date('Y-m-d'),
                'search_ip' => getIP(),
                'search_time' => date('H:i:s'),
                'search_module' => $search_type
            );

            db::insert('search_stat', $array_insert);
        }

        //------------------------------กลุ่ม 1 ข่าว / บทความ---------------------------------//

        $wh1 = "";
        $wh2 = "";
        $wh3 = "";
        $wh4 = "";
        $wh5 = "";

        if ($date_start && $date_end) {
            $n_date_start = $date_start;
            $n_date_end = $date_end;
            $wh1 .= " AND article_list.n_date BETWEEN '$n_date_start' AND '$n_date_end'";
        }

        if ($s_search) {
            $wh1 .= " AND article_list.n_topic LIKE '%" . trim($s_search) . "%' ";
            // $wh1 .= " OR article_group.c_name LIKE '%" . trim($s_search) . "%' ";
        }

        $date_now =  date('Y-m-d');

        //เลือกข้อมูลข่าว / บทความ
        $_sql1 = "SELECT article_group.c_id, article_group.c_name, article_list.news_use, 
        article_list.n_id, article_list.link_html, article_list.n_topic, article_list.n_des, 
        article_list.n_date FROM article_group 
        LEFT JOIN article_list ON (article_group.c_id = article_list.c_id)
        WHERE (
    (
      article_list.n_approve = 'Y' 
      AND article_group.c_show_document = 'Y'
    ) 
    AND (
      (article_list.n_date = '') 
      OR ('{$date_now}')
    ) 
    {$wh1} 
  ) 
        ORDER BY article_list.n_date DESC LIMIT {$start},{$per_page}";
        $a_data1 = db::getFetchAll($_sql1);

        //นับจำนวนข่าวทั้งหมด
        $_sql1_all = "SELECT article_group.c_id FROM article_group
        LEFT JOIN article_list ON (article_group.c_id = article_list.c_id)
        WHERE (
    (
      article_list.n_approve = 'Y' 
      AND article_group.c_show_document = 'Y'
    ) 
    AND (
      (article_list.n_date = '') 
      OR ('{$date_now}')
    ) 
    {$wh1} 
  )";
        $a_row1_all = db::getRowCount($_sql1_all);

        foreach ($a_data1 as $value) {
            // $detail = article::getArticleDetail($value["n_id"], '', '', '11', '1');
            // if (strpos($detail, 'img') !== false) {
            //     $txt_detail = '<div class="chk_img">' . $detail . '</div>';
            // } else {
            //     $txt_detail = !empty($s_search) ? highlightWords($detail, $s_search) : $detail;
            // }
            $txt_detail = !empty($s_search) ? highlightWords($value['n_des'], $s_search) : $value['n_des'];

            $group1[] = array(
                "title" => !empty($s_search) ? highlightWords($value['n_topic'], $s_search) : $value['n_topic'],
                "detail" => $txt_detail,
                "group" => !empty($s_search) ? highlightWords('วันที่ ' . convDateThai($value['n_date'])["DateThai"] . ' || หมวด : ' . article::article_group_parent($value['c_id']), $s_search) : 'วันที่ ' . convDateThai($value['n_date'])["DateThai"] .' || หมวด : ' . article::article_group_parent($value['c_id']),
                "tag" => "",

                "link" => ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?c_id=" . $value['c_id'] . "&n_id=" . $value['n_id'] . " ")
            );
        }

        //--------------------------------กลุ่ม 2 คำถามที่พบบ่อย------------------------------//
        if ($date_start && $date_end) {
            $faq_date_start = convDateAd($date_start);
            $faq_date_end = convDateAd($date_end);
            $wh2 .= " AND faq.faq_date BETWEEN '$faq_date_start' AND '$faq_date_end'";
        }

        if ($s_search) {
            $wh2 .= " AND faq.fa_name LIKE '%" . trim($s_search) . "%' ";
            $wh2 .= " OR faq_category.faq_cate_title LIKE '%" . trim($s_search) . "%' ";
        }

        //เลือกข้อมูลคำถามที่พบบ่อย
        $_sql2 = "SELECT faq_category.faq_cate_id, faq_category.faq_cate_title, faq.fa_name, faq.fa_detail
        FROM faq_category INNER JOIN faq ON (faq_category.faq_cate_id = faq.f_sub_id)
		WHERE faq_category.faq_cate_status = 'Y' AND faq.faq_use = 'Y' {$wh2} 
		ORDER BY CASE WHEN faq.faq_top = 'Y' THEN 0 ELSE 1 END,
		faq_category.faq_cate_id DESC, faq.faq_date DESC 
		LIMIT {$start},{$per_page}";
        $a_data2 = db::getFetchAll($_sql2);

        //นับจำนวนคำถามที่พบบ่อยทั้งหมด
        $_sql2_all = "SELECT faq.fa_id FROM faq_category 
		INNER JOIN faq ON (faq_category.faq_cate_id = faq.f_sub_id)
		WHERE faq_category.faq_cate_status = 'Y' AND faq.faq_use = 'Y' {$wh2} ";
        $a_row2_all = db::getRowCount($_sql2_all);

        foreach ($a_data2 as $value) {
            $group2[] = array(
                "title" => !empty($s_search) ? highlightWords($value['fa_name'], $s_search) : $value['fa_name'],
                "detail" => !empty($s_search) ? highlightWords($value['fa_detail'], $s_search) : $value['fa_detail'],
                "group" => !empty($s_search) ? highlightWords($value['faq_cate_title'], $s_search) : $value['faq_cate_title'],
                "tag" => "",
                "link" => "more_faq.php?faq_cate_id=" . $value["faq_cate_id"]
            );
        }

        //---------------------------กลุ่ม 3 เว็บบอร์ด----------------------------//
        if ($date_start && $date_end) {
            $t_date_start = convDateAd($date_start);
            $t_date_end = convDateAd($date_end);
            $wh3 .= " AND w_question.t_date BETWEEN '$t_date_start' AND '$t_date_end'";
        }

        if ($s_search) {
            $wh3 .= " AND w_question.t_name LIKE '%" . trim($s_search) . "%' ";
            $wh3 .= " OR w_cate.c_name LIKE '%" . trim($s_search) . "%' ";
        }

        //เรียกข้อมูลเว็บบอร์ด
        $_sql3 = "SELECT w_cate.c_name, w_question.t_id, w_question.t_name, w_question.t_detail
        FROM w_cate INNER JOIN w_question ON (w_cate.c_id = w_question.c_id)
        WHERE w_question.s_id = 1 {$wh3} ORDER BY w_question.t_date DESC, w_question.t_time DESC 
        LIMIT {$start},{$per_page}";

        $a_data3 = db::getFetchAll($_sql3);

        //นับจำนวนเว็บบอร์ดทั้งหมด
        $_sql3_all = "SELECT w_question.t_id FROM w_cate INNER JOIN w_question ON (w_cate.c_id = w_question.c_id)
        WHERE w_question.s_id = 1 {$wh3}";
        $a_row3_all = db::getRowCount($_sql3_all);

        foreach ($a_data3 as $value) {
            $group3[] = array(
                "title" => !empty($s_search) ? highlightWords($value['t_name'], $s_search) : $value['t_name'],
                "detail" => !empty($s_search) ? highlightWords($value['t_detail'], $s_search) : $value['t_detail'],
                "group" => !empty($s_search) ? highlightWords($value['c_name'], $s_search) : $value['c_name'],
                "tag" => "",
                "link" => "webboard_answer.php?t_id=" . $value["t_id"]
            );
        }

        //-----------------------------กลุ่ม 4 Tag Article------------------------------------//

        if ($date_start && $date_end) {
            $n_date_start = convDateAd($date_start);
            $n_date_end = convDateAd($date_end);
            $wh4 .= " AND article_list.n_date BETWEEN '$n_date_start' AND '$n_date_end'";
        }

        if ($s_search) {
            $wh4 .= " AND article_taglist.tag_name LIKE '%" . trim($s_search) . "' ";
        }

        $date_now =  date('Y-m-d');

        //เลือกข้อมูลข่าว / บทความ
        $_sql4 = "SELECT article_group.c_id, article_group.c_name, 
        article_list.news_use, article_list.n_id, article_list.link_html, 
        article_list.n_topic, article_taglist.tag_name FROM article_group 
        INNER JOIN article_list ON (article_group.c_id = article_list.c_id)
        INNER JOIN article_taglist ON (article_list.n_id = article_taglist.n_id)
        WHERE article_list.n_approve = 'Y' {$wh4} AND article_group.c_show_document = 'Y'
        AND ((article_list.n_date_start = '' AND article_list.n_date_end = '')
        OR ('{$date_now}' between article_list.n_date_start AND article_list.n_date_end))  
        ORDER BY article_list.n_date DESC LIMIT {$start},{$per_page}";
        $a_data4 = db::getFetchAll($_sql4);

        //นับจำนวนข่าวทั้งหมด
        $_sql4_all = "SELECT article_group.c_id FROM article_group
        INNER JOIN article_list ON (article_group.c_id = article_list.c_id)
        INNER JOIN article_taglist ON (article_list.n_id = article_taglist.n_id)
        WHERE article_list.n_approve = 'Y' {$wh4} AND article_group.c_show_document = 'Y'
        AND ((article_list.n_date_start = '' AND article_list.n_date_end = '')
        OR ('{$date_now}' between article_list.n_date_start AND article_list.n_date_end)) ";
        $a_row4_all = db::getRowCount($_sql4_all);

        foreach ($a_data4 as $value) {
            //     $txt_tag = '<span class="badge badge-search">
            //     <a href="search.php?s_search=' . $value["tag_name"] . '&search_type=4" title="' . $value["tag_name"] . '">
            //     ' . $value["tag_name"] . '
            //     </a>
            //    </span> ';

            $group4[] = array(
                "title" => !empty($s_search) ? highlightWords($value['n_topic'], $s_search) : $value['n_topic'],
                "detail" => "",
                "group" => !empty($s_search) ? highlightWords($value['c_name'], $s_search) : $value['c_name'],
                "tag" => self::getArticleTag($value["c_id"], $value["n_id"], $value['news_use'], $value['link_html'], $s_search),
                "link" => ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?c_id=" . $value['c_id'] . "&n_id=" . $value['n_id'] . " ")
            );
        }

        //-----------------------------กลุ่ม 5 Tag Search------------------------------------//
        if ($date_start && $date_end) {
            $search_date_start = $date_start;
            $search_date_end = $date_end;
            $wh5 .= " AND search_date BETWEEN '$search_date_start' AND '$search_date_end'";
        }

        if ($s_search) {
            $wh5 .= " AND search_word LIKE '%" . trim($s_search) . "%' ";
        }

        //เรียกข้อมูล Tag Search
        $_sql5 = "SELECT search_word, search_module, COUNT(*) AS count_word FROM search_stat
        WHERE 1=1 {$wh5} GROUP BY search_word ORDER BY count_word DESC, 
        search_date DESC, search_time DESC LIMIT {$start},{$per_page}";
        $a_data5 = db::getFetchAll($_sql5);

        //นับจำนวน Tag Search ทั้งหมด
        $_sql5_all = "SELECT search_id FROM search_stat
        WHERE 1=1 {$wh5} GROUP BY search_word";
        $a_row5_all = db::getRowCount($_sql5_all);

        foreach ($a_data5 as $value) {
            $group5[] = array(
                "title" => !empty($s_search) ? highlightWords($value['search_word'], $s_search) : $value['search_word'],
                "detail" => " ค้นหา " . $value["count_word"] . " ครั้ง",
                "group" => "",
                "tag" => "",
                "link" => ""
            );
        }

        //----------------------------------------------------------------------------------------------//

        if (!empty($s_search) || !empty($date_start) || !empty($date_end)) {
            switch ($search_type) {
                case '1':
                    $data = array(
                        "data" => $group1,
                        "countAll" => $a_row1_all,
                    );
                    break;
                case '2':
                    $data = array(
                        "data" => $group2,
                        "countAll" => $a_row2_all,
                    );
                    break;
                case '3':
                    $data = array(
                        "data" => $group3,
                        "countAll" => $a_row3_all,
                    );
                    break;
                case '4':
                    $data = array(
                        "data" => $group4,
                        "countAll" => $a_row4_all,
                    );
                    break;
                case '5':
                    $data = array(
                        "data" => $group5,
                        "countAll" => $a_row5_all,
                    );
                    break;
            }
        }

        return $data;
    }

    //เรียกข้อมูล Tag จากข่าวที่ค้นหา
    public static function getArticleTag($c_id = null, $n_id = null, $news_use = null, $link_html = null, $s_search = null)
    {
        $wh = "";

        if ($n_id) {
            $wh .= " AND n_id = '$n_id' ";
        }

        db::setDB(E_DB_NAME);
        $_sql_tag = "SELECT tag_name FROM article_taglist 
        WHERE 1=1 {$wh} GROUP BY tag_name ORDER BY n_id DESC";
        $a_data_tag = db::getFetchAll($_sql_tag);

        $txt = '';
        foreach ($a_data_tag as $value) {
            $link = ($news_use == 1 ? $link_html : "news_view.php?c_id=" . $c_id . "&n_id=" . $n_id . " ");
            $txt .= '<span class="badge badge-search">';
            $txt .= '<a href="' . $link . '" title="' . $value["tag_name"] . '" target="_blank">';
            $txt .= !empty($s_search) ? highlightWords($value['tag_name'], $s_search) : $value['tag_name'];
            $txt .= '</a>';
            $txt .= '</span> ';
        }

        return $txt;
    }

    //เก็บจำนวนผู้เข้าชม
    public static function getVisitors()
    {
        $date = date("Y-m-d");

        db::setDB(E_DB_NAME);
        $chk_sql = "SELECT stat_user_id FROM stat_count WHERE stat_user_id = {$_SESSION['EWT_MID']} AND DATE(stat_datetime) = '" . $date . "'";
        $chk_count = db::getRowCount($chk_sql);

        if ($chk_count == 0) {
            $array_insert = array(
                'stat_ip' => getIP(),
                'stat_user_id' => $_SESSION['EWT_MID'],
                'stat_datetime' => date('Y-m-d H:i'),
            );

            db::insert('stat_count', $array_insert);
        }

        $_sql = "SELECT stat_user_id FROM stat_count";
        // $_sql = "SELECT sv_id FROM stat_visitor";
        $count = db::getRowCount($_sql);

        return sprintf('%06s', $count);
    }
}
