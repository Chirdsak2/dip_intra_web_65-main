function forget(type) {
  let fg_id_card = $("#fg_id_card");
  let fg_answer = $("#fg_answer");

  if (fg_id_card.val().length == 13) {
    $.ajax({
      type: "POST",
      url: "ajax/forget_password.ajax.php",
      data: {
        type: type,
        fg_id_card: fg_id_card.val(),
        fg_answer: fg_answer.val()
      },
      datatype: "text",
      success: function (data) {
        let object = JSON.parse(data, true);
        // console.log(object);

        if (object.alretStatus === "show") {
          $("#" + object.alretText).show();
        } else {
          $("#" + object.alretText).hide();
        }

        //if (object.textCheck === "show") {
          //$("#list_fg_sequest").show();
          //$("#m_question_fg").html(object.messagePut);
        //}

        if (object.btn_chk === "show") {
          $("#list_fg_m_email").show();
          $("#list_fg_u_email").show();
          if(object.text_m_mail == "" || object.text_m_mail == undefined){
            $("#list_fg_m_email").hide();
          }else{
            $("#fg_m_email").val(object.text_m_mail);
            $("#fg_cut_m_email").val(object.text_m_cut);
          }

          if(object.text_u_mail == "" || object.text_u_mail == undefined){
            $("#list_fg_u_email").hide();
          }else{
            $("#fg_u_email").val(object.text_u_mail);
            $("#fg_cut_u_email").val(object.text_u_cut);
          }
          document.getElementById("btn_submit_fg").disabled = false;
          //$("#fg_email").val(object.messagePut);
        }else{
          $("#list_fg_m_email").hide();
          $("#list_fg_u_email").hide();
        }

        $("#" + object.text).html(object.message);
      },
      error: function () {
        console.log("error");
      },
    });
  }
}

$(document).ready(function () {
  $("#forgetForm").on("submit", function (event) {
    event.preventDefault();
    let formData = new FormData($(this)[0]);
    formData.append("type", "saveForm");  

    $.ajax({
      url: "ajax/forget_password.ajax.php",
      data: formData,
      processData: false,
      contentType: false,
      type: "POST",
      success: function (data) {
        let object = JSON.parse(data, true);
        //console.log(object);
        if (object.alretStatus == "show") {
          $("#" + object.alretText).show();
        } else {
          $("#" + object.alretText).hide();
        }

        $("#" + object.text).html(object.message);
        document.getElementById("btn_submit_fg").disabled = true;
      },
      error: function (data) {
        console.log("error");
      },
    });
  });
});
