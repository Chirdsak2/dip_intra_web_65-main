<style>
  .icon-sound {
    filter: invert(27%) sepia(51%) saturate(2878%) hue-rotate(277deg) brightness(104%) contrast(97%);
    width: 26px;
    height: auto;
  }
</style>

<div class="modal fade" id="vocabPop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="vocabPopModalLabel" aria-hidden="true" style="background-color:rgb(123,86,151,0.9);">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="vocabPopModalLabel">Englist Chit Chat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center mt-3 mb-3">
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">คำศัพท์</th>
                <th scope="col">คำอ่าน</th>
                <th scope="col">คำแปล</th>
                <th scope="col"></th>
                <th scope="col">ประโยคคำศัพท์</th>
                <th scope="col">คำแปล</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="list_eng_chat"></tbody>
          </table>
          <a class=" more-index mx-auto my-3 mt-3 mb-3" href="vocabulary.php" role="button">ดูคำศัพท์ทั้งหมด</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function c_chat(v_id) {
    $.ajax({
      type: 'POST',
      url: 'ajax/vocab.ajax.php',
      data: {
        v_id: v_id
      },
      datatype: "text",
      success: function(data) {
        let object = JSON.parse(data, true);
        $('#list_eng_chat').html(object.output);
      },
      error: function() {
        console.log('error');
      }
    });
  }
</script>