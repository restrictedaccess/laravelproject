<?php $p=new page(); $m=new main(); ?>
<?php $p->print_meta('consultant / Health Coach edit') ?>
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
    <h2>consultant / Health Coach</h2>
    <form action="?" method="post" name="form1" id="form1" enctype="multipart/form-data">
	<input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="consultant_id" value="<?php echo  $display['post']['consultant_id'] ?>" />
    <?php if($display['post']['mode']!='checked'){ ?>
	<h3>Contract</h3>
    <?php $p->print_form() ?>
    <div class="btnBox">
    <input type="button" class="btn" onclick="sendForm('conf','<?php echo  $display['post']['consultant_id'] ?>')" value="Confirmation" />
    </div>
	
	<div class="listTable">
	<h3>Client</h3>
	<table>
		<tr>
			<th scope="col">Name</th>
			<th scope="col">status</th>
			<th scope="col">*1</th>
			<th scope="col">*2</th>
			<th scope="col">*3</th>
			<th scope="col">*4</th>
			<?php if($display['post']['consultant_role']==2){ ?>
			<th scope="col">Consultant</th>
			<?php }else{ ?>
			<th scope="col">Health Coach</th>
			<?php } ?>
		</tr>
<?php
    foreach($display['data']['client_list'] as $key => $val){
        echo '<tr>';
        echo '<td>';
		echo '<p><a href="client.html?id='.$val['client_id'].'" target="_blank">'.$val['client_first_name'].' '.$val['client_last_name'].'['.$val['client_id'].']</a></p>';
		echo '</td>';
        echo '<td>'.$display['list']['client_status'][$val['client_status']].'</td>';
		echo '<td>'.$m->time_diff(date("Y-m-d", strtotime($val['client_create_time']." -1 day")),date('Y-m-d'),1).'</td>';
		echo '<td>'.$val['total_active_rate'].'</td>';
		echo '<td>'.$val['client_message_length'].'</td>';
		echo '<td>'.$val['health_coach_message_length'].'</td>';
		if($display['post']['consultant_role']==2){
		echo '<td>'.$display['list']['consultant'][$val['client_consultant_id']].'</td>';
		}else{
		echo '<td>'.$display['list']['consultant'][$val['client_health_coach_id']].'</td>';
		}
        echo '</tr>';
    }
?>	
	</table>
<p style="padding:10px;">
*1 Total contract period
*2 Total Active rate
*3 Client message length
*4 Health Coach message length
</p>
	</div>
	
	
    <?php }else{ ?>
    <?php $p->print_conf() ?>
    <div class="btnBox">
    <input type="button" class="btn" onclick="sendForm('back','<?php echo  $display['post']['consultant_id'] ?>')" value="Back" />
    <input type="button" class="btn2" onclick="sendForm('comp','<?php echo  $display['post']['consultant_id'] ?>')" value="Complete" />
    </div>
    <?php } ?>
    </form>
</div>
<?php $p->print_footer() ?>
