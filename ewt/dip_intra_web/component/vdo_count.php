<!-- ฟังก์ชันนับจำนวนการดูวิดีโอ -->
<script>
    function Func_Vdocount(event) {
        console.log(event);
        $.ajax({
            type: 'POST',
            url: "ajax/count_view_vdo.ajax.php",
            data: {
                'id': event,
                'proc': 'CountVdo'
            },
            success: function(data) {
                console.log(data);

            }
        });
    }
</script>