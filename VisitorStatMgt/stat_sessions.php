<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-green-light" title="ผู้ใช้ที่เริ่มใช้อย่างน้อย 1 เซซชันในช่วงวันที่ที่กำหนด" data-toggle="tooltip" data-placement="bottom">
<!--Users Who have initiated at lest one session during the date range.    -->
<div class="card-body">
<i class="icon fas fa-globe-americas fa-4x"></i>
    <div class="content">
      <div class="title"><h4>Users<!--ผู้เข้าชมเว็บไซต์วันนี้--></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo count_users($con);?></span></div>
	   <div class="title"><span>ผู้เข้าชมเว็บไซต์อย่างน้อย 1 เซซชันในช่วงวันที่ที่กำหนด</span></div>
    </div>
	
  </div>
</a>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-blue-light" title="จำนวนผู้ใช้ครั้งแรกระหว่างช่วงวันที่ที่เลือก" data-toggle="tooltip" data-placement="bottom">
<!-- The number of first-time users during the selected date range.    -->
<div class="card-body">
<i class="icon fas fa-user-plus fa-4x"></i>
    <div class="content">
      <div class="title"><h4>New Users <!--ู้เข้าชมเว็บไซต์ใหม่--></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo count_new_users($con);?></span></div>
	    <div class="title"><span>จำนวนผู้เข้าชมเว็บไซต์ครั้งแรกระหว่างช่วงวันที่ที่เลือก</span></div>
    </div>
  </div>
</a>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-yellow-light" title="จำนวนรวมของเซสชันภายในช่วงวันที่ " data-toggle="tooltip" data-placement="bottom">
<!--Total number Sessions with in the date range. A session is the period time a user is actively engaged with your website   -->
<div class="card-body">
<i class="icon fas fa-user-alt fa-4x"></i>
    <div class="content">
      <div class="title"><h4>Sessions<!--  ผู้เข้าชมเว็บไซต์เก่า   --></h4></div>
      <div class="value"><span class="sign"></span><span class="counter"><?php echo count_session($con);?></span></div>
		<div class="title"><span>จำนวนรวมของเซสชันภายในช่วงวันที่</span></div>
	</div>
  </div>
</a>
</div>