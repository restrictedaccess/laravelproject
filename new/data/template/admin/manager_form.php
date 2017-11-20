<?php $p=new page() ?>
<?php $p->print_meta('manager edit') ?>
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
<?php $p->print_header() ?>
<div id="mainBox">
    <div class="pNavi">
    <a href="index.html">HOME</a> &gt; <a href="manager.html">manager</a>
    </div>
    <h2>manager</h2>
    <form action="?" method="post" name="form1" id="form1" enctype="multipart/form-data">
	<input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="manager_id" value="<?php echo  $display['post']['manager_id'] ?>" />
    <?php if($display['post']['mode']!='checked'){ ?>
	<h3>Demographics</h3>
    <?php $p->print_form() ?>
    <div class="btnBox">
    <input type="button" class="btn" onclick="sendForm('conf','<?php echo  $display['post']['manager_id'] ?>')" value="Confirmation" />
    </div>
    <?php }else{ ?>
    <?php $p->print_conf() ?>
    <div class="btnBox">
    <input type="button" class="btn" onclick="sendForm('back','<?php echo  $display['post']['manager_id'] ?>')" value="Back" />
    <input type="button" class="btn2" onclick="sendForm('comp','<?php echo  $display['post']['manager_id'] ?>')" value="Complete" />
    </div>
    <?php } ?>
    </form>
</div>
<?php $p->print_footer() ?>
