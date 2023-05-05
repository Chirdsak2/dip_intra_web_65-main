$(document).ready(function () {
        if ($(window).width() < 600) {
          $(".next").text('>');
          $(".last").text('>>');
          $(".previous").text('<');
          $(".first").text('<<');
        }
        else{
            $(".next").text('หน้าถัดไป');
            $(".last").text('หน้าสุดท้าย');
            $(".previous").text('หน้าที่แล้ว');
            $(".first").text('หน้าแรกสุด');
        }
});

$(document).ready(function($) {
  "use strict";
  
  var container_01 = $("#container-01");
  
  container_01.imagesLoaded(function () {
      container_01.pinto({
          itemWidth:300,
          gapX:0,
          gapY:0,
      });
  });
  
  $("#init").click(function(){
      container_01.pinto();
  });
  
  $("#destroy").click(function(){
      container_01.pinto("destroy");
  });
});