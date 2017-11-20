<?php $p=new page() ?>
<?php $p->print_meta($display['list']['memo_class'][$display['post']['memo_class']]) ?>
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
<h2><?php echo $display['list']['memo_class'][$display['post']['memo_class']];?></h2>
<form action="?" method="post" name="form1" id="form1">
<input type="hidden" id="mode" name="mode" value="" />
<?php $p->print_form() ?>
<div class="btnBox">
<input type="button" class="btn" id="submitBt" onclick="sendForm3('comp','submitBt')" value="entry" />
</div>
</form>
</div>
</body>
</html>