$(document).ready(function () {
  $("#registerForm").on("submit", function (event) {
    event.preventDefault();
    let formData = new FormData($(this)[0]);
    //formData.append("type", "saveForm");
    let policy_check = document.getElementById("policy_check_reqister").checked;
    
    if (policy_check == true) {
      $.ajax({
        url: "ajax/register.ajax.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function (data) {
          let object = JSON.parse(data, true);
          if (object.status === "success") {
            messageBox(object.message, 'Success!', 'fa fa-check-circle', 'green', 'btn-green', 'show');
          }

          if (object.status === "error") {
            messageBox(object.message, 'Error!', 'fa fa-times-circle', 'red', 'btn-red', 'show');
          }

          if (object.btn_chk === "show") {
            document.getElementById("btn_submit").disabled = true;
          }

          $("#list_ck_policy").hide();
        },
        error: function (data) {
          console.log("error");
        },
      });
    }else{
      $("#list_ck_policy").show();
    }
  });
});

function messageBox(message, status, icon, color, btnClass, action) {
  if (message == '') {
      location.reload(true);
  } else {
      $.alert({
          title: message,
          content: status,
          icon: icon,
          theme: 'modern',
          type: color,
          typeAnimated: true,
          boxWidth: '30%',
          buttons: {
              ok: {
                  btnClass: btnClass
              }
          },
          onAction: function() {
              if (action == "show") {
                  location.reload(true);
              }
          }
      });
  }
}
