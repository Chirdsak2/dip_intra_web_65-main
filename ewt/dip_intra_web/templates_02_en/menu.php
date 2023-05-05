<div class="container-fluid navigator">
<div class="container sm-reset">
    <nav class="navbar">
        <div class="col-md-12 col-lg-4 p0 brands sm-reset">
            <?php //include 'logo.php'?>
<?=genlogo();?>
        </div>
<?=menu('0002','1');?>

  <ul class="nav navbar-nav navbar-right position-revised">
    	<li class="dropdown search">
    		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
    		  <ul class="dropdown-menu reset-p" role="menu">
    			<li>
            <form class="navbar-form navbar-left navbar-form-revised reset-m reset-p" role="search">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon2">
                    <div class="input-group-addon">
                      <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </div>
                  </div>
                </div>
            </form>
        	</li>
    		</ul>
    	</li>

    </ul>

</nav>
</div>
</div>
