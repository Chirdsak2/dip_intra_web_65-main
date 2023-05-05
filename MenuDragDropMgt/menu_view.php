<?php
include("../EWT_ADMIN/config.inc.php");
?>
<!-- Nested node template -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tree demo</title>
<style type="text/css">
		html, body, ul, li { margin:0; padding:0; }
		body { font-family:verdana; background: #3d4f61; color:#fff; }
		ul, li { list-style-type:none; padding:3px; color:#fff; border:1px solid #000; }
		ul { padding:10px; }
		ul li { padding-left:50px; margin:10px 0; border:1px solid #000; }
		li div { padding:7px; background-color:#D870A9; border:1px solid #000; }
		li, ul, div { border-radius: 3px; }
		.scrollUp { position:fixed; top:0; left:0; height:48px; width:50px; border:1px solid red; }
		.scrollDown { position:fixed; bottom:0; left:0; height:48px; width:50px; border:1px solid red; }
		.sortableListsClose ul, .sortableListsClose ol { display:none; }
		.sortableListsOpener { display:inline-block; float:left; width:18px; height:18px; margin-right:5px; background:url('../js/sortable-jQuery-lists/imgs/remove.png') center center no-repeat; }
		.sortableListsClose .sortableListsOpener { background:url('../js/sortable-jQuery-lists/imgs/add.png') center center no-repeat; }
		.red { background-color:#ff9999;}
		.blue { background-color:#D870A9;}
		.green { background-color:#99ff99; }
		.pV10 { padding-top:10px; padding-bottom:10px; }
		.dN { display:none; }
		.zI1000 { z-index:1000; }
		.bgC1 { background-color:#ccc; }
		.bgC2 { background-color:#ff8; }
		.bgC3 { background-color:#f0f; }
		.bgC4 { background-color:#ED87BD; }
		.small1 { font-size:0.8em; }
		.small2 { font-size:0.7em; }
		.small3 { font-size:0.6em; }
		#sTreeBase { width:100px; height:50px; background-color: blue; }
		#text { padding:10px 0; }
		#sTree { background-color: green; }
		#sTree2 { margin:10px 0; }
		#center { width:950px; margin:0 auto; padding:10px; }
	</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	
<script src="../js/sortable-jQuery-lists/jquery-sortable-lists.js"></script>
<script type="text/javascript">
		$(function()
		{
			var options = {
				currElClass: 'red',
				placeholderClass: 'bgC2',
				listsClass:'',
				isAllowed: function(cEl, hint, target)
					{
						hint.css('background-color', '#99ff99');
						return true;
					}
			};
			$('#sTree2').sortableLists(options);

			console.log($('#sTree2').sortableListsToArray());
			console.log($('#sTree2').sortableListsToHierarchy());
			console.log($('#sTree2').sortableListsToString());
		});
	</script> 
</head>

<body >
<div class="container">
<div>
<ul class="sTree bgC4" id="sTree2">
		<li class="bgC4" id="item_a">
			<div>Item a</div>
		</li>
		<li class="bgC4" id="item_b">
			<div>Item b</div>
		</li>
		<li class="bgC4 sortableListsClose" id="item_c">
			<div><span class="sortableListsOpener"> </span>Item c</div>
			<ul class="">
				<li class="bgC4" id="item_1">
					<div>Item 1</div>
				</li>
				<li class="bgC4" id="item_2">
					<div>Item 2</div>
				</li>
				<li class="bgC4" id="item_3">
					<div>Item 3</div>
				</li>
				<li class="bgC4" id="item_4">
					<div>Item 4</div>
				</li>
				<li class="bgC4" id="item_5">
					<div>Item 5</div>
				</li>
			</ul>
		</li>
		<li class="bgC4 sortableListsClose" id="item_d">
			<div><span class="sortableListsOpener"> </span>Item c</div>
			<ul class="">
				<li class="bgC4" id="item_1">
					<div>Item 1</div>
				</li>
				<li class="bgC4" id="item_2">
					<div>Item 2</div>
				</li>
				<li class="bgC4" id="item_3">
					<div>Item 3</div>
				</li>
				<li class="bgC4" id="item_4">
					<div>Item 4</div>
				</li>
				<li class="bgC4" id="item_5">
					<div>Item 5</div>
				</li>
			</ul>
		</li>
		<li class="bgC4 sortableListsClose" id="item_e">
			<div><span class="sortableListsOpener"> </span>Item c</div>
			<ul class="">
				<li class="bgC4" id="item_1">
					<div>Item 1</div>
				</li>
				<li class="bgC4" id="item_2">
					<div>Item 2</div>
				</li>
				<li class="bgC4" id="item_3">
					<div>Item 3</div>
				</li>
				<li class="bgC4" id="item_4">
					<div>Item 4</div>
				</li>
				<li class="bgC4" id="item_5">
					<div>Item 5</div>
				</li>
			</ul>
		</li>
	</ul>
</div>
</div>

</body>
</html>
<?php
$db->db_close();
?>