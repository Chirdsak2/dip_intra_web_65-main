<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">

<div class="container-fluid mar-t-90px bg--purple text-center">
  <div class="container py-5">
    <div class="article--topic"><?php echo $c_name; ?></div>
  </div>
</div>

<section id="article-sec bg--white">
  <?php if (!empty($data)) {
    foreach ($data as $value) { ?>
      <div class="container mt-3">
        <!-- start breadcrumb -->
        <p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="more_news.php" title="<?php echo $c_name; ?>"><?php echo $c_name; ?></a> / <a href="org_page.php" title="<?php echo trim($value['n_topic']); ?>"><?php echo trim($value['n_topic']); ?></a></p>
        <!-- start breadcrumb -->
        <hr>

        <!-- แสดงเนื้อหาข่าวตรงนี้ -->
        <div class="article--topic-name"><?php echo trim($value['n_topic']); ?></div>
        <div class="article-date-time">
          <!-- วันที่ -->
          <?php if ($news_date > 0) { ?>
            <i class="far fa-calendar-alt"></i> <?php echo convDateThai($value['n_date'])['DateTH']; ?>
          <?php } ?>
          <!-- จำนวนการเข้าอ่าน[ครั้ง] -->
          <?php if (article::getArticleCount($c_id, $n_id) > 0) { ?>
            <i class="fa fa-eye"></i> <?php echo $value['view_count']; ?>
          <?php } ?>

          <a href="#" title="<?php echo article::getOrg($value['n_owner'])['short_name']; ?>"><i class="far fa-user"></i> <?php echo article::getOrg($value['n_owner'])['short_name']; ?></a>
        </div>
        <p><?php echo $news_detail['txt_detail']; ?></p>
      </div>

      <!-- แสดงภาพประกอบข่าวตรงนี้ -->
      <?php echo $news_detail['txt_image']; ?>

      <!-- แสดงไฟล์แนบประกอบข่าวตรงนี้ -->
      <div class="container">
        <h6 class="article-header mb-3">รายการเอกสารแนบ <?php echo count($news_attach); ?> รายการ</h6>
        <?php foreach ($news_attach as $key => $value) { ?>
          <div class="article-attach-file-block">
            <div class="row">
              <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                <div class="article-attach-list">
                  <a href="<?php echo HOST_NAME; ?>article_attach/<?php echo $value["fileattach_path"]; ?>" target="_blank" title="<?php echo $value["fileattach_name"]; ?>">
                    <?php echo $value["fileattach_name"]; ?>
                  </a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-3 text-center">
                <div class="article-attach-view">
                  <a href="<?php echo HOST_NAME; ?>article_attach/<?php echo $value["fileattach_path"]; ?>" target="_blank" title="<?php echo $value["fileattach_name"]; ?>">
                    <!-- onClick="countFileOpen(<?php echo $key ?>);" -->
                    <i class="fa fa-download"></i> <span id="article_count<?php echo $key; ?>">
                      <!-- <?php echo openFile('ajax\count_file\count' . $key . '.txt'); ?> -->
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- แสดงความคิดเห็นข่าวตรงนี้ -->
      <?php if ($news_list_comment > 0) { ?>
        <div class="container article-bg-comment artice-comment-block ">
          <div class="row">
            <div class="col-lg-6 mt-3 mb-3">
              <div class="text-center mt-3 mb-5">
                <h6 class="article-header">แสดงความคิดเห็น <?php echo count($news_comment); ?> รายการ</h6>
              </div>
              <?php foreach ($news_comment as $key => $value) { ?>
                <div class="media">
                  <img src="<?php echo $_SESSION["image_member"]; ?>" class="mr-3 img-comment-avatar" alt="...">
                  <div class="media-body">
                    <div class="title-article"><?php echo $value['comment']; ?></div>
                    <small> <?php echo $value['name_comment']; ?> , <?php echo convDateThai($value['timestamp'])['DateT']; ?> , <?php echo convDateThai($value['timestamp'])['Time']; ?> น.</small>
                  </div>
                </div>
              <?php } ?>
            </div>

            <div class="col-lg-6 mt-3 mb-3">
              <div class="text-center mt-3 mb-5">
                <h6 class="article-header">ร่วมแสดงความคิดเห็น</h6>
              </div>
              <form id="comment_form">

                <div class="media">
                  <img src="<?php echo $_SESSION["image_member"]; ?>" class="align-self-center mr-3 img-comment-avatar" alt="...">
                  <div class="media-body">
                    <div class="title-article"><?php echo $_SESSION["name_comment"]; ?></div>
                    <small><?php echo convDateThai(date('Y-m-d'))['DateT']; ?> , <?php echo date('H:i'); ?> น.</small>
                  </div>
                </div>

                <div class="form-group mt-3">
                  <input type="hidden" naem="c_id" id="c_id" value="<?php echo $c_id ?>">
                  <input type="hidden" name="n_id" id="n_id" value="<?php echo $n_id ?>">
                  <input type="hidden" naem="name_comment" id="name_comment" value="<?php echo $_SESSION["name_comment"]; ?>">
                  <textarea class="form-control shadow" name="comment" id="comment" rows="5" placeholder="ร่วมแสดงความคิดเห็นร่วมกันค่ะ"></textarea>
                </div>
                <button type="submit" class="btn btn-submit-comment btn-block mb-2" onclick="">ส่งความคิดเห็น</button>
              </form>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  <?php } ?>
</section>

<!-- <script src="assets/js/jquery.min.js"></script> -->
<script>
  popup = {
    init: function() {
      $('figure').click(function() {
        popup.open($(this));
      });

      $(document).on('click', '.popup img', function() {
        return false;
      }).on('click', '.popup', function() {
        popup.close();
      })
    },
    open: function($figure) {
      $('.gallery').addClass('pop');
      $popup = $('<div class="popup" />').appendTo($('body'));
      $fig = $figure.clone().appendTo($('.popup'));
      $bg = $('<div class="bg" />').appendTo($('.popup'));
      $close = $('<div class="close"><svg><use xlink:href="#close"></use></svg></div>').appendTo($fig);
      $shadow = $('<div class="shadow" />').appendTo($fig);
      src = $('img', $fig).attr('src');
      $shadow.css({
        backgroundImage: 'url(' + src + ')'
      });
      $bg.css({
        backgroundImage: 'url(' + src + ')'
      });
      setTimeout(function() {
        $('.popup').addClass('pop');
      }, 10);
    },
    close: function() {
      $('.gallery, .popup').removeClass('pop');
      setTimeout(function() {
        $('.popup').remove()
      }, 100);
    }
  }

  popup.init()
  //# sourceURL=pen.js
</script>

<!-- นับจำนวนเปิดดูเอกสาร -->
<script>
  function countFileOpen(key) {
    $.ajax({
      type: 'GET',
      url: 'ajax/count_file.ajax.php',
      data: {
        key: key,
      },
      datatype: "text",
      success: function(data) {
        //console.log(data);
        let object = JSON.parse(data, true);
        $('#article_count' + object.key).html(object.count);
      },
      error: function() {
        console.log('Error');
      }
    });
  }
</script>

<!-- จัดการคอมเมนต์ -->
<script>
  $(document).ready(function() {
    $("#comment_form").on("submit", function(event) {
      event.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        url: "ajax/news_view.ajax.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function(data) {
          let object = JSON.parse(data, true);
          if (object.news_comment == "success") {
            window.location.reload();
          } else {
            console.log('Error');
          }
        },
        error: function(data) {
          console.log('Error');
        }
      });
    });
  });
</script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>