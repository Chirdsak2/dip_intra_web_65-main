<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/config_path.php");


include("../header.php");
?>
<?php
print_r(PDO::getAvailableDrivers());
 
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../js/x0popup-master/dist/x0popup.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<?php include('../EWT_ADMIN/link.php'); ?>
<script src="../js/ckeditor/ckeditor.js"></script> 
<script src="../js/x0popup-master/dist/x0popup.min.js"></script> 
<script src= "../chart/zingchart_2.3.2/zingchart.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.0-rc.1/jquery-ui.min.js"></script>
    <style type="text/css">
$red: #FF0000;
$white: #FFFFFF;
$green: #1abc9c;
$grey: #888888;
.block {
  background: #f2f2f2;
  position: relative;
  padding: 15px;
  border: 1px solid #ccc;
  &:not(:first-child) {
    margin-top: 10px;
  }
}

.modifier {
  float: right;
  margin-left: 8px;
  font-size: 14px;
}

.action {
  color: $green;
}

.edit {
  color: $grey;
}

.column-selector {
  position: relative;
}

.remove {
  color: $red;
}

.column-option {
  float: left;
}

.dropdown-menu {
  top: inherit;
}

.blocks {
  margin-bottom: 0;
}

.panel {
  border-radius: 0;
}

.row > .panel {
  background-color: #f2f2f2;
}

.builder {
  padding: 20px;
}

.block-placeholder {
  background: #DADADA;
  position: relative;
}

.block-placeholder:after {
  content: " ";
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 15px;
  background-color: #FFF;
}

    </style>	
</head>
<body class="ewt-bg-body">
<?php include('top.php');?>

<div class="row m-b-sm">

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card">
<div class="card-header">

<div class="container-fluid" >
<span class="text-x-large">Name Templates #1</span>
<p></p> 
              
<ol class="hidden-xs breadcrumb">
<li><a href="index.php">Templates Lists</a></li>
<li class="active" >Name Templates #1</li>
     
</ol>
</div>

<div class="hidden-xs row m-b-sm">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right"  >	  
<!--<a href="add_survey1.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;เพิ่มแบบฟอร์มออนไลน์
</button>
</a>
<a href="" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?//="ย้อนกลับ";?>
</button>
</a>  -->
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_view_template.php');">
<button type="button" class="btn btn-info  btn-ml " >
<i class="far fa-eye"></i>&nbsp;<?="View";?>
</button>
</a>

</div>
</div>
<div class="visible-xs row m-b-sm text-right">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="#<?="Search";?>" onclick="boxPopup('<?=linkboxPopup();?>pop_search.php');"><i class="fas fa-search"></i>&nbsp;<?="Search";?></a></li>
            <li><a href="#<?="Create Templates";?>" onclick="boxPopup('<?=linkboxPopup();?>pop_add_template.php');" ><i class="fas fa-plus-square"></i>&nbsp;<?="Create Templates";?></a></li>
        </ul>
    </div>
</div>

</div>

<div class="card-body">

	<div class="builder">
  <div class="container">
    <div class="builder-toolbar">
      <div class="row-add">
        <i class="fa fa-plus-circle"></i>
      </div>
    </div>
  </div>
  <div class="builder-body container">
    <div class="row">
      <div class="row-toolbar unsortable">

        <div class="column-selector">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-columns"></i></button>
          <ul class="dropdown-menu row-columns dropdown">
            <li class="column-option" data-split="1">12</li>
            <li class="column-option" data-split="2,2">6/6</li>
            <li class="column-option" data-split="3,3,3">4/4/4</li>
          </ul>
        </div>
        <div class="row-actions pull-right">
          <div class="remove remove-row">
            <i class="fa fa-times"></i>
          </div>
          <div class="action copy-row">
            <i class="fa fa-repeat"></i>
          </div>
          <div class="edit edit-row">
            <i class="fa fa-cog"></i>
          </div>
        </div>
      </div>
      <div class="panel panel-default panel-body sortable">
        <div class="column-container">
          <div class="col-xs-6 column sortable">
            <div class="column-toolbar">
              <div class="block-add">
                <i class="fa fa-plus-circle"></i>
              </div>
            </div>
            <div class="blocks panel panel-default panel-body">
              <div class="block clearfix">
                <div class="block-actions pull-right">
                  <div class="remove modifier remove-block">
                    <i class="fa fa-times"></i>
                  </div>
                  <div class="action modifier copy-block">
                    <i class="fa fa-repeat"></i>
                  </div>
                  <div class="edit modifier edit-block">
                    <i class="fas fa-pencil-alt"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 column sortable">
            <div class="column-toolbar">
              <div class="block-add">
                <i class="fa fa-plus-circle"></i>
              </div>
            </div>
            <div class="blocks panel panel-default panel-body">
              <div class="block clearfix">
                <div class="block-actions pull-right">
                  <div class="remove modifier remove-block">
                    <i class="fa fa-times"></i>
                  </div>
                  <div class="action modifier copy-block">
                    <i class="fa fa-repeat"></i>
                  </div>
                  <div class="edit modifier edit-block">
                    <i class="fa fa-pencil"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>		



     <div class="container-fluid">
                <div id="editor">
				
<div class="container-fluid">					
<div class="text-right"  >	  					
<a  target="_self" >
<button type="button" class="btn btn-info  btn-ml " data-bind="click: addNewWidget" >
<i class="fas fa-plus-square"></i>&nbsp;<?="Add Grid Layout";?>
</button>
</a>
</div>	
</div> 				
                    <div id="header" >
                        <section>
                            <div data-type="container-content" >						
                                <section data-type="component-text">
                                    <h2 class="text-center">Header</h2>
                                </section>								
                            </div>
                        </section>
						
		
                    </div>
					
<div class="container-fluid">					
<div class="text-right"  >	  					
<a  target="_self" >
<button type="button" class="btn btn-info  btn-ml " data-bind="click: addNewWidget" >
<i class="fas fa-plus-square"></i>&nbsp;<?="Add Grid Layout";?>
</button>
</a>
</div>	
</div> 					
                    <div id="body">
                        <section>
                            <div data-type="container-content">
                                <section data-type="component-text">
                                    <h2 class="text-center ">Body</h2>
                                </section>
                            </div>
                        </section>
						
                    </div>
					
<div class="container-fluid">					
<div class="text-right"  >	  					
<a  target="_self" >
<button type="button" class="btn btn-info  btn-ml " data-bind="click: addNewWidget-footer" >
<i class="fas fa-plus-square"></i>&nbsp;<?="Add Grid Layout";?>
</button>
</a>
</div>	
</div> 
                    <div id="footer">									
                        <section>
                            <div data-type="container-content">
                                <section data-type="component-text">
                                    <h2 class="text-center ">Footer</h2>
                                </section>
                            </div>
                        </section>
						
                    </div>
                </div>
            </div> 
</div>

</div>
</div>
</div>

<div id="box_popup" class="layer-modal"></div>

<?php
include('footer.php');
?>
</body>
</html>
<?php $db->db_close(); ?>