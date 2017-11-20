<?php $p=new page(); ?>
<?php $m=new main(); ?>
<?php $p->print_meta('create') ?>
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
    <a href="index.html">HOME</a> &gt; <a href="client.html">client</a>
    </div>
    <form action="?" method="post" name="form1" id="form1">
    <h2>client</h2>
    <input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="client_id" value="" />
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
	<th>Name</th>
	<th>Applicant state</th>
	<th>Entry Date</th>
	<th>Consultant</th>
	<th>Health Coach</th>
	<th>Remaining Days(s)</th>
	';
	if($display['session']['user_role_id']==1){
	echo '<th>Del</th>';
	}
	echo '
	</tr>
	';
    foreach($display['data']['list'] as $key => $val){
		$i++;
        echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$val['client_id'].'</td>';
        echo '<td onclick="sendForm(\'edit\','.$val['client_id'].')" class="selLink">';
		echo '<p>'.$val['client_first_name'].' '.$val['client_last_name'].'</p>';
		echo '</td>';
        echo '<td>'.$display['list']['client_status'][$val['client_status']].'</td>';
		echo '<td>'.$m->utc($val['client_create_time'],$val['client_time_zone']).'</td>';
		echo '<td>'.$display['list']['consultant'][$val['client_consultant_id']].'</td>';
		echo '<td>'.$display['list']['consultant'][$val['client_health_coach_id']].'</td>';
		echo '<td>'.$m->time_diff(date('Y-m-d'),$val['client_terms_end'],1).'</td>';
		if($display['session']['user_role_id']==1){
			echo '<td onClick="sendForm(\'delete\','.$val['client_id'].')" class="delete_bt pc"><img src="/admin_2ka6b5k6/images/delete_bt.png" alt="delete"></td>';
		}
        echo '</tr>';
    }
    echo '</table>';
}
?>
</div>
	<div class="navi"><?php echo $display['data']['navi'] ?></div>
    <?php } ?>
    </form>
</div>
<?php $p->print_footer() ?>
