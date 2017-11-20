<?php
$admin = new admin();
$admin->admin_check(1);
$dbHelper = new DbHelper();
$dbHelper->open();

$p=new page();
$m=new main();

if($display['get']['id']){
	$display['post']['consultant_id']=$display['get']['id'];
	$display['post']['mode']='edit';
}
$params = $dbHelper->sanitize($display['post']);
$display['keyArr']=array(
 'consultant_id'=>array('name'=>'ID','input'=>'print','search'=>'range','check'=>array(''))
,'consultant_role'=>array('name'=>'Role','input'=>'select','search'=>'check','check'=>array('checkMust','checkNumStr'))
,'consultant_create_time'=>array('name'=>'Entry Date','input'=>'print','search'=>'date','check'=>array(''))
,'consultant_update_time'=>array('name'=>'Update Date','input'=>'print','search'=>'date','check'=>array(''))
,'consultant_status'=>array('name'=>'Status','input'=>'select','search'=>'check','check'=>array('checkMust','checkNumStr'))
,'consultant_cancellation_reason'=>array('name'=>'Cancellation reason','input'=>'mtext','check'=>array(''))
,'consultant_memo'=>array('name'=>'Memo','input'=>'text','check'=>array(''))
,'Individual'=>array('name'=>'Individual','input'=>'title','check'=>array())
,'consultant_first_name'=>array('name'=>'First name','input'=>'mtext','search'=>'mtext','check'=>array('checkMust'))
,'consultant_last_name'=>array('name'=>'Last name','input'=>'mtext','search'=>'mtext','check'=>array('checkMust'))
,'consultant_email'=>array('name'=>'email','search'=>'text','input'=>'ltext','check'=>array('checkMust','checkMail'))
,'consultant_mobile_no'=>array('name'=>'Mobile Phone','input'=>'mtext','search'=>'text','check'=>array('checkMust','checkNum'))
,'consultant_skype_account'=>array('name'=>'Skype Account (Phone Number)','input'=>'mtext','search'=>'','check'=>array('checkMust','checkNum'))
,'consultant_birthday'=>array('name'=>'Date of birth','input'=>'date','check'=>array('checkDate'))
,'consultant_chat_work_account'=>array('name'=>'Chat work account (Email)','search'=>'text','input'=>'ltext','check'=>array('checkMail'))
,'consultant_address1'=>array('name'=>'address1','input'=>'add','check'=>array('checkMust'))
,'consultant_address2'=>array('name'=>'address2','input'=>'add','check'=>array())
,'consultant_city'=>array('name'=>'city','input'=>'add','check'=>array('checkMust'))
,'consultant_state'=>array('name'=>'state','input'=>'add','check'=>array('checkMust'))
//,'consultant_country'=>array('name'=>'country','input'=>'add','check'=>array('checkMust'))
,'consultant_zip_code'=>array('name'=>'zipcode','input'=>'zip','check'=>array('checkMust'))
,'consultant_login_id'=>array('name'=>'login id','input'=>'mtext','min'=>6,'check'=>array('checkMust','checkMailStr','checkLoginID','checkLength'))
,'consultant_password'=>array('name'=>'password','input'=>'password','min'=>6,'check'=>array('checkMust','checkNumStr','checkLength'))
,'consultant_qcualification'=>array('name'=>'Qualification','input'=>'mtext','check'=>array('checkMust'))
,'consultant_copy_submitted'=>array('name'=>'Qualification copy submitted','input'=>'radio','check'=>array('checkMust'))
,'consultant_w9'=>array('name'=>'W9','input'=>'radio','check'=>array(''))
,'consultant_experiense'=>array('name'=>'Experiense','input'=>'text','check'=>array(''))
,'consultant_self_introduction'=>array('name'=>'Self-introduction (200 characters or less）','input'=>'text','check'=>array('checkLength'),'max'=>200)
);
$display['list']['consultant_w9']=$display['list']['consultant_copy_submitted'];

if(!$params['page']){
	$params['page']=1;
}

if($params['consultant_id']){
	$where='';
	if($res=$dbHelper->sql_get_low2('concat(consultant_first_name," ",consultant_last_name)','consultant')){
		$display['list']['consultant']=$res;
	}

	$where='';
	$where['consultant_id']=$params['consultant_id'];
	$consultant_role=$dbHelper->sql_get_one('consultant_role','consultant',$where);

	$where='';
	if($consultant_role==1){
		$where['client_consultant_id']=$params['consultant_id'];
	}else{
		$where['client_health_coach_id']=$params['consultant_id'];
	}
	if($res2=$dbHelper->sql_get_select('client',$where,'client_id desc')){
		$display['data']['client_list']=$res2;
		foreach($res2 as $k => $v){
			$where='';
			$where['activity_client_id']=$v['client_id'];
			$where['activity_photo !=']='';
			$where['activity_type']='1';
			if($res=$dbHelper->sql_get_select('activity',$where,'activity_create_time','activity_create_date')){
				$display['data']['client_list'][$k]['total_active_rate']=floor(count($res)/$m->time_diff(date("Y-m-d", strtotime($v['client_create_time']." -1 day")),date('Y-m-d'),2)*100).'%';
			}else{
				$display['data']['client_list'][$k]['total_active_rate']='0%';
			}
			
			$where='';
			$where['activity_client_id']=$v['client_id'];
			if($res=$dbHelper->sql_get_select('activity',$where,'activity_create_time')){
				foreach($res as $val){
					$len[$val['activity_type']][]=mb_strlen($val['activity_comment']);
				}
			}
			if($len[1]){
				$t=0;
				foreach($len[1] as $val){
					$t+=$val;
				}
				$display['data']['client_list'][$k]['client_message_length']=round($t/count($len[1]));
			}
			if($len[2]){
				$t=0;
				foreach($len[2] as $val){
					$t+=$val;
				}
				$display['data']['client_list'][$k]['health_coach_message_length']=round($t/count($len[2]));
			}
		}
	}
}

if($display['post']['mode']=='delete'){
	$where='';
	$where['consultant_id']=$params['consultant_id'];
	if($display['err']){
		$_SESSION['alert']=$display['err'];
	}else{
		$return=$dbHelper->sql_delete_contents('consultant',$params['consultant_id']);
		$_SESSION['alert']='delete complete!';
	}
	$m->location('consultant.html');
}elseif($display['post']['mode']=='back'){
	$p->gf_rendering("consultant_form.php");
}elseif($display['post']['mode']=='add'){
	$display['post']['consultant_birthday']='1970-01-01';
	$p->gf_rendering("consultant_form.php");
}elseif($display['post']['mode']=='edit'){
	$res=$dbHelper->sql_get_contents('consultant',$params['consultant_id']);
	foreach($display['keyArr'] as $k => $v){
		if($v['input']=='other'){
			$res['contents'][$k]=explode('/',$res['contents'][$k]);
		}
		if($v['input']=='password'){
			$res['contents'][$k]='dummy123';
		}
	}
	$display['post']=$res['contents'];
	$p->gf_rendering("consultant_form.php");
}elseif($display['post']['mode']=='conf'){
	if($display['err']=$m->check($display['keyArr'],$params)){
		$display['err']['alert']=$p->makeErr($display['err']);
	}else{
		$display['post']['mode']='checked';
	}
	$p->gf_rendering("consultant_form.php");
}elseif($display['post']['mode']=='comp'){
	$display['err']=$m->check($display['keyArr'],$params);
	if(!$display['err']){
		$return=$dbHelper->sql_send('consultant',$m->createParams($display['keyArr'],$params),'consultant_id');
		if($return['insert_id']){
			$params['consultant_id']=$return['insert_id'];
		}
		$_SESSION['alert']='edit complete!';
		$m->location('consultant.html');
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}
}elseif($display['post']['mode']=='search'){
	$display['err']=$m->check($display['keyArr'],$params,1);
	if(!$display['err']){
		$_SESSION['src']['consultant_list']=$params;
		$m->location('consultant.html');
	}
}elseif($display['post']['mode']=='reset'){
	unset($_SESSION['src']['consultant_list']);
	$m->location('consultant.html');
}

$params=$display['session']['src']['consultant_list'];
$display['post']=$display['session']['src']['consultant_list'];
if(!$params['mode']){
	$params['mode']='search';
}

$display['err']=$m->check($display['keyArr'],$params,1);
if(!$display['err']){
	$_SESSION['src']['consultant_list']=$params;
	$where=$m->searchWhere($display['keyArr'],$params);
	$list=$dbHelper->sql_get_list('consultant',$where);
	$display['data']['list']=$list['list'];
	$display['data']['navi']=$p->makeNavi($params['page'],$list['count']);
}
$p->gf_rendering("consultant_list.php");
?>