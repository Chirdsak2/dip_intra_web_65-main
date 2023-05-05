<?php
$page_name = $_GET['page_name']; //ชื่อหน้า
$page_data = $_GET['page_data']; //ข้อมูลของหน้าที่ต้องการส่งค่าเพิ่ม
$page = isset($_GET["page"]) ? $_GET["page"] : 1; //หน้าปัจจุบันที่เลือกข้อมูล
$per_page = $_GET['per_page']; //จำนวนข้อมูลที่ต้องการแบ่งต่อหน้า
$total_page = $_GET['total_page']; //จำนวนข้อมูลทั้งหมด
$prev = $page - 1; //ก่อนหน้า
$next = $page + 1; //ถัดไป

$txt = '';
if ($page >= 2) {
    $txt .= '<a href="'.$page_name.'?page='.$prev.''.(!empty($page_data) ? "&".$page_data : null).'">';
    $txt .= '<i class="fa fa-thin fa-chevron-left"></i>';
    $txt .= '</a>';
}

for ($i = 1; $i <= $total_page; $i++) {
    if ($i <= 5 && $total_page > 1) {
        $txt .= '<a class="' . ($i == $page ? "is-active" : "") . '" href="'.$page_name.'?page='.$i.''.(!empty($page_data) ? "&".$page_data : null).'">';
        $txt .= '<li>' . $i . '</li>';
        $txt .= '</a>';
    }
}

if ($page > 5 && $page != $total_page) {
    $txt .= '<a class="' . ($page == $total_page ? "" : "is-active") . '" href="'.$page_name.'?page='.$page.''.(!empty($page_data) ? "&".$page_data : null).'">';
    $txt .= '<li>' . $page . '</li>';
    $txt .= '</a>';
}

if ($total_page > $per_page) {
    $txt .= '<a href="#"><li>...</li></a>';

    $txt .= '<a class="' . ($page == $total_page ? "is-active" : "") . '" href="'.$page_name.'?page='.$total_page.''.(!empty($page_data) ? "&".$page_data : null).'">';
    $txt .= '<li>' . $total_page . '</li>';
    $txt .= '</a>';
}

if ($page < $total_page) {
    $txt .= '<a href="'.$page_name.'?page='.$next.''.(!empty($page_data) ? "&".$page_data : null).'">';
    $txt .= '<li><i class="fa fa-thin fa-chevron-right"></i></li>';
    $txt .= '</a>';
}

echo $txt;
exit();