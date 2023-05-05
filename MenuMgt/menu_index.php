<?php
include("../EWT_ADMIN/comtop.php");

$use_module = "Y";

## >> Check permission
if(!$db->check_permission("menu","w","")){
  $use_module = "N";
}
else{
  $db->write_log("view","menu","เข้าสู่ Module บริหารเมนู ");
  
  if(trim($_GET["url"])!= ''){
    $link = $_GET["url"];
  }
  else{
    $link = 'menu_list.php';
  }
}

?>

<div style="height:100px;"></div>
<?php
$module_data = $db->query("SELECT m_image 
                           FROM   $EWT_DB_USER.web_module_ewt
                           WHERE  m_name IN ('Menu')");
$module_info = $db->db_fetch_array($module_data);

$EWT_module_name      = "Menu Management";
$EWT_module_icon      = $module_info["m_image"];
$EWT_module_subarray  = array(array("name"=>"บริหารเมนู","url"=>"../MenuMgt/menu_index.php"));


include("../include/module_header.php");

if($use_module == "N"){
  include("../include/module_nopermission.php");
}
else{
?>


<div class="row ">
  <div class="col-md-12 col-sm-12 col-xs-12 " >
    <div class="card ">
      <div class="card-header ewt-bg-color m-b-sm" >
        <div class="card-title text-left">
        </div>
      </div>
      <div class="card-body">
        <iframe name="iframe_data" src="<?php echo $link;?>"  frameborder="0"  width="100%" height="500"  scrolling="no"></iframe>
      </div>
    </div>
  </div>
</div>

<?php
}
?>

<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="../js/mask-input-jquery/docs/jquery.samask-masker.js"></script>
<script src="../js/pick-a-color/build/dependencies/tinycolor-0.9.15.min.js"></script>
<script src="../js/pick-a-color/build/1.2.3/js/pick-a-color-1.2.3.min.js"></script>	                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<?php
$db->db_close(); ?>

</html>