

<!-- The social media icon bar -->
<div id="mySidebar" class="sidebar">
    <a class="btn closebtn" href="javascript:void(0)" onclick="closeNav()" role="button"><em class="far fa-window-close"></em> ปิด</a>

   <div class="menu-title"><h5>เมนูหน่วยงาน</h5> </div>
    <div class="menu-list">
      <a href="#" title="ชื่อเมนูตรงนี้">เว็บไซต์กองการเจ้าหน้าที่</a>
      <a href="#">เว็บไซต์ กลุ่มงานคุ้มครองจริยธรรม</a>
      <a href="#">คุย เรื่อง คน</a>
      <a href="#">ข้อมูลบุคลากร</a>
        <a href="#">ลาออนไลน์และการมาปฏิบัติงาน</a>
        <a href="#">กฎ ระเบียบ หลักเกณฑ์</a>
        <a href="#">ขั้นตอนการทำบัตรข้าราชการ</a>
        <a href="#">สื่อเผยแพร่</a>
        <a href="#">การประเมินผลการปฎิบัติราชการ</a>
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
  background-color: #39418a; /* Black*/
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