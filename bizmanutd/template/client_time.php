<?php
$end_time_counter = date("YmdHis");
$gap = $end_time_counter - $start_time_counter;
$txt =  "<font color=white>Client Load Time ".$gap." Sec.</font>";
?>
<script language="javascript">
self.parent.document.all.load_client.innerHTML = "<?php echo $txt; ?>";
</script>
