<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php include('org_menu.php'); ?>
<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$vdo_group=$_GET['id'];
$wh = "";
if ($vdo_group) {
    $wh .= " AND vdo_group = '{$vdo_group}'";
}
$per_page ='9'; 
$_sql = "SELECT a.*, b.vdog_id FROM " . E_DB_NAME . ".vdo_list a
    INNER JOIN " . E_DB_NAME . ".vdo_group b ON (a.vdo_group = b.vdog_id) 
    WHERE  1=1 {$wh}
    ORDER BY a.vdo_createdate DESC 
    LIMIT {$start_vdo},{$per_page_vdo}";

$a_row = db::getRowCount($_sql);
$a_data = db::getFetchAll($_sql);

//นับจำนวนข่าวทั้งหมด
$_sql_all = "SELECT a.vdo_id FROM " . E_DB_NAME . ".vdo_list a
INNER JOIN " . E_DB_NAME . ".vdo_group b ON (a.vdo_group = b.vdog_id) 
WHERE  1=1 {$wh}";

$a_row_all = db::getRowCount($_sql_all);

$total_page = ceil($a_row_all / $per_page);

//var_dump($_sql);

?>

<style> 
/* 
 * All Style
 */


 .page-title h1 {
  margin-top: 70px;
  margin-bottom: 70px;
  color: #485a64;
  font-weight: bold;
}

.container.spc{
  margin-bottom: 20px
}

/* 
 * Product Page 1
 */
.hovereffect {
  width: 100%;
  /*height: 100%;*/
  float: left;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: default;
}

.hovereffect .overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  top: 0;
  left: 0;
}

.hovereffect img {
  display: block;
  position: relative;
  -webkit-transform: scale(1.1);
  -ms-transform: scale(1.1);
  transform: scale(1.1);
  -webkit-transition: all 0.35s;
  transition: all 0.35s;
}

.hovereffect:hover img {
  -webkit-transform: scale(1);
  -ms-transform: scale(1);
  transform: scale(1);
  filter: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="filter"><feComponentTransfer color-interpolation-filters="sRGB"><feFuncR type="linear" slope="0.7" /><feFuncG type="linear" slope="0.7" /><feFuncB type="linear" slope="0.7" /></feComponentTransfer></filter></svg>#filter');
  filter: brightness(0.7);
  -webkit-filter: brightness(0.7);
}

.hovereffect h2 {
  text-transform: uppercase;
  color: #fff;
  text-align: center;
  font-size: 17px;
  padding: 10px;
  width: 100%;
  color: black;
  font-weight: bold
}

.hovereffect:hover h2 {
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transform: translate3d(-50%,-50%,0) scale3d(0.8,0.8,1);
  transform: translate3d(-50%,-50%,0) scale3d(0.8,0.8,1);
}

.hovereffect h3 {
  position: absolute;
  bottom: 5px;
  right: -35px;
  text-transform: uppercase;
  color: #fff;
  font-size: 17px;
  color: black;
  font-weight: bold;
  text-decoration: none;
  padding: 7px 14px;
  border: 1px solid #fff;
  margin: 50px 0 0;
  border-radius: 0;
  background-color: transparent;
}

.hovereffect:hover h3 {
  position: absolute;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transform: translate3d(-50%,-50%,0) scale3d(0.8,0.8,1);
  transform: translate3d(-50%,-50%,0) scale3d(0.8,0.8,1);
}

.hovereffect a.info {
  display: inline-block;
  text-decoration: none;
  padding: 7px 14px;
  text-transform: uppercase;
  color: #fff;
  border: 1px solid #fff;
  margin: 50px 0 0 0;
  background-color: transparent;
}

.hovereffect a.info:hover {
  box-shadow: 0 0 5px #fff;
}

.hovereffect .rotate {
  -webkit-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  transform: rotate(-45deg);
  width: 100%;
  height: 100%;
  position: absolute;
}

.hovereffect hr {
  width: 50%;
  opacity: 0;
  filter: alpha(opacity=0);
}

.hovereffect  hr:nth-child(2) {
  -webkit-transform: translate3d(-50%,-50%,0) rotate(0deg) scale3d(0,0,1);
  transform: translate3d(-50%,-50%,0) rotate(0deg) scale3d(0,0,1);
}

.hovereffect  hr:nth-child(3) {
  -webkit-transform: translate3d(-50%,-50%,0) rotate(90deg) scale3d(0,0,1);
  transform: translate3d(-50%,-50%,0) rotate(90deg) scale3d(0,0,1);
}

.hovereffect h2, .hovereffect hr{
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(-50%,-50%,0);
  transform: translate3d(-50%,-50%,0);
  -webkit-transform-origin: 50%;
  -ms-transform-origin: 50%;
  transform-origin: 50%;
  background-color: transparent;
  margin: 0px;
}

.hovereffect h3 {
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(-50%,-50%,0);
  transform: translate3d(-50%,-50%,0);
  -webkit-transform-origin: 50%;
  -ms-transform-origin: 50%;
  transform-origin: 50%;
  background-color: transparent;
  margin: 0px;
}

.group1, .group2 {
  left: 50%;
  position: absolute;
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(-50%,-50%,0);
  transform: translate3d(-50%,-50%,0);
  -webkit-transform-origin: 50%;
  -ms-transform-origin: 50%;
  transform-origin: 50%;
  background-color: transparent;
  margin: 0px;
  padding: 0px;
}

.group1 {
  top: 40%;
}

.group2 {
  top: 60%;
}

.hovereffect p {
  width: 30%;
  text-transform: none;
  font-size: 15px;
  line-height: 2;
}

.hovereffect p a {
  color: #fff;
}

.hovereffect p a:hover,
.hovereffect p a:focus {
  opacity: 0.6;
  filter: alpha(opacity=60);
}

.hovereffect  a i {
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  padding: 10px;
  font-size: 20px;
}

.group1 a:first-child i {
  -webkit-transform: translate3d(-60px,-60px,0) rotate(45deg) scale(2);
  transform: translate3d(-60px,-60px,0) rotate(45deg) scale(2);
}

.group1 a:nth-child(2) i {
  -webkit-transform: translate3d(60px,-60px,0) rotate(45deg) scale(2);
  transform: translate3d(60px,-60px,0)  rotate(45deg) scale(2);
}

.group2 a:first-child i {
  -webkit-transform: translate3d(-60px,60px,0) rotate(45deg) scale(2);
  transform: translate3d(-60px,60px,0) rotate(45deg) scale(2);
}

.group2 a:nth-child(2) i {
  -webkit-transform: translate3d(60px,60px,0)  rotate(45deg) scale(2);
  transform: translate3d(60px,60px,0)  rotate(45deg) scale(2);
}

.hovereffect:hover hr:nth-child(2) {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(-50%,-50%,0) rotate(0deg) scale3d(1,1,1);
  transform: translate3d(-50%,-50%,0) rotate(0deg) scale3d(1,1,1);
}

.hovereffect:hover hr:nth-child(3) {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(-50%,-50%,0) rotate(90deg) scale3d(1,1,1);
  transform: translate3d(-50%,-50%,0) rotate(90deg) scale3d(1,1,1);
}

.hovereffect:hover .group1 i:empty, .hovereffect:hover .group2 i:empty {
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0) rotate(45deg) scale(1);
  opacity: 1;
  filter: alpha(opacity=100);
}
.space{
  margin: 20px 0px 5px 0px
}

/* 
 * Product Page 2
 */
.hovereffect-2 {
width:100%;
/*height:100%;*/
float:left;
overflow:hidden;
position:relative;
text-align:center;
cursor:default;
}

.hovereffect-2 .overlay {
width:100%;
height:100%;
position:absolute;
overflow:hidden;
top:0;
left:0;
opacity:0;
background-color:rgba(0,0,0,0.5);
-webkit-transition:all .4s ease-in-out;
transition:all .4s ease-in-out
}

.hovereffect-2 img {
display:block;
position:relative;
-webkit-transition:all .4s linear;
transition:all .4s linear;
}

.hovereffect-2 h2 {
text-transform:uppercase;
color:#fff;
text-align:center;
position:relative;
font-size:17px;
background:rgba(0,0,0,0.6);
-webkit-transform:translatey(-100px);
-ms-transform:translatey(-100px);
transform:translatey(-100px);
-webkit-transition:all .2s ease-in-out;
transition:all .2s ease-in-out;
padding:10px;
}

.hovereffect-2 a.info {
text-decoration:none;
display:inline-block;
text-transform:uppercase;
color:#fff;
border:1px solid #fff;
background-color:transparent;
opacity:0;
filter:alpha(opacity=0);
-webkit-transition:all .2s ease-in-out;
transition:all .2s ease-in-out;
margin:50px 0 0;
padding:7px 14px;
}

.hovereffect-2 a.info:hover {
box-shadow:0 0 5px #fff;
}

.hovereffect-2:hover img {
-ms-transform:scale(1.2);
-webkit-transform:scale(1.2);
transform:scale(1.2);
}

.hovereffect-2:hover .overlay {
opacity:1;
filter:alpha(opacity=100);
}

.hovereffect-2:hover h2,.hovereffect-2:hover a.info {
opacity:1;
filter:alpha(opacity=100);
-ms-transform:translatey(0);
-webkit-transform:translatey(0);
transform:translatey(0);
}

.hovereffect-2:hover a.info {
-webkit-transition-delay:.2s;
transition-delay:.2s;
}



/* 
 * Product Page 3 
 */


.product-container {
  background-color: #fff;
  height: 300px;
  overflow: hidden;
  position: relative;
  margin-bottom: 20px;
}

.tag-sale {
  background-color: #4fdaa4;
  width: 86px;
  height: 98px;
  position: absolute;
  color: #fff;
  right: -41px;
  z-index: 9;
  top: -44px;
  transform: rotate(137deg);
}

.tag-sale::before {
  content: "SALE";
  color: #fff;
  font-weight: bold;
  display: block;
  transform-origin: top center;
  transform: rotate(222.5deg) translateX(-28px) translateY(-37px);
}

.product-description {
  background-color: #F7F7F7;
  border-top: 1px solid #EFEFEF;
  padding: 10px 20px;
  color: #797979;
}

.product-image {
  /*padding: 20px;*/
  height: 200px;
  position: relative;
  overflow: hidden;
  transition: 1s;
}

.product-link {
  position: absolute;
  background: #fff;
  width: 100px;
  height: 100px;
  color: #4FDAA4;
  border-radius: 50%;
  font-size: 25px;
  text-align: center;
  padding: 35px 0;
  line-height: 25px;
  left: calc(50% - 50px);
  top: calc(50% - 50px);
  opacity: 0;
  transition: 1s;
  font-style: italic;
}

.product-link:hover {
  text-decoration: none;
  color: #4FDAA4;
}


.hover-link {
  background-color: #82288c;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  transition: 0.5s;
}

.product-image img {
  width: 100%;
}

.product-description h1 {
  font-size: 23px;
  margin-bottom: 5px;
  margin-top: 0;
  display: inline-block;
  width: 78%;
}

.product-description p {
  color: #5b5aa8;
}

.product-description .price {
  display: inline-block;
  width: 20%;
  font-size: 23px;
  text-align: right;
  font-weight: bold;
  color: #2DD493;
  margin-bottom: 5px;
}

.product-option {
  border-top: 1px solid #D2D2D2;
}

.product-option h3 {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 3px;
}

.product-option .product-color ul {
  list-style-type: none;
  padding: 0;
}

.product-option .product-color li {
  display: inline-block;
  width: 15px;
  height: 15px;
}

.product-color li.red {
  background-color: #F75375;
}
.product-color li.blue {
  background-color: #53A0F7;
}
.product-color li.green {
  background-color: #59CFAF;
}
.product-color li.gray {
  background-color: #C7C7C7;
}
.product-color li.black {
  background-color: #4E5156;
}
.product-color li.dark-blue {
  background-color: #2060AF;
}

.product-container:hover {
  box-shadow: 0px 10px 25px -2px rgba(0,0,0,0.36);
}

.product-container:hover .product-image {
  height: 240px;
  transition: 1s;
  /*padding: 10px;*/
}
.product-container:hover .product-option {
  display: block;
}
.product-container:hover .hover-link {
  opacity: 0.5;
}
.product-container:hover .product-link {
  opacity: 1;
}

.product-link:hover {
  -webkit-animation: hovering 1000ms linear both;
  animation: hovering 1000ms linear both;
}



/* 
 * Product Page 4
 */

@import url(https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
.wrp-product-2 {
  color: #000000;
  font-size: 16px;

}


.wrp-product-2:hover{
  box-shadow: 0px 10px 25px -2px rgba(0,0,0,0.36);

}

.wrp-product-2 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.wrp-product-2 img {
  max-width: 100%;
  vertical-align: top;
  position: relative;
}
.wrp-product-2 .add-to-cart {
  position: absolute;
  top: 0;
  right: 0;
  padding-right: 10px;
  color: #ffffff;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.9em;
  opacity: 0;
  background-color: #409ad5;
  -webkit-transform: rotateX(-90deg);
  transform: rotateX(-90deg);
  -webkit-transform-origin: 100% 0;
  -ms-transform-origin: 100% 0;
  transform-origin: 100% 0;
  padding: 5px
}
.wrp-product-2 .add-to-cart i {
  display: inline-block;
  margin-right: 10px;
  width: 40px;
  line-height: 40px;
  text-align: center;
  background-color: #164666;
  color: #ffffff;
  font-size: 1.4em;
}
.wrp-product-2 .wrp-row {
  padding: 20px;
}
.wrp-product-2 h3,
.wrp-product-2 p {
  margin: 0;
}
.wrp-product-2 h3 {
  font-size: 1.5em;
  font-weight: 700;
  margin-bottom: 10px;
  text-transform: uppercase;
}
.wrp-product-2 p {
  font-size: 0.9em;
  letter-spacing: 1px;
  font-weight: 400;
}
.wrp-product-2 .price {
  font-weight: 500;
  font-size: 1.5em;
  line-height: 48px;
  letter-spacing: 1px;
}
.wrp-product-2 .price s {
  margin-right: 5px;
  opacity: 0.5;
  font-size: 0.9em;
}
.wrp-product-2 a {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}
.wrp-product-2:hover .add-to-cart {
  opacity: 1;
  -webkit-transform: rotateX(0deg);
  transform: rotateX(0deg);
}
.wrp-product-2:hover .add-to-cart i{
  background-color: #2980b9;
}

</style>



<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<div id="main" style="<?php echo $org_page[0]["c_show_org_chk"] == "Y" ? "margin-left: 300px;" : null; ?>">


    <div class="container-fluid header--bg text-center mt-3">
        <div class="container py-5">
            <h3 class="article--topic">หมวดวิดีโอ</h3>
            <small class="article_nvt">
                <a href="index.php" title="หน้าหลัก" class="article_nvt">หน้าหลัก </a>
                &gt;&gt; <a href="#" class="article_nvt"> หมวดวิดีโอ</a>
            </small>
        </div>
    </div>

    <!-- 1. แสดง 3  รายการต่อ 1 แถว  2. แสดงหน้าละ 9 รายการ -->
    

<div class="container">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_1.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_2.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_3.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_4.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_5.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_6.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_7.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_8.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_9.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_10.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_11.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="product-container">
                    <div class="product-image"> 
                        <span class="hover-link"></span>
                        <a href="#" class="product-link">ดูทั้งหมด</a>
                        <img class="img-responsive" src="images/cover_vdo/cover_12.png" alt="Lorem Ipsum">
                    </div>
                    <div class="product-description">
                        <div class="product-label">
                            <div class="product-name">
                                <p>Move Forward To Success เดินหน้าสู่ความความสำเร็จ</ย>
                            </div>
                        </div>
                        <div class="product-option">
                            <div class="product-size">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>





        <!-- Start แสดงการตัดหน้าเพจ -->
        <?php echo pagination_ewt('more_vdo.php', '' , $page, $per_page_vdo,$a_row_all); ?>
        <!-- End แสดงการตัดหน้าเพจ-->
    </div>
</div>





<script type="text/javascript">
    function clearText(text) {
        $('#' + text).val('');
    }

    function tabActive(key, c_id) {
        $.post("ajax/tab_article_active.ajax.php", {
            key: key,
            c_id: c_id
        });
    }

    $("#btn_search").click(function() {
        window.location.href = 'more_news.php?c_id=' + <?php echo $c_id; ?> +
            '&s_search=' + $('#s_search').val() +
            '&n_date_start=' + $('#n_date_start').val() +
            '&n_date_end=' + $('#n_date_end').val() +
            '&org_name=' + $('#org_name').val();
        '&c_org=' + '<?php echo $c_org; ?>';
    });
</script>

<?php include('component/news_count.php'); ?>
<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>