<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<?php
$vacab = $sso->getVocab($start_search, $per_page_search, $s_search);
//$total_page_vocab = ceil($vacab["countAll"] / $per_page_search);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/contact.css">

<style>
    .icon-sound {
        filter: invert(27%) sepia(51%) saturate(2878%) hue-rotate(277deg) brightness(104%) contrast(97%);
        width: 26px;
        height: auto;
    }
</style>


<div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3> ตารางคำศัพท์ </h3>
    </div>
</div>

<!-- ค้นหา -->
<section class="search-sec header--bg">
    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-12 p-0">
                            <input type="text" name="s_search" id="s_search" class="form-control search-slt" onkeyup="myFunction()" placeholder="ค้นหาด้วยคำศัพท์.." title="กรอกคำศํพท์">
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <button type="button" id="btn_search" class="btn btn--search wrn-btn"> ค้นหา </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- ข้อมูล -->
<div class="container padding--50">
    <div class="table-responsive">
        <table class="table table-striped table-bordered " id="myTable">
            <thead class="thead-dark">
                <tr>
                    <th>คำศัพท์</th>
                    <th>คำอ่าน </th>
                    <th>คำแปล</th>
                    <th>เสียง</th>
                    <th>ประโยคคำศัพท์</th>
                    <th>คำแปล</th>
                    <th>เสียง</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vacab["data"] as $key => $value) { ?>
                    <?php
                    $sound1 = $sso->getSound($value["VOCAB_ID"], 'VOCAB_FILE1')["data"]["FILE_SAVE_NAME"];
                    $sound2 = $sso->getSound($value["VOCAB_ID"], 'VOCAB_FILE2')["data"]["FILE_SAVE_NAME"];
                    ?>

                    <tr>
                        <td><?php echo $value['VOCAB_TITLE1']; ?></td>
                        <td><?php echo $value['VOCAB_READ1']; ?></td>
                        <td><?php echo $value['VOCAB_EXPL1']; ?></td>
                        <td>
                            <audio id="player<?php echo $value["VOCAB_ID"]; ?>" src="<?php echo HOST_SSO . 'attach/w17/' . $sound1; ?>"></audio>
                            <a href="#!" onclick="document.getElementById('player<?php echo $value['VOCAB_ID']; ?>').play();">
                                <img src="assets/img/icon/volume-down-solid.svg" class="icon-sound">
                            </a>
                            
                        </td>
                        <td><?php echo $value['VOCAB_TITLE2']; ?></td>
                        <td><?php echo $value['VOCAB_EXPL2']; ?></td>
                        <td>
                            <audio id="player2<?php echo $value["VOCAB_ID"]; ?>" src="<?php echo HOST_SSO . 'attach/w17/' . $sound2; ?>"></audio>
                            <a href="#!" onclick="document.getElementById('player2<?php echo $value['VOCAB_ID']; ?>').play();">
                                <img src="assets/img/icon/volume-down-solid.svg" class="icon-sound">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Start แสดงการตัดหน้าเพจ -->
    <!-- <?//php echo pagination('vocabulary.php', 's_search=' . $s_search . '', $page, $per_page_search, $vacab["countAll"]); ?> -->
    <?php echo pagination_ewt('vocabulary.php', 's_search=' . $s_search . '', $page, $per_page_search, $vacab["countAll"]); ?>
    <!-- End แสดงการตัดหน้าเพจ-->
</div>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("s_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    $("#btn_search").click(function() {
        window.location.href = 'vocabulary.php?s_search=' + $('#s_search').val();
    });
</script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>