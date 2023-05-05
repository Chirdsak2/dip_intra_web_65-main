<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
  <div class="card">
    <div class="card-body">

      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">	

            <?php 
            if(file_exists("../EWT_ADMIN/".$EWT_module_icon)==true){
            ?>
            <img src="../EWT_ADMIN/<?php echo $EWT_module_icon; ?>" class="animated fadeInDown " style="height: 60px;width: 60px;">
            <?php } ?>  
            <span class="animated fadeInDown text-large "><?php echo $EWT_module_name; ?></span>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 float-right text-right hidden-xs" style="top:18px;"> 
            <a href="../EWT_ADMIN/main.php">
                <button type="button" class="btn btn-default btn-sm">
                <i class="fas fa-home"></i>&nbsp;Home</button>
            </a>

            <?php
            foreach($EWT_module_subarray AS $sub){
            ?>
            <a href="<?php echo $sub["url"]; ?>" title="<?php echo $sub["name"]; ?>" target="_self">
                <button type="button" class="btn btn-default btn-sm">
                <i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $sub["name"]; ?></button>
            </a>
            <?php
            }
            ?>
        </div>
        
        <div class="col-md-6 col-sm-6 col-xs-12 float-right text-right  visible-xs row m-b-sm ">
            <div class="btn-group ">
                <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fas fa-bars"></i> menu <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="../EWT_ADMIN/main.php"><i class="fas fa-home"></i>&nbsp;Home</a></li>

                    <?php
                    foreach($EWT_module_subarray AS $sub){
                    ?>
                    <li><a href="<?php echo $sub["url"]; ?>"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php echo $sub["name"]; ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>
