<!-- ฟังก์ชันนับจำนวนเปิดดูเอกสาร -->
<script>
    function newsCount(c_id, n_id, page) {
        $.ajax({
            type: 'POST',
            url: 'ajax/news_tab_index.ajax.php',
            data: {
                c_id: c_id,
                n_id: n_id,
                page: page
            },
            datatype: "text",
            success: function(data) {
                //console.log(data);
                let object = JSON.parse(data, true);
                $('#list_count' + object.n_id).html(object.view_count);
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>
