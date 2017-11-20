<?php $p=new page(); $m=new main(); ?>
<?php $p->print_meta('client edit') ?>
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link href="/plugin/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="/plugin/jquery-ui/base/jquery.ui.all.css">
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(function() {
	$('.fancybox').fancybox();
	$( ".date" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('.tabBox .content li').css('display','none');
	$('.tabBox .content li').eq(<?php echo (int)$display['session']['tab'];?>).css('display','block');
	$('.tabBox .tab li').eq(<?php echo (int)$display['session']['tab'];?>).addClass('select')
});
</script>
<?php $p->print_header() ?>
<div id="mainBox">
    <div class="pNavi">
    <a href="index.html">HOME</a> &gt; <a href="client.html">client</a>
    </div>
    <h2>client<?php if($display['post']['client_id']){ echo ' - '.$display['post']['client_first_name'].' '.$display['post']['client_last_name'].'['.$display['post']['client_id'].']'; } ?></h2>
    <form action="?" method="post" name="form1" id="form1" enctype="multipart/form-data">
	<input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
    <input type="hidden" id="mode" name="mode" value="" />
    <input type="hidden" id="id" name="client_id" value="<?php echo  $display['post']['client_id'] ?>" />
    <?php if($display['post']['mode']!='checked'){ ?>
<?php if($display['post']['client_id']){ ?>
	<div class="tabBox">
	<ul class="tab">
	<li>Client Detail</li>
	<li>Activity Report</li>
	<li>Dietary Activity</li>
	</ul>
	<ul class="content">
	<li>
<?php } ?>	
<p style="font-size:12px; color:#ed6755">Note: For members who want to change their profile data (e.g email address or contact number), ask them to send the information at info_diet@brainsalvation.com</p>
<?php if($display['session']['user_role_id']==1){ ?>
    <div class="btnBox">
    <input type="button" class="btn" style="font-size:24px;" onclick="sendForm('conf','<?php echo  $display['post']['client_id'] ?>')" value="Confirmation" />
    </div>
<?php } ?>	
	<h3>Demographics</h3>
    <?php $p->print_form() ?>
<?php if($display['session']['user_role_id']==1){ ?>
    <div class="btnBox">
    <input type="button" class="btn" style="font-size:24px;" onclick="sendForm('conf','<?php echo  $display['post']['client_id'] ?>')" value="Confirmation" />
    </div>
<?php } ?>	
<?php if($display['post']['client_id']){ ?>
	</li>
	<li>
	<h3>Status</h3>
	<div class="table">
	<div class="tr">
	<div class="th">Status<span>*</span><p>Please update the status when your task has been completed</p></div>
	<div class="td">
	<select name="client_status">
	<?php 
	foreach($display['list']['client_status'] as $k =>$v){
		echo '<option value="'.$k.'" '.$m->Selected($k,$display['post']['client_status']).'>'.$v.'</option>';
	}
	?>
	</select> <input type="button" class="btn2" value="submit" onClick="sendForm('status',<?php echo  $display['post']['client_id'] ?>);">
	</div>
	</div>
	<br clear="all">
	</div>
	
	<h3>Actiivity</h3>
	<div class="table">
	<div class="tr">
	<div class="th">Total contract period</div>
	<div class="td"><?php echo $m->time_diff(date("Y-m-d", strtotime($display['post']['client_create_time']." -1 day")),date('Y-m-d'),1); ?></div>
	</div>
	<div class="tr">
	<div class="th">Remaining Days(s)</div>
	<div class="td"><?php echo $m->time_diff(date('Y-m-d'),$display['post']['client_terms_end'],1); ?></div>
	</div>
	<div class="tr">
	<div class="th">Total Active rate</div>
	<div class="td"><?php echo $display['data']['total_active_rate']?></div>
	</div>
	<div class="tr">
	<div class="th">Total photo</div>
	<div class="td"><?php echo (int)$display['data']['total_photo']?></div>
	</div>
	<div class="tr">
	<div class="th">Client message length</div>
	<div class="td"><?php echo (int)$display['data']['client_message_length']?></div>
	</div>
<?php if($display['session']['user_role_id']==1){ ?>
	<div class="tr">
	<div class="th">Health Coach message length</div>
	<div class="td"><?php echo (int)$display['data']['health_coach_message_length']?></div>
	</div>
<?php } ?>
	<br clear="all">
	</div>
	
	<div class="listTable">
	<h3>Week activity (Last 12 weeks)</h3>
	<table>
	<tr>
	<th>week</th><th>photo</th><th>Active rate</th>
	</tr>
	<?php
    foreach($display['data']['week_activity'] as $k => $v){
		echo '<tr>';
		echo '<td>'.$v['week'].'</td>';
		echo '<td>'.$v['photo'].'</td>';
		echo '<td>'.$v['rate'].'</td>';
		echo '</tr>';
	}
	?>
	</table>
	
	<h3 id="memo3">Goal <a class="fancybox fancybox.iframe btn2" href="client_memo.html?id=<?php echo $display['post']['client_id']?>&type=3">create</a><span>[Notice will be sent to interested parties]</span></h3>
	<table>
	<tr>
	<th>Date</th><th>Type</th><th>Description</th>
	</tr>
	<?php
    foreach($display['data']['memo3'] as $k => $v){
		echo '<tr>';
		echo '<td>'.$v['memo_date'].'</td>';
		echo '<td>'.$display['list']['memo_type'][$v['memo_type']].'</td>';
		echo '<td>'.$v['memo_description'].'</td>';
		echo '</tr>';
	}
	?>
	</table>
	
	<h3 id="client_assign">Consultant and Health Coach<span>[Notice will be sent to interested parties]</span></h3>
	<table>
		<tr>
			<th scope="col"></th>
			<th scope="col">ID</th>
			<th scope="col">Name</th>
			<th scope="col">Booking Date</th>
		</tr>
		<tr>
			<th rowspan="2" scope="row">Consultant<?php if($display['session']['user_role_id']==1){ ?><br><a class="fancybox fancybox.iframe btn" href="client_assign.html?id=<?php echo $display['post']['client_id']?>&type=1">edit</a> <a href="#" class="btn2" onClick="sendForm('consultant_delete',<?php echo  $display['post']['client_id'] ?>);">delete</a><?php } ?></th>
			<td><?php echo $display['post']['client_consultant_id'];?></td>
			<td><?php echo $display['list']['consultant'][$display['post']['client_consultant_id']];?></td>
			<td><?php echo $display['post']['client_consultant_booking_date'];?></td>
		</tr>
		<tr>
			<td colspan="3"><?php echo $display['list']['consultant_self_introduction'][$display['post']['client_consultant_id']];?></td>
		</tr>
		<tr>
			<th rowspan="2" scope="row">Health Coach<?php if($display['session']['user_role_id']==1){ ?><br><a class="fancybox fancybox.iframe btn" href="client_assign.html?id=<?php echo $display['post']['client_id']?>&type=2">edit</a>  <a href="#" class="btn2" onClick="sendForm('health_coach_delete',<?php echo  $display['post']['client_id'] ?>);">delete</a><?php } ?></th>
			<td><?php echo $display['post']['client_health_coach_id'];?></td>
			<td><?php echo $display['list']['consultant'][$display['post']['client_health_coach_id']];?></td>
			<td><?php echo $display['post']['client_health_coach_booking_date'];?></td>
		</tr>
		<tr>
			<td colspan="3"><?php echo $display['list']['consultant_self_introduction'][$display['post']['client_health_coach_id']];?></td>
		</tr>
	</table>
	
	<h3 id="memo4">Feedback from Consultant <a class="fancybox fancybox.iframe btn2" href="client_memo.html?id=<?php echo $display['post']['client_id']?>&type=4">create</a><span>[Notice will be sent to interested parties]</span></h3>
	<table>
	<tr>
	<th>Date</th><th>description</th>
	</tr>
	<?php
    foreach($display['data']['memo4'] as $k => $v){
		echo '<tr>';
		echo '<td>'.$v['memo_date'].'</td>';
		echo '<td>'.$v['memo_description'].'</td>';
		echo '</tr>';
	}
	?>
	</table>
	<?php if($display['session']['user_role_id']==1){ ?>
	<h3 id="memo1">memo1(for admin) <a class="fancybox fancybox.iframe btn2" href="client_memo.html?id=<?php echo $display['post']['client_id']?>&type=1">create</a><span>[Notice will be sent to interested parties]</span></h3>
	<table>
	<tr>
	<th>Date</th><th>description</th>
	</tr>
	<?php
    foreach($display['data']['memo1'] as $k => $v){
		echo '<tr>';
		echo '<td>'.$v['memo_date'].'</td>';
		echo '<td>'.$v['memo_description'].'</td>';
		echo '</tr>';
	}
	?>
	</table>
	<h3 id="memo2">memo2(for consultant and health coach) <a class="fancybox fancybox.iframe btn2" href="client_memo.html?id=<?php echo $display['post']['client_id']?>&type=2">create</a><span>[Notice will be sent to interested parties]</span></h3>
	<?php }else{ ?>
	<h3 id="memo2">memo <a class="fancybox fancybox.iframe btn2" href="client_memo.html?id=<?php echo $display['post']['client_id']?>&type=2">create</a></h3>
	<?php } ?>
	<table>
	<tr>
	<th>Date</th><th>description</th>
	</tr>
	<?php
    foreach($display['data']['memo2'] as $k => $v){
		echo '<tr>';
		echo '<td>'.$v['memo_date'].'</td>';
		echo '<td>'.$v['memo_description'].'</td>';
		echo '</tr>';
	}
	?>
	</table>
	</div>
	</li>
	<li><h3>Dietary Activity <?php if($display['data']['activity']){ echo '<a class="fancybox fancybox.iframe btn2" href="client_report.html?id='. $display['post']['client_id'].'&type=2">Weekly Report</a>'; }?></h3>
	<div class="commentBox">
	<?php
	$day='';
    foreach($display['data']['activity'] as $k => $v){
		$d=$m->utc($v['activity_create_time'],$display['post']['client_time_zone'],1);
		if($day!=$d){
			$day=$d;
			echo '<div class="day">'.$day.'</div>';
		}
		if($v['activity_type']==1){
		echo '<div class="lbox">';
		}else{
		echo '<div class="rbox">';
		}
		echo '<div class="comment'.$v['activity_type'].'">';
		echo '<div class="time">'.$m->utc($v['activity_create_time'],$display['post']['client_time_zone'],2).'</div>';
		if($v['activity_photo']){
			echo '<a class="fancybox fancybox.image" href="'.$v['activity_photo'].'"><span class="contain" style="background-image: url('.$v['activity_photo'].')"></span></a>';
		}
		if($v['activity_type']==3){
		echo '<p>away!</p>';
		}elseif($v['activity_type']==4){
		echo '<p>active!<br>Away time was '.$v['activity_comment'].'</p>';
		}else{
		echo '<p>'.$v['activity_comment'].'</p>';
		}
		if($v['activity_type']!=1 && $v['activity_consultant_id']){
			echo '<span>by '.$display['list']['consultant'][$v['activity_consultant_id']].'<span>';
		}
		echo '</div>';
		echo '</div>';
	}
	?>
	<br clear="all">
	</div>
	</li>
	</ul>
	</div>
<?php } ?>	
    <?php }else{ ?>
    <div class="btnBox">
    <input type="button" class="btn" onclick="sendForm('back','<?php echo  $display['post']['client_id'] ?>')" value="Back" />
    <input type="button" class="btn2" style="font-size:24px;" onclick="sendForm('comp','<?php echo  $display['post']['client_id'] ?>')" value="Complete" />
    </div>
    <?php $p->print_conf() ?>
    <div class="btnBox">
    <input type="button" class="btn" onclick="sendForm('back','<?php echo  $display['post']['client_id'] ?>')" value="Back" />
    <input type="button" class="btn2" style="font-size:24px;" onclick="sendForm('comp','<?php echo  $display['post']['client_id'] ?>')" value="Complete" />
    </div>
    <?php } ?>
    </form>
</div>
<?php $p->print_footer() ?>
