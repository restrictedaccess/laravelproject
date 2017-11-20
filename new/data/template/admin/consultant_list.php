<?php $p=new page(); ?>
<?php $m=new main(); ?>
<?php $p->print_meta('consultant / Health Coach') ?>
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
    <a href="index.html">HOME</a> &gt; <a href="consultant.html">consultant / Health Coach</a>
    </div>
    <form action="?" method="post" name="form1" id="form1">
    <h2>consultant / Health Coach <input type="button" onclick="sendForm('add')" value="create consultant" class="btn2" /></h2>
    <input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="consultant_id" value="" />
    <?php $p->print_search() ?>
    
    <?php if($display['data']['list']){ ?>
    <div class="navi"><?php echo $display['data']['navi'] ?></div>
<div class="listTable">
<?php
$i=0;
if($display['data']['list']){
    echo '<table>
	<tr>
	<th>#</th>
	<th>ID</th>
	<th>Role</th>
	<th>Name</th>
	<th>Applicant state</th>
	<th>Entry Date</th>
	<th>Del</th>
	</tr>
	';
    foreach($display['data']['list'] as $key => $val){
		$i++;
        echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$val['consultant_id'].'</td>';
        echo '<td>'.$display['list']['consultant_role'][$val['consultant_role']].'</td>';
        echo '<td onclick="sendForm(\'edit\','.$val['consultant_id'].')" class="selLink">';
		echo '<p>'.$val['consultant_first_name'].' '.$val['consultant_last_name'].'</p>';
		echo '</td>';
        echo '<td>'.$display['list']['consultant_status'][$val['consultant_status']].'</td>';
		echo '<td>'.$val['consultant_create_time'].'</td>';
		echo '<td onClick="sendForm(\'delete\','.$val['consultant_id'].')" class="delete_bt pc"><img src="/admin_2ka6b5k6/images/delete_bt.png" alt="delete"></td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
</div>
    <?php } ?>
    </form>
</div>
<?php $p->print_footer() ?>
