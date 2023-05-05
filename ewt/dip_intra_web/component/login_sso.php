<script type="text/javascript">
    // $.ajaxSetup({
    //     headers: {
    //         'Content-Type': 'application/json'
    //     }
    // });

    function loginSSO(url, username, percardno){
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                username: username,
                percardno: percardno,
            },
            headers: {
              "Content-Type": "application/json",
              "Access-Control-Allow-Origin":"*"
            },
            datatype: "json",
            success: function(data) {
                //let object = JSON.parse(data, true);
                console.log(data);
            },
            error: function() {
                console.log('Error');
            }
        });

    }
</script>