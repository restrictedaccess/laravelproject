<?php
$admin = new admin();
$admin->admin_check();
$dbHelper = new DbHelper();
$dbHelper->open();

$p=new page();
$m=new main();

if($display['get']['id']){
	$display['post']['consultant_role']=$display['get']['type'];
	$display['post']['client_id']=$display['get']['id'];
}

$params = $dbHelper->sanitize($display['post']);
$display['keyArr']=array(
 'consultant_id'=>array('name'=>'ID','input'=>'print','search'=>'range','check'=>array(''))
,'client_id'=>array('name'=>'ID','input'=>'hidden','search'=>'','check'=>array(''))
,'consultant_role'=>array('name'=>'consultant_role','input'=>'hidden','search'=>'','check'=>array(''))
,'consultant_status'=>array('name'=>'Status','input'=>'select','search'=>'check','check'=>array('checkMust','checkNumStr'))
,'consultant_first_name'=>array('name'=>'First name','input'=>'mtext','search'=>'mtext','check'=>array('checkMust'))
,'consultant_last_name'=>array('name'=>'Last name','input'=>'mtext','search'=>'mtext','check'=>array('checkMust'))
,'consultant_email'=>array('name'=>'email','search'=>'text','input'=>'ltext','check'=>array('checkMust','checkMail'))
,'consultant_mobile_no'=>array('name'=>'Mobile Phone','input'=>'tel','search'=>'','check'=>array('checkTel'))
,'consultant_skype_account'=>array('name'=>'Skype Account (Phone Number)','input'=>'tel','search'=>'','check'=>array('checkTel'))
,'consultant_address1'=>array('name'=>'consultant_address1','input'=>'add','check'=>array())
,'consultant_address2'=>array('name'=>'consultant_address2','input'=>'add','check'=>array())
,'consultant_city'=>array('name'=>'consultant_city','input'=>'add','check'=>array())
,'consultant_state'=>array('name'=>'consultant_state','search'=>'text','input'=>'add','check'=>array())
,'consultant_country'=>array('name'=>'consultant_state','input'=>'add','check'=>array())
,'consultant_zip_code'=>array('name'=>'zipcode','input'=>'zip','check'=>array())
,'consultant_birthday'=>array('name'=>'Date of birth','input'=>'date','check'=>array('checkDate'))
,'consultant_age'=>array('name'=>'Age','input'=>'print','search'=>'','check'=>array(''))
,'consultant_login_id'=>array('name'=>'login id','input'=>'mtext','check'=>array('checkMust','checkNumStr','checkLoginID'))
,'consultant_password'=>array('name'=>'password','input'=>'password','check'=>array('checkMust','checkNumStr'))
,'consultant_cualification'=>array('name'=>'Qualification','input'=>'mtext','check'=>array(''))
,'consultant_copy_submitted'=>array('name'=>'Copy submitted','input'=>'radio','check'=>array(''))
,'consultant_w9'=>array('name'=>'W9','input'=>'radio','check'=>array(''))
,'consultant_experiense'=>array('name'=>'Experiense','input'=>'text','check'=>array(''))
,'consultant_memo'=>array('name'=>'Memo','input'=>'text','check'=>array(''))
,'consultant_create_time'=>array('name'=>'Entry Date','input'=>'print','search'=>'date','check'=>array(''))
,'consultant_update_time'=>array('name'=>'Update Date','input'=>'print','search'=>'date','check'=>array(''))
);
$display['keyArr2']=array(
 'client_id'=>array('name'=>'ID','input'=>'print','search'=>'','check'=>array('checkMust','checkNum'))
,'consultant_id'=>array('name'=>'consultant_id','input'=>'print','search'=>'','check'=>array('checkMust','checkNum'))
,'consultant_role'=>array('name'=>'type','input'=>'print','search'=>'','check'=>array('checkMust','checkNum'))
,'client_consultant_id'=>array('name'=>'client_consultant_id','input'=>'print','search'=>'','check'=>array())
,'client_health_coach_id'=>array('name'=>'client_health_coach_id','input'=>'print','search'=>'','check'=>array())
,'client_consultant_booking_date'=>array('name'=>'client_consultant_id','input'=>'print','search'=>'','check'=>array())
,'client_health_coach_booking_date'=>array('name'=>'client_health_coach_id','input'=>'print','search'=>'','check'=>array())
);

$display['list']['consultant_copy_submitted']=$display['list']['client_alert_check'];
$display['list']['consultant_w9']=$display['list']['client_alert_check'];

if(!$params['page']){
	$params['page']=1;
}

if($display['post']['mode']=='search'){
	$display['err']=$m->check($display['keyArr'],$params,1);
	if(!$display['err']){
		$_SESSION['src']['client_assign']=$params;
//		$m->location('client_assign.html');
	}
}elseif($display['post']['mode']=='reset'){
	unset($_SESSION['src']['client_assign']);
//	$m->location('client_assign.html');
}elseif($display['post']['mode']=='assign'){
	
	$display['err']=$m->check($display['keyArr2'],$params);
	if(!$display['err']){
		if($params['consultant_role']==1){
			$params['client_consultant_id']=$params['consultant_id'];
			$params['client_consultant_booking_date']=date('Y-m-d');
		}else{
			$params['client_health_coach_id']=$params['consultant_id'];
			$params['client_health_coach_booking_date']=date('Y-m-d');
		}
		$return=$dbHelper->sql_send('client',$m->createParams($display['keyArr2'],$params),'client_id');

		$where='';
		$where['consultant_id']=$params['consultant_id'];
		$consultant=$dbHelper->sql_get_one2('*','consultant',$where);

		$where='';
		$where['client_id']=$params['client_id'];
		$client=$dbHelper->sql_get_one2('*','client',$where);
		
		$maildata=$consultant+$client;
		$maildata['consultant_type']=$display['list']['consultant_role'][$maildata['consultant_role']];
		
		if($params['consultant_role']==1){
			$title='[bs] Assignment Consultation / '.$maildata['client_first_name'].' '.$maildata['client_last_name'].'['.$maildata['client_id'].']';
			$maildata['title']=$title;
			$maildata['client_url']=AHOST.'consultant/client.html?id='.$params['client_id'];
			
			$body=$m->mailBody('notify',$maildata);
			$m->sendmail($maildata['consultant_email'],$title,$body);
			
		}else{
			$title='[bs] Assignment Health Coach / '.$maildata['client_first_name'].' '.$maildata['client_last_name'].'['.$maildata['client_id'].']';
			$maildata['title']=$title;
			$maildata['client_url']=AHOST.'health_coach/client.html?id='.$params['client_id'];
			$body=$m->mailBody('notify',$maildata);
			$m->sendmail($maildata['consultant_email'],$title,$body);
			
			if($client['client_consultant_id']){
				$where='';
				$where['consultant_id']=$client['client_consultant_id'];
				if($consultant_email=$dbHelper->sql_get_one('consultant_email','consultant',$where)){
					$maildata['client_url']=AHOST.'consultant/client.html?id='.$params['client_id'];
					$body=$m->mailBody('notify',$maildata);
					$m->sendmail($consultant_email,$title,$body);
				}
			}
		}
		$maildata['client_url']=AHOST.'manager/client.html?id='.$params['client_id'];
		$body=$m->mailBody('notify',$maildata);

		$m->sendmail(MAIL,$title,$body);
		$_SESSION['tab']=1;
		$_SESSION['alert']='edit complete!';
	$display['err']['alert']='
<script type="text/javascript">
<!--
parent.location.reload();
// -->
</script>';
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}
	$p->gf_rendering("client_assign.php");
}

if(!$params['mode']){
	$params['mode']='search';
}

$display['err']=$m->check($display['keyArr'],$params,1);
if(!$display['err']){
	$_SESSION['src']['client_assign']=$params;
	$where=$m->searchWhere($display['keyArr'],$params);
	if($display['post']['consultant_role']==1){
		$where['consultant_role']=1;
	}else{
		$where['consultant_role']=2;
	}
	$list=$dbHelper->sql_get_list('consultant',$where);
	$display['data']['list']=$list['list'];
	foreach($display['data']['list'] as $key => $val){
		$where='';
		if($display['post']['consultant_role']==1){
			$where['client_consultant_id']=$val['consultant_id'];
		}else{
			$where['client_health_coach_id']=$val['consultant_id'];
		}
		$display['data']['list'][$key]['clients_count']=$dbHelper->sql_get_count('client',$where);
		
	}
	$display['data']['navi']=$p->makeNavi($params['page'],$list['count']);
}
$p->gf_rendering("client_assign.php");
?>