$(document).ready(function () {
  $("#repasswordForm").on("submit", function (event) {
    event.preventDefault();
    let formData = new FormData($(this)[0]);

    $.ajax({
      url: "ajax/re_password.ajax.php",
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
        if(object.status === "success"){
          $.alert({
              title: object.message,
              content: 'Success!',
              icon: 'fa fa-check-circle',
              theme: 'modern',
              type: 'green',
              typeAnimated: true,
              boxWidth: '30%',
              buttons: {
                ok: {
                  btnClass: 'btn-green'
                }
              },
              onAction: function() {
                window.location.href = "login.php";
              }
          });
        }
      },
      error: function (data) {
        console.log("error");
      },
    });
  });
});
