<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

<?php
$_chat_log = chat::getChatLog(array("chat_from_id" => $_SESSION['EWT_MID']))["dataAll"];
$chat_log = chat::getChatLog(array("chat_to_id" => $_SESSION['EWT_MID']))["dataAll"];
$array = array();
foreach ($chat_log as $value) {
  array_push($array, $value["chat_from_id"]);
}
foreach ($_chat_log as $value) {
  array_push($array, $value["chat_to_id"]);
}
$s_chat_from_id = implode(",", array_unique($array));
$user_online = visitor::getVisitorOnline()["data"];
$chat_user_other = chat::getUser($s_chat_from_id, $s_search);

if ($chat_id == $_SESSION['EWT_MID']) {
  $chat_form = array();
} else {
  $chat_form = chat::getChatLog(array("chat_from_id" => $chat_id, "chat_to_id" => $_SESSION['EWT_MID']))["dataAll"];
}
$chat_to = chat::getChatLog(array("chat_from_id" => $_SESSION['EWT_MID'], "chat_to_id" => $chat_id))["dataAll"];
$chat_user = array_merge(!empty($chat_form) ? $chat_form : array(), !empty($chat_to) ? $chat_to : array());
sort($chat_user);
?>
<!-- Font on Website -->
<link rel="stylesheet" href="assets/css/profile.css">
<style>
  ::-webkit-scrollbar {
    width: 5px;
  }

  ::-webkit-scrollbar-track {
    width: 5px;
    background: #f5f5f5;
  }

  ::-webkit-scrollbar-thumb {
    width: 1em;
    background-color: #ddd;
    outline: 1px solid slategrey;
    border-radius: 1rem;
  }

  .text-small {
    font-size: 0.9rem;
  }

  .messages-box,
  .chat-box {
    height: 510px;
    overflow-y: scroll;
  }

  .rounded-lg {
    border-radius: 0.5rem;
  }

  input::placeholder {
    font-size: 0.9rem;
    color: #999;
  }

  .user-online {
    height: 25px;
    text-align: center;
    border-radius: 50%;
    position: absolute;
    top: 40px;
    left: 230px;
    font-size: 15px;
    padding-top: 2px;
  }

  .user-offline {
    height: 25px;
    text-align: center;
    border-radius: 50%;
    position: absolute;
    top: 40px;
    left: 230px;
    font-size: 15px;
    padding-top: 2px;
  }
</style>

<div class="container-fluid b__profile mar-t-90px">
  <div class="container py-5 text-center">
    <h3><i class="fa fa-comment"></i> กล่องข้อความ</h3>
  </div>

  <div class="container">
    <div class="row">
      <!-- Users box-->
      <div class="col-lg-3 col-md-3 col-12">
        <div class="bg-white shadow">
          <div class="bg-gray px-4 py-2 bg-light input-group">
            <div class="input-group-prepend border-0">
              <button type="button" name="btn_search" id="btn_search" class="btn btn-link text-info"><em class="fa fa-search"></em></button>
            </div>
            <input type="search" name="s_search" id="s_search" placeholder="ค้นหารายการที่นี่" aria-describedby="btn_search" class="form-control bg-none border-0">
          </div>

          <form name="form_user" id="form_user">
            <div class="messages-box">
              <!-- <div class="list-group rounded-0">
                <?php foreach ($chat_log as $key => $value) { ?>
                  <?php
                  $user_sso = $sso->getUser($value["chat_from_username"])["data"]; //ข้อมูลคนที่แชทหาเรา
                  $full_name = $user_sso["USR_FNAME"] . ' ' . $user_sso["USR_LNAME"]; //ชื่อ-นามสกุลคนที่แชทหาเรา
                  $user_image = getImgbase64("profile/" . $user_sso["USR_PICTURE"], "images/user_profile_empty.png"); //รูปคนแชทหาเรา
                  $chat_date = datediffThai($value["chat_date"], date("Y-m-d H:i:s")); //หาจำนวนวันที่แชทล่าสุด
                  ?>
                  <a href="chat_messages.php?chat_id=<?php echo $value['chat_from_id'] ?>" class="list-group-item list-group-item-action <?php echo ($chat_id == $value["chat_from_id"] ? "active text-white" : "list-group-item-light"); ?> rounded-0">
                    <div class="media">
                      <img src="<?php echo $user_image; ?>" alt="<?php echo $user_sso["USR_PICTURE"]; ?>" width="50" class="rounded-circle">
                      <div class="media-body ml-4">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <h6 class="mb-0"><?php echo $full_name; ?></h6>
                        </div>
                        <p class="font-italic mb-0 text-small">
                          <?php echo mb_strimwidth($value["chat_message"], 0, 80, '...'); ?> <?php echo ($chat_date["count"] > 0 ? ": " . $chat_date["data"] : ""); ?>
                        </p>
                      </div>
                    </div>
                  </a>
                <?php } ?>
              </div> -->

              <div class="list-group rounded-0">
                <?php foreach ($chat_user_other as $key => $value) { ?>
                  <?php
                  $user_sso = $sso->getUser($value["gen_user"])["data"]; //ข้อมูลคนที่แชทหาเรา
                  $full_name = $value["name_thai"] . ' ' . $value["surname_thai"]; //ชื่อ-นามสกุลคนที่แชทหาเรา
                  $user_image = getImgbase64("profile/" . $user_sso["USR_PICTURE"], "images/user_profile_empty.png"); //รูปคนแชทหาเรา
                  $chat_date = datediffThai($value["chat_date"], date("Y-m-d H:i:s")); //หาจำนวนวันที่แชทล่าสุด
                  $user_online = visitor::getVisitorChat($value["gen_user_id"]);
                  ?>
                  <?php if (!empty($user_sso)) { ?>
                    <a href="chat_messages.php?s_search=<?php echo $s_search ?>&chat_id=<?php echo $value['gen_user_id']; ?>" class="list-group-item list-group-item-action <?php echo ($chat_id == $value["gen_user_id"] ? "active text-white" : "list-group-item-light"); ?> rounded-0">
                      <div class="media">
                        <img src="<?php echo $user_image; ?>" alt="<?php echo $user_sso["USR_PICTURE"]; ?>" width="50" class="rounded-circle">
                        <?php if ($user_online > 0) { ?>
                          <p class="font-italic mb-0 text-small <?php echo ($chat_id == $value["gen_user_id"] ? "text-light" : "text-success"); ?> user-online">ออนไลน์</p>
                        <?php } else { ?>
                          <!-- <p class="font-italic mb-0 text-small text-danger user-offline">ออฟไลน์</p> -->
                        <?php } ?>
                        <div class="media-body ml-4">
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <h6 class="mb-0"><?php echo $full_name; ?></h6>
                          </div>
                          <p class="font-italic mb-0 text-small"></p>
                        </div>
                      </div>
                    </a>
                <?php }
                } ?>
              </div>
            </div>
          </form>

        </div>
      </div>

      <!-- Chat Box-->
      <div class="col-lg-9 col-md-9 col-12">
        <div class="px-4 py-5 chat-box bg-white" id="list_send_messages">
          <?php
            if(!empty($chat_id)){ 
            foreach ($chat_user as $key => $value) { ?>
            <?php
            $user_sso = $sso->getUser($value["chat_from_username"])["data"];
            $user_image = getImgbase64("profile/" . $user_sso["USR_PICTURE"], "images/user_profile_empty.png");
            ?>
            <?php if ($value["chat_from_id"] == $_SESSION['EWT_MID']) { ?>
              <div class="media w-50 ml-auto mb-3">
                <div class="media-body">
                  <div class="bg-primary rounded py-2 px-3 mb-2">
                    <p class="h5 mb-0 text-white"><?php echo $value["chat_message"]; ?></p>
                  </div>
                  <p class="small text-muted"><?php echo convDateThai($value["chat_date"])["DateChat"]; ?></p>
                </div>
              </div>
            <?php } else { ?>
              <div class="media w-50 mb-3">
                <img src="<?php echo $user_image; ?>" alt="<?php echo $user_sso["USR_PICTURE"]; ?>" width="50" class="rounded-circle">
                <div class="media-body ml-3">
                  <div class="bg-light rounded py-2 px-3 mb-2">
                    <p class="h5 mb-0"><?php echo $value["chat_message"]; ?></p>
                  </div>
                  <p class="small text-muted"><?php echo convDateThai($value["chat_date"])["DateChat"]; ?></p>
                </div>
              </div>
            <?php } ?>
          <?php } }?>
        </div>

        <!-- Typing area -->
        <form name="form_messages" id="form_messages" class="bg-dark">
          <div class="input-group">
            <input type="hidden" name="Flag" id="Flag" value="chat_messages">
            <input type="hidden" name="chat_id" id="chat_id" value="<?php echo $chat_id; ?>">
            <input type="text" name="chat_message" id="chat_message" class="form-control rounded-0 border-0 py-4 bg-secondary" style="color: #fff;" onkeyup="refresh(<?php echo $chat_id; ?>);">
            <div class="input-group-append">
              <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  // $(".messages-box a").on("click", function() {
  //   $(".messages-box a").removeClass("active text-white list-group-item-light");
  //   $(this).addClass("active text-white");
  // });

  $(document).ready(function() {
    $("#form_messages").on("submit", function(event) {
      event.preventDefault();
      let formData = new FormData($(this)[0]);

      $.ajax({
        url: "ajax/chat_messages.ajax.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function(data) {
          let object = JSON.parse(data, true);
          $('#list_send_messages').html(object.messages);
        },
        error: function(data) {
          console.log('Error');
        }
      });
    });
  });

  $("#btn_search").click(function() {
    window.location.href = 'chat_messages.php?s_search=' + $('#s_search').val() +
      '&chat_id=<?php echo $chat_id; ?>';
  });

  $('#s_search').keyup(function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      $('#btn_search').click();
    }
  });

  function refresh(chat_id) {
    $.ajax({
      url: "ajax/chat_messages.ajax.php",
      data: {
        Flag: 'refresh_messages',
        chat_id: chat_id,
      },
      datatype: "text",
      type: "POST",
      success: function(data) {
        let object = JSON.parse(data, true);
        $('#list_send_messages').html(object.messages);
      },
      error: function(data) {
        console.log('Error');
      }
    });
  }
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->