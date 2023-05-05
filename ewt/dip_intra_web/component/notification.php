<script>
    function alertNotification(id, type, url) {
        $.ajax({
            type: 'POST',
            url: 'ajax/notification.ajax.php',
            data: {
                id: id,
                type: type,
                url: url
            },
            datatype: "text",
            success: function (data) {
                let object = JSON.parse(data, true);
                //console.log(object.status);
                if(object.status == "success"){
                    window.location.href = object.url;
                }
            },
            error: function () {
                console.log('error');
            }
        });
    }
</script>