<!-- ค้นหาด้วยการพิมพ์ข้อมูลแสดงรายการล่าสุด 10 รายการ ที่ช่องค้นหา -->
<script type="text/javascript">
    $("#search_more_news").keyup(function() {
        let s_search = document.getElementById('search_more_news').value;

        $.ajax({
            type: 'GET',
            url: 'ajax/more_news.ajax.php',
            data: {
                c_id: <?php echo $c_id; ?>,
                c_name: null,
                s_search: s_search,
                total_page: <?php echo $total_page; ?>,
                s_page: 0,
                s_limit: 10
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                $('#list_search').html(object.more_news);
                $('#list_row').html(object.list_row);
            },
            error: function() {
                console.log('Error');
            }
        });
    });
</script>