</div>
<div class="m-b-xl"></div>			
<?php include("../EWT_ADMIN/panel-footer.php");?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- jquery-confirm -->
<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script> 
	
<script>
$(".row").sortable({
  axis: "x",
  items: ".column"
});
$(".container").sortable({
  axis: "y",
  items: ".row",
  placeholder: 'block-placeholder',
  revert: 150,
  start: function(e, ui) {

    placeholderHeight = ui.item.outerHeight();
    ui.placeholder.height(placeholderHeight + 15);
    $('<div class="block-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);

  },
  change: function(event, ui) {

    ui.placeholder.stop().height(0).animate({
      height: ui.item.outerHeight() + 15
    }, 300);

    placeholderAnimatorHeight = parseInt($(".block-placeholder-animator").attr("data-height"));

    $(".block-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
      height: 0
    }, 300, function() {
      $(this).remove();
      placeholderHeight = ui.item.outerHeight();
      $('<div class="block-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
    });

  },
  stop: function(e, ui) {

    $(".block-placeholder-animator").remove();

  },
});

// Block Controls
$(".blocks").sortable({
  connectWith: '.blocks',
  placeholder: 'block-placeholder',
  revert: 150,
  start: function(e, ui) {

    placeholderHeight = ui.item.outerHeight();
    ui.placeholder.height(placeholderHeight + 15);
    $('<div class="block-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);

  },
  change: function(event, ui) {

    ui.placeholder.stop().height(0).animate({
      height: ui.item.outerHeight() + 15
    }, 300);

    placeholderAnimatorHeight = parseInt($(".block-placeholder-animator").attr("data-height"));

    $(".block-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
      height: 0
    }, 300, function() {
      $(this).remove();
      placeholderHeight = ui.item.outerHeight();
      $('<div class="block-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
    });

  },
  stop: function(e, ui) {

    $(".block-placeholder-animator").remove();

  },
});
$('.block-add').click(function() {
  $(this).closest('.column').find('.blocks').append('<div class="block clearfix"><div class="block-actions pull-right"><div class="remove modifier remove-block"><i class="fa fa-times"></i></div><div class="action modifier copy-block"><i class="fa fa-repeat"></i></div><div class="edit modifier edit-block"><i class="fa fa-pencil"></i></div></div></div>');
});

// Rows
$('.row-add').click(function() {
  $('.builder-body').append('<div class="row well sortable"><div class="col-xs-6 column well sortable"></div><div class="col-xs-6 column well sortable"></div></div>');
});
$.fn.extend({
  removeclasser: function(re) {
    return this.each(function() {
      var c = this.classList
      for (var i = c.length - 1; i >= 0; i--) {
        var classe = "" + c[i]
        if (classe.match(re)) c.remove(classe)
      }
    })
    return re;
  },
  translatecolumn: function(columns) {
    var grid = [];
    var items = columns.split(',');
    for (i = 0; i < items.length; ++i) {
      if (items[i] == '1') {
        grid.push(12);
      }
      if (items[i] == '2') {
        grid.push(6);
      }
      if (items[i] == '3') {
        grid.push(4);
      }
    }
    return grid;
  }
});

// Column Controls
$(".row-toolbar").disableSelection();

$('.column-option').click(function() {
  var grid = $.fn.translatecolumn($(this).data('split').toString());
  var columns = $(this).closest('.row').find('.column');
  for (i = 0; i < grid.length; ++i) {
    if (columns[i]) {
      $(columns[i]).removeclasser('col-');
      $(columns[i]).addClass('col-xs-' + grid[i]);
    } else {
      // Create column with class
      $(columns[i]).append('<div class="col-xs-6 column well sortable"><div class="blocks">');
    }
    // If less columns than existing then merge
  }
});



function boxPopup(link){
    $.ajax({
      type: 'GET',
      url: link,
      beforeSend: function() {
        $('#box_popup').html('');
      },
      success: function (data) {
        $('#box_popup').html(data);
      }
    });
	
    $('#box_popup').fadeIn();
  }
  
</script>
<!-- Counter -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/waypoints.js"></script>
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/jquery.counterup.js"></script>

<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>