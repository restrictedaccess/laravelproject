<?php $p=new page() ?>
<?php $p->print_meta('ERROR') ?>
</head>
<body id="error">
<div class="rap">
<div id="mainBox">
    <h2>ERROR</h2>
    <?php
	if(DEBUG_MODE != 1){
		echo '<p><strong>system error has occurred.</strong></p><p>We apologize for the inconvenience, thank you to contact the administrator.</p>';
	}else{
		echo $display['err'];
	}
	?>
</div>
</div>
<?php $p->print_footer() ?>
