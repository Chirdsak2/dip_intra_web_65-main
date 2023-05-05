<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<script>
    $.alert({
        title: 'ขอบคุณสำหรับการตอบแบบสอบถามค่ะ',
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
            location.reload(true);
        }
    });
</script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>