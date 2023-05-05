

<!-- The social media icon bar -->
<div id="mySidebar" class="sidebar">
    <a class="btn closebtn" href="javascript:void(0)" onclick="closeNav()" role="button"><em class="far fa-window-close"></em> ปิด</a>

    <div class="row w-100 mb-2 dis-mobile">
      <div class="col-lg-2 col-md-2 col-sm-4 col-4 pr-0 pl-0 text-right">
        <img src="assets/img/user-pic.jpg" alt="user" title="user" class="rounded-circle max-width-user2 shadow-user">
      </div>
      <div class="col-lg-10 col-md-10 col-sm-8 col-8 text-left">
        <div class="day-user mt-1 txt-yellow">
			สวัสดีตอนเช้า!
        </div>	
        <div class="name-user-login2">
			คุณลลิษา มโนบาล
        </div>
		<div class="font10px text-white mt-1">
			วันจันทร์ 23 ธ.ค. 2564 ,13.30 น.
		</div>
		<div class="font10px txt-yellow mt-1">
			<i class="fas fa-exclamation-circle"></i> ถึงเวลาอัพเดทข้อมูลส่วนตัวแล้วนะคะ
		</div>
      </div>
    </div>
   <div class="menu-title"><h5>เมนูหลัก</h5> </div>
      <div class="menu-list">
          <a href="#">
            หนังสือเวียน
          </a>
          <a href="#">
            ประชาสัมพันธ์
          </a>
          <a href="#">ข้อมูลเผยแพร่</a>
          <a href="#">วาระงานผู้บริหาร</a>
          
          <!-- Open Menu หลัก เลเวลที่ 1 คลิกแสดงเมนูย่อย -->
          <a title="ชื่อเมนูตรงนี้" data-toggle="collapse" href="#collapseMenu5" role="button" aria-expanded="false" aria-controls="collapseMenu5">
            สำนักกอง <i class="fas fa-caret-down"></i>
          </a>
          <!-- Close Menu หลัก เลเวลที่ 1 คลิกแสดงเมนูย่อย -->

          <!-- Open Menu เมนูย่อย -->
            <div class="collapse" id="collapseMenu5">
              <div class="card card-body">
                <ul>
                  <!-- Open เมนูย่อยเลเวลที่ 2 -->
                  <li><a href="#" class="pl-0 text-dark"> กองผู้เชี่ยวชาญ </a></li>
                  <!-- Close เมนูย่อยเลเวลที่ 2 -->

                  <!-- Open เมนูย่อยเลเวลที่ 3 -->  
                  <ul>
                      <li><a href="#" class="pl-0 text-dark"> กองผู้เชี่ยวชาญ ย่อย1 </a></li>
                      <li><a href="#" class="pl-0 text-dark"> กองผู้เชี่ยวชาญ ย่อย2 </a></li>
                      <li><a href="#" class="pl-0 text-dark"> กองผู้เชี่ยวชาญ ย่อย3 </a></li>
                    </ul>
                  <!-- Close เมนูย่อยเลเวลที่ 3 -->

                  <li><a href="#" class="pl-0 text-dark"> กองการเจ้าหน้าที่ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> กองกฏหมายและระเบียบ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> กองคลัง </a></li>
                  <li><a href="#" class="pl-0 text-dark"> กลุ่มพัฒนาระบบบริหาร </a></li>
                  <li><a href="#" class="pl-0 text-dark"> หน่วยตรวจสอบภายใน </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สำนักพัฒนานโยบายและแผนการประชาสัมพันธ์ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สำนักส่งเสริมและพัฒนางานเทคนิค </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สำนักพัฒนาการประชาสัมพันธ์ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สำนักงานเลขานุการกรม </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สถานีวิทยุกระจายเสียงแห่งประเทศไทย </a></li>

                  <li><a href="#" class="pl-0 text-dark"> ศูนย์เทคโนโลยีสารสนเทศการประชาสัมพันธ์ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สำนักการประชาสัมพันธ์ต่างประเทศ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สำนักข่าว </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สถาบันการประชาสัมพันธ์ </a></li>
                  <li><a href="#" class="pl-0 text-dark"> กลุ่มงานคุ้มครองจริยธรรม </a></li>
                  <li><a href="#" class="pl-0 text-dark"> สหกรณ์ออมทรัพย์กรมประชาสัมพันธ์ </a></li>
                </ul>
              </div>
            </div>
          <!-- Close Menu เมนูย่อย --> 
          <a href="#">บริการส่วนกลาง</a>
          <a href="#">ติดต่อกรม</a>
      </div>
</div>

<script>
/* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidebar").style.width = "300px";
  document.getElementById("main").style.marginLeft = "300px";
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}

</script>


<style>
/* The sidebar menu */
.sidebar {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1200; /* Stay on top */
  top: 0;
  left: 0;
  background-color: #155094; /* Blue */
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
    box-shadow: 0px 0px 20px 1px #393a73;

}
/* The menu links */
.menu-list a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    color: #fff;
    display: block;
    transition: 0.3s;
    border-bottom: 1px solid #CCCCCC;   
    }
/* The sidebar links */
.sidebar a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  color: #fff;
  display: block;
  transition: 0.3s;
}

/* When you mouse over the navigation links, change their color */
.sidebar a:hover {
  color: #fdd80e;
}

/* Position and style the close button (top right corner) */
.sidebar .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 20px;
    font-weight: 600;
  margin-left: 0px;
}

/* The button used to open the sidebar */
.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color:#260273;
  color: white;
  padding: 10px 15px;
  border: none;
    top: 30px;
    right: 0px;
    position: fixed;
    z-index: 1300;
    border-radius: 5px 0px 0px 5px;
        font-size: 16px;
    font-weight: 600;
   box-shadow: 0px 0px 20px 0px #110628;
    }

.openbtn:hover {
  background-color: #444;
}
    .menu-title{
        padding: 15px;
        color: #fdd80e;
        
    }
/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
  transition: margin-left .5s; /* If you want a transition effect */
  padding: 0px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>