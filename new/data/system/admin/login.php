<?php
if($_SESSION['user_id']){
	foreach($_SESSION as $key => $val){
		unset($_SESSION[$key]);
	}
	$display['err']='logout complete!';

}elseif(isset($display['post']['login'])){

	if($display['post']['login_pass'] && $display['post']['login_id'] && $display['post']['user_role_id']){
		$m=new main();
		$dbHelper = new DbHelper();
		$dbHelper->open();

		if($display['post']['user_role_id']==2){
			$table='consultant';
			$where[$table.'_role']=1;
		}elseif($display['post']['user_role_id']==3){
			$table='consultant';
			$where[$table.'_role']=2;
		}else{
			$table='manager';
		}

		$where[$table.'_login_id']=$display['post']['login_id'];
		$where[$table.'_password']=$display['post']['login_pass'];
		
		$res=$dbHelper->sql_get_one2('*',$table,$where);
		if($res){
			$_SESSION['user_id']=$res[$table.'_id'];
			$_SESSION['user_group_name']=$display['list']['user_role_id'][$display['post']['user_role_id']];
			$_SESSION['user_role_id']=$display['post']['user_role_id'];
			$_SESSION['user_role']=$display['list'][$table.'_role'][$res[$table.'_role']];
			$_SESSION['user_name']=$res[$table.'_first_name'].' '.$res[$table.'_last_name'];
			$_SESSION['user_status']=$display['list'][$table.'_status'][$res[$table.'_status']];
			if(isset($res['consultant_status'])){
				$_SESSION['consultant_status']=$res['consultant_status'];
				$_SESSION['consultant_email']=$res['consultant_email'];
			}
			if($back_url=$_SESSION['back_url']){
				unset($_SESSION['back_url']);
				$m->location($back_url);
			}else{
				$m->location('index.html');
			}
		}else{
			$display['err']='Login information is incorrect.';
		}
	}else{
		$display['err']='Please enter your login information.';
	}
}
$p=new page();
$p->gf_rendering("login.php");
?>