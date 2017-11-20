<?php
$admin = new admin();
$admin->admin_check();
$dbHelper = new DbHelper();
$dbHelper->open();

$p=new page();
$m=new main();

if($display['get']['id']){
	$display['post']['activity_client_id']=$display['get']['id'];
}
if(!$_POST){
	$display['post']['activity_create_date_s']=date("Y-m-d", strtotime("-7 day"));
	$display['post']['activity_create_date_e']=date('Y-m-d', strtotime("-1 day"));
}

$params = $dbHelper->sanitize($display['post']);
$display['keyArr']=array(
 'activity_client_id'=>array('name'=>'ID','input'=>'hidden','search'=>'hidden','check'=>array('checkMust'))
,'activity_create_date'=>array('name'=>'Create Date','input'=>'print','search'=>'date','check'=>array(''))
,'activity_week_comment'=>array('name'=>'Comment from Health coach','input'=>'text','check'=>array())
);

if(!$params['page']){
	$params['page']=1;
}

if($display['post']['mode']=='search'){
	$display['err']=$m->check($display['keyArr'],$params,1);
	if(!$display['err']){
		$_SESSION['src']['client_report']=$params;
//		$m->location('client_report.html');
	}
}elseif($display['post']['mode']=='reset'){
	unset($_SESSION['src']['client_report']);
//	$m->location('client_report.html');
}elseif($display['post']['mode']=='comp'){
	
	$display['err']=$m->check($display['keyArr'],$params);
	if(!$display['err']){

		$where='';
		$where['client_id']=$params['activity_client_id'];
		$maildata=$dbHelper->sql_get_one2('*','client',$where);

		$_SESSION['src']['client_report']=$params;
		$where='';
		$where=$m->searchWhere($display['keyArr'],$params);
		$where['activity_photo !=']='';
		$where['activity_type']='1';
		$res=$dbHelper->sql_get_select('activity',$where,'activity_create_time');
		$list='';
		foreach($res as $k => $v){
			$date=date("D., M. j", strtotime($v['activity_create_date']));
			$list[$date][]=$v['activity_photo'];
		}
		$maildata['activity_photo']='<div class="photoBox">';
		foreach($list as $key => $val){
			$maildata['activity_photo'].= '<h2>'.$key.'</h2>';
			$maildata['activity_photo'].= '<p>';
			foreach($val as $v){
				$maildata['activity_photo'].= '<img src="'.$v.'" style="max-height:100px; max-width:100px;">';
			}
			$maildata['activity_photo'].= '</p>';
		}
		$maildata['activity_photo'].='</div>';
		if($params['activity_week_comment']){
			$params['activity_week_comment']='<strong>Comment from Health coach</strong><br><p>'.str_replace(array('\r\n','\r','\n'), "<br>", $params['activity_week_comment']).'</p>';
		}
		$maildata['activity_week_comment']=$params['activity_week_comment'];
		$title='Brainsalvation report ['.date("D., M. j", strtotime($params['activity_create_date_s'])).' - '.date("D., M. j", strtotime($params['activity_create_date_e'])).']';
		$maildata['title']=$title;
		
		$body=$m->mailBody('weekly_report',$maildata);
		
		$bcc[]=MAIL;
		if($maildata['client_consultant_id']){
			$where='';
			$where['consultant_id']=$maildata['client_consultant_id'];
			if($res=$dbHelper->sql_get_one('consultant_email','consultant',$where)){
				$bcc[]=$res;
			}
		}
		if($maildata['client_health_coach_id']){
			$where='';
			$where['consultant_id']=$maildata['client_health_coach_id'];
			if($res=$dbHelper->sql_get_one('consultant_email','consultant',$where)){
				$bcc[]=$res;
			}
		}

		$m->sendmailHtml($maildata['client_email'],$title,$body,$bcc);

		$_SESSION['tab']=2;
		$_SESSION['alert']='edit complete!';
	$display['err']['alert']='
<script type="text/javascript">
<!--
parent.location.reload();
// -->
</script>';
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
		$_SESSION['src']['client_report']=$params;
		$where=$m->searchWhere($display['keyArr'],$params);
		$where['activity_photo !=']='';
		$res=$dbHelper->sql_get_select('activity',$where);
		$list='';
		foreach($res as $k => $v){
			$date=date("D., M. j", strtotime($v['activity_create_date']));
			$list[$date][]=$v['activity_photo'];
		}
		$display['data']['list']=$list;
	}
	$p->gf_rendering("client_report.php");
}

if(!$params['mode']){
	$params['mode']='search';
}

$display['err']=$m->check($display['keyArr'],$params,1);
if(!$display['err']){
	$_SESSION['src']['client_report']=$params;
	$where=$m->searchWhere($display['keyArr'],$params);
	$where['activity_photo !=']='';
	$where['activity_type']='1';
	$res=$dbHelper->sql_get_select('activity',$where);
	$list='';
	foreach($res as $k => $v){
		$date=date("D., M. j", strtotime($v['activity_create_date']));
		$list[$date][]=$v['activity_photo'];
	}
	$display['data']['list']=$list;
}
$p->gf_rendering("client_report.php");
?>