<?php $p=new page(); ?>
<?php $m=new main(); ?>
<?php $p->print_meta('manager') ?>
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
    <form action="?" method="post" name="form1" id="form1">
    <h2>manager <input type="button" onclick="sendForm('add')" value="create manager" class="btn2" /></h2>
    <input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="manager_id" value="" />
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
		echo '<td>'.$val['manager_id'].'</td>';
        echo '<td>'.$display['list']['manager_role'][$val['manager_role']].'</td>';
        echo '<td onclick="sendForm(\'edit\','.$val['manager_id'].')" class="selLink">';
		echo '<p>'.$val['manager_first_name'].' '.$val['manager_last_name'].'</p>';
		echo '</td>';
        echo '<td>'.$display['list']['manager_status'][$val['manager_status']].'</td>';
		echo '<td>'.$val['manager_create_time'].'</td>';
		echo '<td onClick="sendForm(\'delete\','.$val['manager_id'].')" class="delete_bt pc"><img src="/admin_2ka6b5k6/images/delete_bt.png" alt="delete"></td>';
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
