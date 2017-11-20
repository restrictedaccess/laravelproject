<?php
$admin = new admin();
$admin->admin_check();

$dbHelper = new DbHelper();
$dbHelper->open();

$p=new page();
$m=new main();

if($display['get']['id']){
	$display['post']['memo_client_id']=$display['get']['id'];
}
if($display['get']['type']){
	$display['post']['memo_class']=$display['get']['type'];
}
$display['post']['memo_date']=date('Y-m-d');
$params = $dbHelper->sanitize($display['post']);

$display['keyArr']=array(
 'memo_id'=>array('name'=>'ID','input'=>'hidden','check'=>array(''))
,'memo_class'=>array('name'=>'Class','input'=>'hidden','check'=>array('checkMust'))
,'memo_create_time'=>array('name'=>'create_time','input'=>'hidden','check'=>array(''))
,'memo_date'=>array('name'=>'Date','input'=>'date','check'=>array('checkMust','checkDate'))
);
if($display['post']['memo_class']==3){
	$display['keyArr']['memo_type']=array('name'=>'Type','input'=>'select','check'=>array('checkMust'));
}
$display['keyArr']+=array(
 'memo_client_id'=>array('name'=>'client_id','input'=>'hidden','check'=>array('checkMust'))
,'memo_description'=>array('name'=>'Description','input'=>'text','check'=>array('checkMust'))
);

if($display['post']['mode']=='comp'){
	$display['err']=$m->check($display['keyArr'],$params);
	if(!$display['err']){
		$return=$dbHelper->sql_send('memo',$m->createParams($display['keyArr'],$params),'memo_id');
		
		$where='';
		$where['client_id']=$params['memo_client_id'];
		$client=$dbHelper->sql_get_one2('*','client',$where);
		
		if($client['client_consultant_id']){
			$where='';
			$where['consultant_id']=$client['client_consultant_id'];
			$consultant=$dbHelper->sql_get_one2('*','consultant',$where);
		}
		if($client['client_health_coach_id']){
			$where='';
			$where['consultant_id']=$client['client_health_coach_id'];
			$health_coach=$dbHelper->sql_get_one2('*','consultant',$where);
		}
		$client['consultant']=$consultant['consultant_first_name'].' '.$consultant['consultant_last_name'].' ['.$consultant['consultant_id'].']';
		$client['health_coach']=$health_coach['consultant_first_name'].' '.$health_coach['consultant_last_name'].' ['.$health_coach['consultant_id'].']';
		
		if($display['post']['memo_class']==1){
			$title='[bs] Memo1 was updated / '.$client['client_first_name'].' '.$client['client_last_name'].' ['.$params['memo_client_id'].']';
			$client['client_url']=AHOST.'manager/client.html?id='.$client['client_id'];
			$body=$m->mailBody('memo1',$client);
			$m->sendmail(MAIL,$title,$body);
		}elseif($display['post']['memo_class']==2){
			$title='[bs] Memo2 was updated / '.$client['client_first_name'].' '.$client['client_last_name'].' ['.$params['memo_client_id'].']';
			$client['client_url']=AHOST.'manager/client.html?id='.$client['client_id'];
			$body=$m->mailBody('memo2',$client);
			$m->sendmail(MAIL,$title,$body);
			if($consultant['consultant_email']){
				$client['client_url']=AHOST.'consultant/client.html?id='.$client['client_id'];
				$body=$m->mailBody('memo2',$client);
				$m->sendmail($consultant['consultant_email'],$title,$body);
			}
			if($health_coach['consultant_email']){
				$client['client_url']=AHOST.'health_coach/client.html?id='.$client['client_id'];
				$body=$m->mailBody('memo2',$client);
				$m->sendmail($health_coach['consultant_email'],$title,$body);
			}
		}elseif($display['post']['memo_class']==3){
			$title='[bs] Goal was updated / '.$client['client_first_name'].' '.$client['client_last_name'].' ['.$params['memo_client_id'].']';
			$client['client_url']=AHOST.'manager/client.html?id='.$client['client_id'];
			$body=$m->mailBody('goal',$client);
			$m->sendmail(MAIL,$title,$body);
			if($consultant['consultant_email']){
				$client['client_url']=AHOST.'consultant/client.html?id='.$client['client_id'];
				$body=$m->mailBody('goal',$client);
				$m->sendmail($consultant['consultant_email'],$title,$body);
			}
			if($health_coach['consultant_email']){
				$client['client_url']=AHOST.'health_coach/client.html?id='.$client['client_id'];
				$body=$m->mailBody('goal',$client);
				$m->sendmail($health_coach['consultant_email'],$title,$body);
			}
		}elseif($display['post']['memo_class']==4){
			$title='[bs] Feedback was updated / '.$client['client_first_name'].' '.$client['client_last_name'].' ['.$params['memo_client_id'].']';
			$client['client_url']=AHOST.'manager/client.html?id='.$client['client_id'];
			$body=$m->mailBody('feedback',$client);
			$m->sendmail(MAIL,$title,$body);
			if($consultant['consultant_email']){
				$client['client_url']=AHOST.'consultant/client.html?id='.$client['client_id'];
				$body=$m->mailBody('feedback',$client);
				$m->sendmail($consultant['consultant_email'],$title,$body);
			}
			if($health_coach['consultant_email']){
				$client['client_url']=AHOST.'health_coach/client.html?id='.$client['client_id'];
				$body=$m->mailBody('feedback',$client);
				$m->sendmail($health_coach['consultant_email'],$title,$body);
			}
		}
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
}
$p->gf_rendering("client_memo.php");
?>