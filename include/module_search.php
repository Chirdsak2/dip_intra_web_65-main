<div id="search_module_modal" class="modal" role="dialog" style="margin-top:70px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $search_title; ?></h4>
        </div>
        <div class="modal-body">
                    
            <form action="<?php echo $search_action; ?>" method="get">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " >
                        <div class="card ">
                            <div class="card-body">
                                <?php
                                foreach($search_parameter AS $para){

                                    if($para["type"]=="text"){
                                    ?>
                                    <label for="<?php echo $para["name"]; ?>"><b><?php echo $para["label"]; ?> :</b></label>
                                    <div style="margin-bottom:10px;">
                                        <input class="form-control" type="text" id="<?php echo $para["name"]; ?>" name="<?php echo $para["name"]; ?>"
                                        value="<?php if($_GET["search"]=="Y"){echo htmlspecialchars($_GET[$para["name"]]);} ?>"
                                        >
                                    </div>
                                    <?php
                                    }
                                    else if($para["type"]=="hidden"){
                                    ?>
                                    <div>
                                        <input type="hidden" id="<?php echo $para["name"]; ?>" name="<?php echo $para["name"]; ?>"
                                        value="<?php echo htmlspecialchars($_GET[$para["name"]]); ?>"
                                        >
                                    </div>
                                    <?php
                                    }
                                }
                                ?>

                                <div align="center" style="margin-top:25px;">
                                    <button type="submit" class="btn btn-primary search_module_button">
                                        <i class="fas fa-search"></i>&nbsp;ค้นหา
                                    </button>
                                    <input type="hidden" name="search" value="Y">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

  </div>
</div>

<?php
if($search_button_class!=""){
?>
<script type="text/javascript">
    $(".<?php echo $search_button_class; ?>").click(function(){
        $('#search_module_modal').modal({backdrop: 'static', keyboard: false})  
        $("#search_module_modal").modal("show");
    })
</script>
<?php
}
?>