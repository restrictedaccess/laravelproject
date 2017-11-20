<?php $p=new page(); ?>
<?php $m=new main(); ?>
<?php $p->print_meta($display['list']['consultant_role'][$display['post']['consultant_role']]) ?>
</head>
<body>
<div id="mainBox">
    <form action="?" method="post" name="form1" id="form1" >
    <h2><?php echo $display['list']['consultant_role'][$display['post']['consultant_role']];?></h2>
    <input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="consultant_id" value="" />
    <input type="hidden" name="client_id" value="<?php echo $display['post']['client_id']?>" />
    <input type="hidden" name="consultant_role" value="<?php echo $display['post']['consultant_role']?>" />
    <?php $p->print_search() ?>
    <?php if($display['data']['list']){ ?>
    <div class="navi"><?php echo $display['data']['navi'] ?></div>
<div class="listTable">
<?php
$i=0;
if($display['data']['list']){
    echo '<table>
	<tr>
	<th>Name[ID]</th>
	<th>Age</th>
	<th>Applicant state</th>
	<th>Entry Date</th>
	<th>Number of clients in charge</th>
	<th>State</th>
	<th>Assign</th>
	</tr>
	';
    foreach($display['data']['list'] as $key => $val){
        echo '<tr>';
        echo '<td>';
		echo '<p>'.$val['consultant_first_name'].' '.$val['consultant_last_name'].'['.$val['consultant_id'].']</p>';
		echo '</td>';
		echo '<td>'.$m->age($val['consultant_birthday']).'</td>';
        echo '<td>'.$display['list']['consultant_status'][$val['consultant_status']].'</td>';
		echo '<td>'.$m->utc($val['consultant_create_time'],$val['consultant_time_zone']).'</td>';
		echo '<td>'.$val['clients_count'].'</td>';
		echo '<td>'.$val['consultant_state'].'</td>';
		echo '<td onClick="sendForm(\'assign\','.$val['consultant_id'].')" class="delete_bt"><img src="/admin_2ka6b5k6/images/add_bt.png" alt="assign"></td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
</div>
    <?php } ?>
    </form>
</div>

</body>
</html>