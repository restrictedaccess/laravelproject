<?php
$admin = new admin();
$admin->admin_check();
$dbHelper = new DbHelper();
$dbHelper->open();
$p = new page();
$m = new main();

if($res=$dbHelper->sql_get_low2('consultant_email','consultant')){
	$display['list']['consultant_email']=$res;
}
if($display['get']['st']==1){
	$params='';
	$params['consultant_status']=2;
	$params['consultant_id']=$display['session']['user_id'];
	$params['consultant_update_time']=date('Y-m-d H:i:s');
	$params['consultant_away_time']=date('Y-m-d H:i:s');
	$dbHelper->sql_send('consultant',$params,'consultant_id');
	
	$title='[bs]  Away / '.$display['session']['user_name'].'['.$display['session']['user_id'].']';
	$display['session']['title']=$title;
	$display['session']['consultant_url']='';
	if($display['session']['consultant_email']){
		$body=$m->mailBody('away',$display['session']);
		$m->sendmail($display['session']['consultant_email'],$title,$body);
	}
	if($display['session']['user_role_id']==2){
		$where='';
		$where['client_consultant_id']=$display['session']['user_id'];
		$res=$dbHelper->sql_get_low('client_health_coach_id','client',$where);
		foreach($res as $v){
			$m->sendmail($display['list']['consultant_email'][$v],$title,$body);
		}
	}
	if($display['session']['user_role_id']==3){
		$where='';
		$where['client_health_coach_id']=$display['session']['user_id'];
		$res=$dbHelper->sql_get_low('client_consultant_id','client',$where);
		foreach($res as $v){
			$m->sendmail($display['list']['consultant_email'][$v],$title,$body);
		}
	}

	$display['session']['consultant_url']=AHOST.'manager/consultant.html?id='.$display['session']['user_id'];
	$body=$m->mailBody('away',$display['session']);
	$m->sendmail(MAIL,$title,$body);
	
	$params='';
	$params['activity_type']=3;
	$params['activity_client_id']=0;
	$params['activity_consultant_id']=$display['session']['user_id'];
	$params['activity_create_time']=date('Y-m-d H:i:s');
	$params['activity_create_date']=date('Y-m-d H:i:s');
	$dbHelper->sql_send('activity',$params,'activity_id');
	
	$_SESSION['consultant_status']=2;
	$_SESSION['alert']='Away complete!';
	$m->location('index.html');
}elseif($display['get']['st']==2){
	$params='';
	$params['consultant_status']=1;
	$params['consultant_id']=$display['session']['user_id'];
	$params['consultant_update_time']=date('Y-m-d H:i:s');
	$dbHelper->sql_send('consultant',$params,'consultant_id');

	$title='[bs]  Active / '.$display['session']['user_name'].'['.$display['session']['user_id'].']';
	$display['session']['title']=$title;
	$display['session']['now']=date('Y-m-d H:i:s');
	
	$where='';
	$where['consultant_id']=$display['session']['user_id'];
	if($from=$dbHelper->sql_get_one('consultant_away_time','consultant',$where)){
		$display['session']['away_time']='Away time was '.$m->time_diff($from);
	}
	$body=$m->mailBody('active',$display['session']);
	if($display['session']['consultant_email']){
		$m->sendmail($display['session']['consultant_email'],$title,$body);
	}
	if($display['session']['user_role_id']==2){
		$where='';
		$where['client_consultant_id']=$display['session']['user_id'];
		$res=$dbHelper->sql_get_low('client_health_coach_id','client',$where);
		foreach($res as $v){
			$m->sendmail($display['list']['consultant_email'][$v],$title,$body);
		}
	}
	if($display['session']['user_role_id']==3){
		$where='';
		$where['client_health_coach_id']=$display['session']['user_id'];
		$res=$dbHelper->sql_get_low('client_consultant_id','client',$where);
		foreach($res as $v){
			$m->sendmail($display['list']['consultant_email'][$v],$title,$body);
		}
	}
	$m->sendmail(MAIL,$title,$body);

	$params='';
	$params['activity_type']=4;
	$params['activity_client_id']=0;
	$params['activity_comment']=$m->time_diff($from);
	$params['activity_consultant_id']=$display['session']['user_id'];
	$params['activity_create_time']=date('Y-m-d H:i:s');
	$params['activity_create_date']=date('Y-m-d H:i:s');
	$dbHelper->sql_send('activity',$params,'activity_id');

	$_SESSION['consultant_status']=1;
	$_SESSION['alert']='Active complete!';
	$m->location('index.html');	
}

$where='';
if($res=$dbHelper->sql_get_low2('concat(consultant_first_name," ",consultant_last_name)','consultant')){
	$display['list']['consultant']=$res;
}

$where='';
if($display['session']['user_role_id'] == '2'){
	$where['client_consultant_id']=$display['session']['user_id'];
}elseif($display['session']['user_role_id'] == '3'){
	$where['client_health_coach_id']=$display['session']['user_id'];
}else{
	$where['client_status']=1;
}
$display['data']['client']=$dbHelper->sql_get_select('client',$where,'client_create_time desc');

$where='';
if($display['session']['user_role_id'] == '1'){
	$where['alert_err_create_time >']=date("Y-m-d", strtotime("-6 month"));
	$res=$dbHelper->sql_get_select('alert_err',$where,'alert_err_err');
	foreach($res as $k => $v){
		$display['data']['alert_err'][$v['alert_err_utm_campaign']][$v['alert_err_utm_medium']][$v['alert_err_utm_source']][$v['alert_err_err']]+=1;
	}
}

$p->gf_rendering("index.php");
?>