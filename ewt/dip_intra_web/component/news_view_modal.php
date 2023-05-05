<!-- ฟังก์ชันเปิดรูปภาพรายละเอียดข่าว -->
<div class="modal fade" id="modal_news_view" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-b-0">
                <h5 class="modal-title" id="staticBackdropLabel"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row" id="list_news_view"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function setEventNewsView(image) {
        $.ajax({
            type: 'POST',
            url: 'ajax/news_view.modal.ajax.php',
            data: {
                image: image,
            },
            datatype: "text",
            success: function(data) {
                $('#list_news_view').html(data);
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>