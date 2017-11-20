<?php
$admin = new admin();
$admin->admin_check();
$dbHelper = new DbHelper();
$dbHelper->open();

$p=new page();
$m=new main();

if($display['get']['id']){
	$display['post']['client_id']=$display['get']['id'];
}
$params = $dbHelper->sanitize($display['post']);
if(!$params['page']){
	$params['page']=1;
}
$page=$params['page'];

$display['keyArr']=array(
 'client_id'=>array('name'=>'ID','input'=>'print','search'=>'range','sort'=>'asc','check'=>array(''))
,'client_status'=>array('name'=>'Status','input'=>'hidden','search'=>'check','check'=>array('checkMust','checkNumStr'))
,'client_first_name'=>array('name'=>'First name','input'=>'mtext','search'=>'text','check'=>array('checkMust'))
,'client_last_name'=>array('name'=>'Last name','input'=>'mtext','search'=>'text','check'=>array('checkMust'))
,'client_email'=>array('name'=>'email','search'=>'text','input'=>'ltext','check'=>array('checkMust','checkMail'))
,'client_mobile_no'=>array('name'=>'Mobile Phone','th'=>'<p>Do not use this phone number to send SMS/MMS</p>','input'=>'mtext','search'=>'text','check'=>array('checkMust','checkNum'))
,'client_skype_account'=>array('name'=>'Skype Account (Phone Number)','input'=>'mtext','search'=>'','check'=>array('checkNum'))
,'client_twilio_no'=>array('name'=>'Twilio Account (Phone Number)','th'=>'<p>Please use this number to dietary advice.</p>','input'=>'mtext','search'=>'text','check'=>array('checkNum'))
,'client_address1'=>array('name'=>'client_address1','input'=>'add','check'=>array())
,'client_address2'=>array('name'=>'client_address2','input'=>'add','check'=>array())
,'client_city'=>array('name'=>'client_city','input'=>'add','check'=>array())
,'client_state'=>array('name'=>'client_state','input'=>'add','check'=>array())
,'client_zip_code'=>array('name'=>'zipcode','input'=>'zip','check'=>array())
,'client_birthday'=>array('name'=>'Date of birth','input'=>'date','check'=>array('checkDate'))
,'client_age'=>array('name'=>'Age','input'=>'print','search'=>'','check'=>array(''))
,'client_gender'=>array('name'=>'Gender','input'=>'radio','check'=>array())
,'client_height'=>array('name'=>'Height','input'=>'unit','check'=>array(''))
,'client_height_unit'=>array('name'=>'Height Unit','input'=>'none','check'=>array())
,'client_weight'=>array('name'=>'Weight','input'=>'unit','check'=>array('checkNumStr'))
,'client_weight_unit'=>array('name'=>'Weight Unit','input'=>'none','check'=>array())
,'client_bmi'=>array('name'=>'BMI','input'=>'print','search'=>'','check'=>array(''))

,'medical_conditions'=>array('name'=>'Medical Conditions','input'=>'title','check'=>array())
,'client_why_chose'=>array('name'=>'Tell us why you chose Brainsalvation','input'=>'other','check'=>array())
,'client_why_chose_other_value'=>array('name'=>'client_why_other_value','input'=>'none','check'=>array())
,'client_health_concern'=>array('name'=>'Assistance with my current health concerns. Allow them to check.','input'=>'other','check'=>array())
,'client_health_concern_other_value'=>array('name'=>'client_health_concern_other_value','input'=>'none','check'=>array())
,'client_type_of_diet'=>array('name'=>'What type of diet do you currently follow','input'=>'other','check'=>array())
,'client_type_of_diet_other_value'=>array('name'=>'client_type_of_diet_other_value','input'=>'none','check'=>array())
,'client_allergies'=>array('name'=>'Client all food allergies.','input'=>'text','check'=>array())
,'client_happy_weight'=>array('name'=>'Are you happy with your current weight?','input'=>'radio','search'=>'','check'=>array())
,'client_goal_weight'=>array('name'=>'Goal weight','input'=>'unit','check'=>array('checkNumStr'))
,'client_goal_weight_unit'=>array('name'=>'Goal weight unit','input'=>'none','check'=>array())

,'hearing'=>array('name'=>'Hearing','input'=>'title','check'=>array())
,'client_activity_level'=>array('name'=>'What is your current activity level?','input'=>'select','search'=>'','check'=>array(''))
,'client_activity_choice'=>array('name'=>'What is your activity of choice? Select all that apply.','input'=>'other','search'=>'','check'=>array(''))
,'client_activity_choice_other_value'=>array('name'=>'client_activity_choice_other_value','input'=>'none','check'=>array())
//,'client_coach'=>array('name'=>'Which type of coach appeals to you most?','input'=>'select','search'=>'','check'=>array(''))
//,'client_expertise'=>array('name'=>'I prefer someone with more expertise in?','input'=>'select','search'=>'','check'=>array(''))
,'client_introduce'=>array('name'=>'Please take a moment to introduce yourself to your nutrition coach.','input'=>'text','search'=>'','check'=>array(''))
,'client_physical_level'=>array('name'=>'Would you like to increase your physical activity level?','input'=>'select','search'=>'','check'=>array(''))
);
if($display['session']['user_role_id']==1){
$display['keyArr']=$display['keyArr']+array(
 'admin_data'=>array('name'=>'Admin Data','input'=>'title','check'=>array())
,'client_create_time'=>array('name'=>'Entry Date','input'=>'time','search'=>'date','sort'=>'desc','check'=>array(''))
,'client_update_time'=>array('name'=>'Update Date','input'=>'time','search'=>'date','check'=>array(''))
,'client_time_zone'=>array('name'=>'Time Zone','input'=>'print','search'=>'','check'=>array(''))
,'client_ip_address'=>array('name'=>'IP Address','input'=>'print','search'=>'','check'=>array(''))
,'client_promotion_id'=>array('name'=>'Promotion ID','input'=>'mtext','check'=>array())
,'client_referer'=>array('name'=>'Referer','input'=>'print','check'=>array())
,'client_alert_check'=>array('name'=>'Alert Check','input'=>'radio','check'=>array())
,'client_invalid_mail'=>array('name'=>'Invalid E-mail','input'=>'mtext','check'=>array())
,'client_device'=>array('name'=>'Device','input'=>'print','search'=>'','check'=>array(''))
,'client_os'=>array('name'=>'OS','input'=>'print','search'=>'','check'=>array(''))
,'client_browser'=>array('name'=>'Browser','input'=>'print','search'=>'','check'=>array(''))

,'client_consultant_id'=>array('name'=>'consultant','input'=>'none','search'=>'select','sort'=>'asc','check'=>array(''))
,'client_health_coach_id'=>array('name'=>'health_coach','input'=>'none','search'=>'select','sort'=>'asc','check'=>array(''))
);
}
$display['keyArr']=$display['keyArr']+array(
 'subscription'=>array('name'=>'Subscription<span>[Notice will be sent to interested parties]</span>','input'=>'title','check'=>array())
,'client_price_plan'=>array('name'=>'Price Plan','input'=>'select','search'=>'','check'=>array(''))
,'client_terms_start'=>array('name'=>'Terms start day','input'=>'date','check'=>array('checkDate'))
,'client_terms_end'=>array('name'=>'Terms end day','input'=>'date','check'=>array('checkDate'))
);
if($display['session']['user_role_id']==1){
$display['keyArr']=$display['keyArr']+array(
 'client_stripe_customer_id'=>array('name'=>'Stripe CustomerID','input'=>'stripe','search'=>'','check'=>array(''))
);
}
$display['keyArr2']=array(
 'client_id'=>array('name'=>'ID','input'=>'print','search'=>'','check'=>array('checkMust','checkNum'))
,'client_status'=>array('name'=>'Status','input'=>'select','search'=>'','check'=>array('checkMust','checkNumStr'))
);
$display['keyArr3']=array(
 'client_id'=>array('name'=>'ID','input'=>'print','search'=>'','check'=>array('checkMust','checkNum'))
);


$display['list']['client_goal_weight_unit']=$display['list']['client_weight_unit'];

$where='';
if($res=$dbHelper->sql_get_low2('concat(consultant_first_name," ",consultant_last_name)','consultant')){
	$display['list']['consultant']=$res;
}
$where='';
$where['consultant_role']=1;
if($res=$dbHelper->sql_get_low2('concat(consultant_first_name," ",consultant_last_name)','consultant',$where)){
	$display['list']['client_consultant_id']=$res;
}
$where='';
$where['consultant_role']=2;
if($res=$dbHelper->sql_get_low2('concat(consultant_first_name," ",consultant_last_name)','consultant',$where)){
	$display['list']['client_health_coach_id']=$res;
}


if($res=$dbHelper->sql_get_low2('consultant_self_introduction','consultant')){
	$display['list']['consultant_self_introduction']=$res;
}

if($params['client_id']){
	$where='';
	$where['memo_class']=1;
	$where['memo_client_id']=$params['client_id'];
	if($res=$dbHelper->sql_get_select('memo',$where,'memo_date desc')){
		$display['data']['memo1']=$res;
	}
	$where='';
	$where['memo_class']=2;
	$where['memo_client_id']=$params['client_id'];
	if($res=$dbHelper->sql_get_select('memo',$where,'memo_date desc')){
		$display['data']['memo2']=$res;
	}
	$where='';
	$where['memo_class']=3;
	$where['memo_client_id']=$params['client_id'];
	if($res=$dbHelper->sql_get_select('memo',$where,'memo_date desc')){
		$display['data']['memo3']=$res;
	}
	
	$where='';
	$where['memo_class']=4;
	$where['memo_client_id']=$params['client_id'];
	if($res=$dbHelper->sql_get_select('memo',$where,'memo_date desc')){
		$display['data']['memo4']=$res;
	}
	
	$where='';
	$where['client_id']=$params['client_id'];
	if($res=$dbHelper->sql_get_one('client_consultant_id','client',$where)){
		$client_consultant[1]=$res;
	}
	$where='';
	$where['client_id']=$params['client_id'];
	if($res=$dbHelper->sql_get_one('client_health_coach_id','client',$where)){
		$client_consultant[2]=$res;
	}
	$or='';
	if($client_consultant){
		$or=' or activity_consultant_id in ('.implode(',',$client_consultant).')';
	}
	
	$where='';
	$where['activity_client_id in ']=array(0,$params['client_id']);
	$where['join']='(activity_type in (1,2)'.$or.')';
	
	if($res=$dbHelper->sql_get_select('activity',$where,'activity_create_time')){		
		$display['data']['activity']=$res;
		foreach($res as $v){
			$len[$v['activity_type']][]=mb_strlen($v['activity_comment']);
		}
		if($len[1]){
			$t=0;
			foreach($len[1] as $v){
				$t+=$v;
			}
			$display['data']['client_message_length']=round($t/count($len[1]));
		}
		if($len[2]){
			$t=0;
			foreach($len[2] as $v){
				$t+=$v;
			}
			$display['data']['health_coach_message_length']=round($t/count($len[2]));
		}
		
		foreach($res as $v){
			if($v['activity_type']==1 && $v['activity_photo']){
				$display['data']['total_photo']+=1;
				$w=floor($m->time_diff($v['activity_create_date'],date('Y-m-d'),2)/7);
				$wl[$w][$v['activity_create_date']]+=1;
			}
		}
		for($i=0;$i<=$w;$i++){
			$display['data']['week_activity'][$i]['week']=date("j-M", strtotime(" -".$i." week"));
			$display['data']['week_activity'][$i]['photo']=(int)array_sum($wl[$i]);
			$display['data']['week_activity'][$i]['rate']=floor((count($wl[$i])/7)*100).'%';
		}
		
		
	}
}

$_SESSION['tab']=0;

if($display['post']['mode']=='delete'){
	$where='';
	$where['client_id']=$params['client_id'];
	if($display['err']){
		$_SESSION['alert']=$display['err'];
	}else{
		$return=$dbHelper->sql_delete_contents('client',$params['client_id']);
		$_SESSION['alert']='delete complete!';
	}
	$m->location('client.html');
}elseif($display['post']['mode']=='back'){
	$p->gf_rendering("client_form.php");
}elseif($display['post']['mode']=='add'){
	$display['post']['client_birthday']='1970-01-01';
	$p->gf_rendering("client_form.php");
}elseif($display['post']['mode']=='status'){
	$display['err']=$m->check($display['keyArr2'],$params);
	if(!$display['err']){
		$return=$dbHelper->sql_send('client',$m->createParams($display['keyArr2'],$params),'client_id');
		$_SESSION['alert']='edit complete!';
		$_SESSION['tab']=1;
		$m->location('client.html?id='.$params['client_id']);
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}

}elseif($display['post']['mode']=='consultant_delete'){
	$display['err']=$m->check($display['keyArr3'],$params);
	if(!$display['err']){
		$sqlval='';
		$sqlval['client_id']=$params['client_id'];
		$sqlval['client_consultant_id']='NULL';
		$sqlval['client_consultant_booking_date']='NULL';
		$return=$dbHelper->sql_send('client',$sqlval,'client_id');
		$_SESSION['alert']='edit complete!';
		$_SESSION['tab']=1;
		$m->location('client.html?id='.$params['client_id']);
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}
}elseif($display['post']['mode']=='health_coach_delete'){
	$display['err']=$m->check($display['keyArr3'],$params);
	if(!$display['err']){
		$sqlval='';
		$sqlval['client_id']=$params['client_id'];
		$sqlval['client_health_coach_id']='NULL';
		$sqlval['client_health_coach_booking_date']='NULL';
		$return=$dbHelper->sql_send('client',$sqlval,'client_id');
		$_SESSION['alert']='edit complete!';
		$_SESSION['tab']=1;
		$m->location('client.html?id='.$params['client_id']);
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}

}elseif($display['post']['mode']=='edit' || $display['get']['id']){
	$res=$dbHelper->sql_get_contents('client',$params['client_id']);
	foreach($display['keyArr'] as $k => $v){
		if($v['input']=='other'){
			$res['contents'][$k]=explode('/',$res['contents'][$k]);
		}
	}	
	$display['post']=$res['contents'];
	$display['post']['client_bmi']=$m->createBMI($display['post']['client_height'],$display['post']['client_height_unit'],$display['post']['client_weight'],$display['post']['client_weight_unit']);

	$where='';
	$where['activity_client_id']=$params['client_id'];
	$where['activity_photo !=']='';
	$where['activity_type']='1';
	if($res=$dbHelper->sql_get_select('activity',$where,'activity_create_time','activity_create_date')){
		$display['data']['total_active_rate']=floor(count($res)/$m->time_diff(date("Y-m-d", strtotime($display['post']['client_create_time']." -1 day")),date('Y-m-d'),2)*100).'%';
	}else{
		$display['data']['total_active_rate']='0%';
	}

	$p->gf_rendering("client_form.php");
}elseif($display['post']['mode']=='conf'){
	if($display['err']=$m->check($display['keyArr'],$params)){
		$display['err']['alert']=$p->makeErr($display['err']);
	}else{
		$display['post']['mode']='checked';
	}
	$display['post']['client_bmi']=$m->createBMI($display['post']['client_height'],$display['post']['client_height_unit'],$display['post']['client_weight'],$display['post']['client_weight_unit']);
	$p->gf_rendering("client_form.php");
}elseif($display['post']['mode']=='comp'){
	$display['err']=$m->check($display['keyArr'],$params);
	if(!$display['err']){
		$where='';
		$where['client_id']=$params['client_id'];
		$befor=$dbHelper->sql_get_one2('client_terms_start,client_terms_end,client_consultant_id,client_health_coach_id','client',$where);
		$return=$dbHelper->sql_send('client',$m->createParams($display['keyArr'],$params),'client_id');
		if($return['insert_id']){
			$params['client_id']=$return['insert_id'];
		}
		if($befor['client_terms_start']!=$params['client_terms_start'] || $befor['client_terms_end']!=$params['client_terms_end']){
			$params['terms1']=$befor['client_terms_start'].' - '.$befor['client_terms_end'];
			$params['terms2']=$params['client_terms_start'].' - '.$params['client_terms_end'];
			if($befor['client_consultant_id']){
				$where='';
				$where['consultant_id']=$befor['client_consultant_id'];
				$consultant=$dbHelper->sql_get_one2('*','consultant',$where);
			}
			if($befor['client_health_coach_id']){
				$where='';
				$where['consultant_id']=$befor['client_health_coach_id'];
				$health_coach=$dbHelper->sql_get_one2('*','consultant',$where);
			}
			
			$title='[bs] Contract Terms / '.$params['client_first_name'].' '.$params['client_last_name'].' ['.$params['client_id'].']';
			$params['client_url']=AHOST.'manager/client.html?id='.$params['client_id'];
			$body=$m->mailBody('terms',$params);
			$m->sendmail(MAIL,$title,$body);
			if($consultant['consultant_email']){
				$params['client_url']=AHOST.'consultant/client.html?id='.$params['client_id'];
				$body=$m->mailBody('terms',$params);
				$m->sendmail($consultant['consultant_email'],$title,$body);
			}
			if($health_coach['consultant_email']){
				$params['client_url']=AHOST.'health_coach/client.html?id='.$params['client_id'];
				$body=$m->mailBody('terms',$params);
				$m->sendmail($health_coach['consultant_email'],$title,$body);
			}
		}
		$_SESSION['alert']='edit complete!';
		$m->location('client.html');
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}
}elseif($display['post']['mode']=='search'){
	$display['err']=$m->check($display['keyArr'],$params,1);
	if(!$display['err']){
		$_SESSION['src']['client_list']=$params;
		$m->location('client.html');
	}
}elseif($display['post']['mode']=='reset'){
	unset($_SESSION['src']['client_list']);
	$m->location('client.html');
}
$params=$display['session']['src']['client_list'];
$display['post']=$display['session']['src']['client_list'];
if(!$params['mode']){
	$params['mode']='search';
}

$display['err']=$m->check($display['keyArr'],$params,1);
if(!$display['err']){
	$_SESSION['src']['client_list']=$params;
	$where=$m->searchWhere($display['keyArr'],$params);
	if($display['session']['user_role_id']=='2'){
		$where['client_consultant_id']=$display['session']['user_id'];
	}else
	if($display['session']['user_role_id']=='3'){
		$where['client_health_coach_id']=$display['session']['user_id'];
	}
	if($params['sort']){
		$sort=$params['sort'];
	}else{
		$sort='client_id desc';
	}
	$params['page']=$page;
	$list=$dbHelper->sql_get_list('client',$where,$page,$sort);
	$display['data']['list']=$list['list'];
	$display['data']['navi']=$p->makeNavi($params['page'],$list['count'],MAX_PAGE);
}

$p->gf_rendering("client_list.php");
?>