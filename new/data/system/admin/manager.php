<?php
$admin = new admin();
$admin->admin_check(1);
$dbHelper = new DbHelper();
$dbHelper->open();

$p=new page();
$m=new main();

if($display['get']['id']){
	$display['post']['manager_id']=$display['get']['id'];
	$display['post']['mode']='edit';
}
$params = $dbHelper->sanitize($display['post']);
$display['keyArr']=array(
 'manager_id'=>array('name'=>'ID','input'=>'print','search'=>'range','check'=>array(''))
,'manager_role'=>array('name'=>'Role','input'=>'select','search'=>'check','check'=>array('checkMust','checkNumStr'))
,'manager_status'=>array('name'=>'Status','input'=>'select','search'=>'check','check'=>array('checkMust','checkNumStr'))
,'manager_first_name'=>array('name'=>'First name','input'=>'mtext','search'=>'mtext','check'=>array('checkMust'))
,'manager_last_name'=>array('name'=>'Last name','input'=>'mtext','search'=>'mtext','check'=>array('checkMust'))
,'manager_email'=>array('name'=>'email','search'=>'text','input'=>'ltext','check'=>array('checkMust','checkMail'))
,'manager_login_id'=>array('name'=>'login id','input'=>'mtext','check'=>array('checkMust','checkMailStr','checkManagerLoginID','checkLength'),'min'=>6)
,'manager_password'=>array('name'=>'password','input'=>'password','check'=>array('checkMust','checkNumStr','checkLength'),'min'=>6)
,'manager_create_time'=>array('name'=>'Entry Date','input'=>'print','search'=>'date','check'=>array(''))
,'manager_update_time'=>array('name'=>'Update Date','input'=>'print','search'=>'date','check'=>array(''))
);

if(!$params['page']){
	$params['page']=1;
}

if($display['post']['mode']=='delete'){
	$where='';
	$where['manager_id']=$params['manager_id'];
	if($display['err']){
		$_SESSION['alert']=$display['err'];
	}else{
		$return=$dbHelper->sql_delete_contents('manager',$params['manager_id']);
		$_SESSION['alert']='delete complete!';
	}
	$m->location('manager.html');
}elseif($display['post']['mode']=='back'){
	$p->gf_rendering("manager_form.php");
}elseif($display['post']['mode']=='add'){
	$p->gf_rendering("manager_form.php");
}elseif($display['post']['mode']=='edit'){
	$res=$dbHelper->sql_get_contents('manager',$params['manager_id']);
	foreach($display['keyArr'] as $k => $v){
		if($v['input']=='other'){
			$res['contents'][$k]=explode('/',$res['contents'][$k]);
		}
		if($v['input']=='password'){
			$res['contents'][$k]='dummy123';
		}
	}
	$display['post']=$res['contents'];
	$p->gf_rendering("manager_form.php");
}elseif($display['post']['mode']=='conf'){
	if($display['err']=$m->check($display['keyArr'],$params)){
		$display['err']['alert']=$p->makeErr($display['err']);
	}else{
		$display['post']['mode']='checked';
	}
	$p->gf_rendering("manager_form.php");
}elseif($display['post']['mode']=='comp'){
	$display['err']=$m->check($display['keyArr'],$params);
	if(!$display['err']){
		$return=$dbHelper->sql_send('manager',$m->createParams($display['keyArr'],$params),'manager_id');
		if($return['insert_id']){
			$params['manager_id']=$return['insert_id'];
		}
		$_SESSION['alert']='edit complete!';
		$m->location('manager.html');
	}else{
		$display['err']['alert']=$p->makeErr($display['err']);
	}
}elseif($display['post']['mode']=='search'){
	$display['err']=$m->check($display['keyArr'],$params,1);
	if(!$display['err']){
		$_SESSION['src']['manager_list']=$params;
		$m->location('manager.html');
	}
}elseif($display['post']['mode']=='reset'){
	unset($_SESSION['src']['manager_list']);
	$m->location('manager.html');
}

$params=$display['session']['src']['manager_list'];
$display['post']=$display['session']['src']['manager_list'];
if(!$params['mode']){
	$params['mode']='search';
}

$display['err']=$m->check($display['keyArr'],$params,1);
if(!$display['err']){
	$_SESSION['src']['manager_list']=$params;
	$where=$m->searchWhere($display['keyArr'],$params);
	$list=$dbHelper->sql_get_list('manager',$where);
	$display['data']['list']=$list['list'];
	$display['data']['navi']=$p->makeNavi($params['page'],$list['count']);
}
$p->gf_rendering("manager_list.php");
?>