<?php $p=new page(); ?>
<?php $m=new main(); ?>
<?php $p->print_meta('Weekly Report') ?>
<link rel="stylesheet" href="/plugin/jquery-ui/base/jquery.ui.all.css">
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(function() {
	$( ".date" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
});
</script>
</head>
<body>
<div id="mainBox">
    <form action="?" method="post" name="form1" id="form1" >
    <h2>Weekly Report</h2>
    <input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" name="activity_client_id" value="<?php echo $display['post']['activity_client_id']?>" />
    <?php $p->print_search() ?>
    <?php if($display['data']['list']){ ?>
<div class="table">
<?php
$i=0;
if($display['data']['list']){
    foreach($display['data']['list'] as $key => $val){
        echo '<div class="tr">';
		echo '<div class="th">'.$key.'</div>';
		echo '<div class="td">';
		foreach($val as $v){
			echo '<img src="'.$v.'" style="max-height:100px; max-width:100px;">';
		}
		echo '</div>';
        echo '</div>';
    }
?>
<br clear="all">
</div>
<?php $p->print_form() ?>
<div class="btnBox">
<input type="button" class="btn" id="submitBt" onclick="sendForm3('comp','submitBt')" value="entry" />
</div>
<?php
	}
?>

    <?php } ?>
    </form>
</div>

</body>
</html>