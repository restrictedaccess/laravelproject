<?php $p=new page(); $m=new main(); ?>
<?php $p->print_meta('Dashboard') ?>
<?php $p->print_header() ?>
<div id="mainBox">
<div class="pNavi">
<a href="index.html">HOME</a>
</div>
<h2>Dashboard</h2>
<div class="listTable">
<?php
if($display['data']['alert_err']){
	echo '<h3>Alert List</h3>';
	echo '<table>
	<tr>
	<th>campaign</th>
	<th>medium</th>
	<th>source</th>
	<th>error</th>
	<th>count</th>
	</tr>';
	foreach($display['data']['alert_err'] as $k1 => $v1){
		foreach($v1 as $k2 => $v2){
		foreach($v2 as $k3 => $v3){
		foreach($v3 as $k4 => $v4){
			echo '<tr>
			<td>'.$k1.'</td>
			<td>'.$k2.'</td>
			<td>'.$k3.'</td>
			<td>'.$display['list']['alert_err'][$k4].'</td>
			<td>'.$v4.'</td>
			</tr>';
		}
		}
		}
	}
	
	echo '</table>';
}
?>

<h3>Client List<?php if($display['session']['user_role_id']==1){ echo '(Waiting assign Nutrition Consultant)'; }?></h3>
<?php
$i=0;
if($display['data']['client']){
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
	</tr>
	';
    foreach($display['data']['client'] as $key => $val){
		$i++;
        echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$val['client_id'].'</td>';
        echo '<td class="selLink" onClick="location.href=\'client.html?id='.$val['client_id'].'\'">';
		echo '<p>'.$val['client_first_name'].' '.$val['client_last_name'].'</p>';
		echo '</td>';
        echo '<td>'.$display['list']['client_status'][$val['client_status']].'</td>';
		echo '<td>'.$m->utc($val['client_create_time'],$val['client_time_zone']).'</td>';
		echo '<td>'.$display['list']['consultant'][$val['client_consultant_id']].'</td>';
		echo '<td>'.$display['list']['consultant'][$val['client_health_coach_id']].'</td>';
		echo '<td>'.$m->time_diff(date('Y-m-d'),$val['client_terms_end'],1).'</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
</div>

</div>
<?php $p->print_footer() ?>
