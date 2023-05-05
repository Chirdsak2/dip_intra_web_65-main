<!-- ฟังก์ชันย่อบทความ -->
<script type="text/javascript" language="javascript">
    $(".small2").each(function() {
        text = $(this).text();
        if (text.length > 25) {
            $(this).html(text.substr(0, 25) + '<span class="elipsis">' + text.substr(25) + '</span><a class="elipsis" href="#"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> ดูเพิ่มเติม</a>');
        }
    });
    $(".small2 > a.elipsis").click(function(e) {
        e.preventDefault(); //prevent '#' from being added to the url
        $(this).prev('span.elipsis').fadeToggle(500);
    });
</script>