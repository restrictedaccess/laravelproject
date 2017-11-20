<?php
class page {
function pageInit(){
	global $display;
	if(!$display['get']['page']){
		$display['get']['page']='index';
	}
	$sys=SYS_DIR.$display['get']['page'].'.php';
	$tpl=TPL_DIR.$display['get']['page'].'.php';
	if(is_file($sys)){
		require_once($sys);
	}elseif(is_file($tpl) && !strpos($display['get']['page'],'_form')){
		require_once($tpl);
	}else{
		$m=new main();
		$m->location(HOST.'404');
	}
}
function gf_rendering($_templateName){
	global $display;
	if(!$display['err']['alert'] && $display['session']['alert']){
		$display['err']['alert']=$this->makeErr($display['session']['alert']);
		unset($_SESSION['alert']);
	}
	require(TPL_DIR.$_templateName);
	if (DEBUG_MODE == 1){
		if ($msgs = $this->gf_get_error_messages()){
			echo '<pre>';
			foreach($msgs as $val){
				echo $val;
			}
			echo '</pre>';
		}
		print_r($display);
		print_r($_POST);
		print_r($_SESSION);
	}
	exit();
}
function gf_get_error_messages($flag=0){
	global $display;
	if($flag){
		return $display['errarr'];
	}else{
		return $display['errmsg'];
	}
}
function gfErr($err){
	global $display;
	$m=new main();
	if(DEBUG_MODE != 1){
		$m->pLog('error.log',$err);
	}
	$display['err']=$err;
	$this->gf_rendering('error.php');
}
function search_head($page_max,$page=1){
	if($page_max>1){
		if($page>1){
			$page_list='<input type="submit" name="page_bt_back" value="《">';
		}
		for($i=0;$i<$page_max;$i++){
			if($i>$page+10 || $i<$page-10){
				continue;
			}
			$ii=$i+1;
			if($page==$ii){
				$page_list.='&nbsp;<strong>'.$ii.'</strong>&nbsp;'."\n";
			}else{
				$page_list.='<input type="submit" name="page_bt" value="'.$ii.'">'."\n";
			}
		}
		if($page!=$page_max){
			$page_list.='<input type="submit" name="page_bt_next" value="》">';
		}
	
		return '
		<div class="pageNabi">
			'.$page_list.'
		</div>
		';
	}
}

function makeErr($errs){
	$res='
	<script type="text/javascript">
	<!--
	alert("';
	if(is_array($errs)){
	foreach($errs as $err){
		if(is_array($err)){
			$res.=array_shift($err).'\n';
		}else{
			$res.=$err.'\n';
		}
	}
	}else{
		$res.=$errs;
	}
	$res.='");
	// -->
	</script>';
	return $res;
}

function makeNavi($page,$count,$limit,$form=''){
	$navi.='<div class="count">Total count:'.$count.'</div>';
	$navi.='<div class="link">';
	if($limit && $limit < $count){
		$maxPage=ceil($count/$limit);
		if(!$form){
			$navi.='<form action="?" method="post">';
		}
		for($i=1;$i<=$maxPage;$i++){
			if($page==$i){
				$navi.=' <strong>'.$i.'</strong>';			
			}else{
				$navi.=' <input type="submit" name="page" value="'.$i.'" />';
			}
		}
		if(!$form){
			$navi.='</form>';
		}
	}
	$navi.='</div>';
	$navi.='<br clear="left">';
	return $navi;
}

function print_meta($title,$flg=''){
	global $display;
	include_once(TPL_DIR."bloc/meta.php");
}

function print_header($flg=0){
	global $display;
	include_once(TPL_DIR."bloc/header.php");
//	include_once(TPL_DIR."bloc/lmenu.php");
//	include_once(TPL_DIR."bloc/rmenu.php");
}

function print_footer($flg=0){
	global $display;
	include_once(TPL_DIR."bloc/footer.php");
}
function print_err($err){
	if($err && !is_array($err)){
		$err=str_replace('\n',"<br>",$err);
		$res='<p class="err">'.$err.'</p>';
	}
	return $res;
}
function print_search($keyArr=''){
	global $display;
	$m=new main();
	if(!$keyArr){
		$keyArr=$display['keyArr'];
	}
echo '
<h3 id="searchTitle">search　<input type="button" class="btn" onclick="dispBox(\'searchBox\'),hideBox(\'searchTitle\')" value="open" /></h3>
<div id="searchBox">
<h3>search　<input type="button" class="btn" onclick="dispBox(\'searchTitle\'),hideBox(\'searchBox\')" value="close" /></h3>
<div class="table">
';
foreach($keyArr as $key => $val){
	if($val['search']=='hidden'){
		if(is_array($display['post'][$key])){
			foreach($display['post'][$key] as $v){
				echo '<input type="hidden" name="'.$key.'[]" value="'.$v.'" />';
			}
		}else{
		echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />';
		}
	}elseif($val['search']=='submit'){
		echo '
		</div>
		<div class="btnBox">
			<input type="button" class="btn" onclick="sendForm(\''.$key.'\')" value="'.$val['name'].'" />
		</div>
		<div class="table">
		';
	}elseif($val['search']){
		echo '
		<div class="tr">
			<div class="th">'.$val['name'].$val['must'].'</div>
			<div class="td">';
			echo $this->print_err($display['err'][$key]);
			if($val['search']=='radio'){
				foreach($display['list'][$key] as $key2 => $val2){
					if($key2){
						echo '<label><input type="radio" name="'.$key.'" value="'.$key2.'" '.$m->Checked($display['post'][$key],$key2).' class="'.$val['input'].'" />'.$val2.'</label>';
					}
				}
			}elseif($val['search']=='check'){
				foreach($display['list'][$key] as $key2 => $val2){
					if($val2){
						echo '<label><input type="checkbox" name="'.$key.'[]" value="'.$key2.'" '.$m->Checked($display['post'][$key],$key2).' class="'.$val['input'].'" />'.$val2.'</label>';
					}
				}
			}elseif($val['search']=='select'){
				echo '<select name="'.$key.'"><optgroup label=""><option value="">----</option>';
				foreach($display['list'][$key] as $key2 => $val2){
					echo '<option value="'.$key2.'" '.$m->Selected($display['post'][$key],$key2).'>'.$val2.'</option>';
				}
				echo '</optgroup></select>';
			}elseif($val['search']=='date'){
				echo '<input type="text" name="'.$key.'_s" value="'.$display['post'][$key.'_s'].'" class="date" />～<input type="text" name="'.$key.'_e" value="'.$display['post'][$key.'_e'].'" class="date" /><p class="s">※ YYYY-MM-DD</p>';
			}elseif($val['search']=='tel'){
				echo '<input type="tel" name="'.$key.'" value="'.$display['post'][$key].'" class="mtext" />';
			}elseif($val['search']=='range'){
				echo '<input type="text" name="'.$key.'_s" value="'.$display['post'][$key.'_s'].'" class="'.$val['input'].'" style="width:45%;" />～<input type="text" name="'.$key.'_e" value="'.$display['post'][$key.'_e'].'" class="'.$val['input'].'" style="width:45%;" />';
			}else{
				echo '<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" />';
			}
		echo '</div>
		</div>';
	}
	if($val['sort']){
		$sort[$key.' '.$val['sort']]=$val['name'].' '.$val['sort'];
	}
}
if($sort){
	echo '
<div class="tr">
<div class="th">sort</div>
<div class="td">
	<select name="sort"><optgroup label=""><option value="">----</option>';
	foreach($sort as $key => $val){
		echo '<option value="'.$key.'" '.$m->Selected($display['post']['sort'],$key).'>'.$val.'</option>';
	}
	echo '</optgroup></select>
</div>
</div>	
	';
}
echo '
<!--div class="tr">
<div class="th">keyword</div>
<div class="td"><input type="text" name="keyword" value="'.$display['post']['keyword'].'" class="ltext"></div>
</div-->
<br clear="all">
</div>
<div class="btnBox">
<input type="button" class="btn" onclick="sendForm(\'reset\')" value="reset" />
<input type="button" class="btn" onclick="sendForm(\'search\')" value="search" />
</div>
</div>
';
}

function print_form($keyArr=''){
	global $display;
	$m = new main();
	if(!$keyArr){
		$keyArr=$display['keyArr'];
	}
echo '
<div class="table">
';
foreach($keyArr as $key => $val){
	if($val['input']=='none'){
		continue;
	}
	if(in_array('checkMust',$val['check'])){
		$val['must']='<span>*</span>';
	}

	if($val['input']=='zip'){
		echo '
		<div class="tr">
			<div class="th">Addess'.$val['must'].'</div>
			<div class="td zip">';
			$k=explode('_',$key);
			$key=$k[0].'_address1';
			echo $this->print_err($display['err'][$key]).'<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="ltext" placeholder="address1" />';
			$key=$k[0].'_address2';
			echo $this->print_err($display['err'][$key]).'<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="ltext" placeholder="address2" />';
			$key=$k[0].'_city';
			echo $this->print_err($display['err'][$key]).'<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="mtext" placeholder="City" />';
			$key=$k[0].'_state';
			echo $this->print_err($display['err'][$key]).'<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="mtext" placeholder="State" />';
			$key=$k[0].'_zip_code';
			echo $this->print_err($display['err'][$key]).'<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="stext" placeholder="Zip code" />';
		echo '</div>
		</div>';
	}elseif($val['input']=='add'){
		continue;
	}elseif($val['input']=='hidden'){
		echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />';
	}elseif($val['input']=='submit'){
		echo '<br clear="all">
		</div>
		<div class="btnBox">
			<input type="button" class="btn" onclick="sendForm(\''.$key.'\')" value="'.$val['name'].'" />
		</div>
		<div class="table">
		';
	}elseif($val['input']=='title'){
		echo '<br clear="all">
		</div>
		<h3 id="'.$key.'" name="'.$key.'">'.$val['name'].'</h3>
		<div class="table">
		';
	}elseif($val['input']=='print'){
		if($display['post'][$key]){
			echo '
			<div class="tr">
				<div class="th">'.$val['name'].$val['must'].'</div>
				<div class="td">';
			echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.nl2br($display['post'][$key]);
			echo '</div>
			</div>';
		}
	}elseif($val['input']=='print_arr'){
		if($display['post'][$key]){
			echo '
			<div class="tr">
				<div class="th">'.$val['name'].$val['must'].'</div>
				<div class="td">';
				if(is_array($display['post'][$key])){
					foreach($display['post'][$key] as $val2){
						echo '<input type="hidden" name="'.$key.'[]" value="'.$val2.'" />'.nl2br($display['list'][$key][$val2]);
					}
				}else{
					echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.nl2br($display['list'][$key][$display['post'][$key]]);
				}
			echo '</div>
			</div>';
		}
	}else{
		echo '<div class="tr">';
		if($val['bg']){
		echo '<div class="tr" style="background:#DDEEFF">';
		}else{
		echo '<div class="th">';
		}
			echo $val['name'].$val['must'].$val['th'].'</div>
			<div class="td">';
			echo $this->print_err($display['err'][$key]);
			if($val['input']=='radio'){
				foreach($display['list'][$key] as $key2 => $val2){
					if($key2 || is_numeric($key2)){
						echo '<label><input type="radio" name="'.$key.'" value="'.$key2.'" '.$m->Checked($display['post'][$key],$key2).' class="'.$val['input'].'" />'.$val2.'</label>';
					}
				}
			}elseif($val['input']=='check'){
				foreach($display['list'][$key] as $key2 => $val2){
					if($key2 || is_numeric($key2)){
						echo '<label><input type="checkbox" name="'.$key.'[]" value="'.$key2.'" '.$m->Checked($display['post'][$key],$key2).' class="'.$val['input'].'" />'.$val2.'</label>';
					}
				}
			}elseif($val['input']=='other'){
				foreach($display['list'][$key] as $key2 => $val2){
					if($key2){
						echo '<label><input type="checkbox" name="'.$key.'[]" value="'.$key2.'" '.$m->Checked($display['post'][$key],$key2).' class="'.$val['input'].'" />'.$val2.'</label>';
					}
				}
				$key=$key.'_other_value';
				echo '<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" placeholder="other" />';
			}elseif($val['input']=='select'){
				echo '<select name="'.$key.'"';
				if($val['option']){
					echo ' '.$val['option'];
				}
				echo '><optgroup label="">';
				foreach($display['list'][$key] as $key2 => $val2){
					if($key2){
						echo '<option value="'.$key2.'" '.$m->Selected($display['post'][$key],$key2).'>'.$val2.'</option>';
					}else{
						echo '<option value="">選択して下さい</option>';
					}
				}
				echo '</optgroup></select>';
			}elseif($val['input']=='user_id'){
				echo '<select name="'.$key.'" id="select_user_id">';
				foreach($display['list'][$key] as $key2 => $val2){
					if($key2){
						echo '<option value="'.$key2.'" '.$m->Selected($display['post'][$key],$key2).'>'.$val2.'</option>';
					}else{
						echo '<option value="">選択して下さい</option>';
					}
				}
				echo '</select>　';
				echo '<input type="button" class="btn" onclick="selectValue(\'select_user_id\','.$_SESSION['user_id'].')" value="私が担当" />';
			}elseif($val['input']=='text'){
				echo '<textarea name="'.$key.'">';
				echo $display['post'][$key];
				echo '</textarea>';
			}elseif($val['input']=='password'){
				echo '<input type="password" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" />';
			}elseif($val['input']=='file'){
				echo '<div id="preview_area" class="dropzone-custom">';
				foreach($display['data']['file_key'] as $k => $v){
					echo '<p>';
					echo $m->createFileLink($v);
					echo '&nbsp;<input type="checkbox" name="file_del['.$k.']" '.$m->Checked($display['post']['file_del'][$k],1).' value="1">削除';
					echo '</p>';
				}
				echo '</div>';
				echo '<div id="dropzoneBox" class="dropzone"></div>';
			}elseif($val['input']=='img'){
				$extension=$display['post']['extension'][$key];
				$file=$key.'/'.$m->cipher($display['post'][$val['key']]).'.'.$extension;
				if(is_file(UPFILE_DIR.$file)){
					echo '<img src="'.UPFILE_URL.$file.'" class="photo"><br>';
				}
echo '
<div class="uploadButton">
    ファイルを選択
    <input type="file" name="'.$key.'" class="fileInput" onchange="'.$key.'_uv.style.display=\'inline-block\'; '.$key.'_uv.value = this.value;" />
    <input type="text" id="'.$key.'_uv" class="uploadValue" disabled />
</div>';
				echo '&nbsp;<input type="checkbox" name="'.$key.'_del" '.$m->Checked($display['post']['imgdel'][$key],1).' value="1">削除';
				echo '<input type="hidden" name="extension['.$key.']" value="'.$extension.'" />';
			}elseif($val['input']=='imgprev'){
				$extension=$display['post']['extension'][$key];
				$file=$key.'/'.$m->cipher($display['post'][$val['key']]).'.'.$extension;
				if(is_file(UPFILE_DIR.$file)){
					echo '<img src="'.UPFILE_URL.$file.'">';
				}
			}elseif($val['input']=='tel'){
				if($display['post'][$key]){
					$val['tel']=explode('-',$display['post'][$key]);
					$display['post'][$key.'1']=$val['tel'][0];
					$display['post'][$key.'2']=$val['tel'][1];
					$display['post'][$key.'3']=$val['tel'][2];
				}
				echo '<input type="tel" name="'.$key.'1" value="'.$display['post'][$key.'1'].'" class="'.$val['input'].'" />-<input type="tel" name="'.$key.'2" value="'.$display['post'][$key.'2'].'" class="'.$val['input'].'" />-<input type="tel" name="'.$key.'3" value="'.$display['post'][$key.'3'].'" class="'.$val['input'].'" />';
			}elseif($val['input']=='date'){
				echo '<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" /><p class="s">※ YYYY-MM-DD</p>';
			}elseif($val['input']=='time'){
				echo $m->utc($display['post'][$key],$display['post']['client_time_zone']);
			}elseif($val['input']=='unit'){
				echo '<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" style="width:30%" /> ';
				$key=$key.'_unit';
				echo '<select name="'.$key.'"';
				if($val['option']){
					echo ' '.$val['option'];
				}
				echo '>';
				foreach($display['list'][$key] as $key2 => $val2){
					echo '<option value="'.$key2.'" '.$m->Selected($display['post'][$key],$key2).'>'.$val2.'</option>';
				}
				echo '</select>';
				
			}elseif($val['input']=='stripe'){
				echo '<a href="'.STRIPE_URL.'customers/'.$display['post'][$key].'" target="_blank">'.$display['post'][$key].'</a>';
			}elseif($val['input']=='percent'){
				echo '<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" /> ％';
			}elseif($val['input']=='score'){
				echo '<div class="rangeBox"><input type="range" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" step="10" min="0" max="100" /><output for="'.$key.'" onforminput="value = '.$key.'.valueAsNumber;"></output></div>';
			}elseif($val['input']=='score2'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].' / 100点';
			}elseif($val['input']=='array'){
				$flg='';
				for($i=0;$i<=$display['post'][$key.'_count'];$i++){
					echo '
					<input type="hidden" name="'.$key.'_count" value="'.$display['post'][$key.'_count'].'" />
					<div class="table">					
					';
					foreach($val['array'] as $key2 => $val2){
						if(!$val2['input']){
							continue;
						}elseif($val2['input']=='hidden'){
							echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
						}else{
							echo '<div class="tr">';
							echo '<div class="th">'.$val2['name'].$val['must'].'</div><div class="td">';
							if($val2['input']=='time'){
								$flg=1;
								echo '<select name="'.$key.'['.$i.']['.$key2.']">';
								echo '<option value="">-</option>';
								for($y=0;$y<=23;$y++){
									echo '<option value="'.$y.'" '.$m->Selected($display['post'][$key][$i][$key2],$y).'>'.$y.'</option>';
								}
								echo '</select>:';
								$key2=$key.'_time2';
								echo '<select name="'.$key.'['.$i.']['.$key2.']">';
								echo '<option value="">-</option>';
								for($y=0;$y<=55;$y+=5){
									echo '<option value="'.$y.'" '.$m->Selected($display['post'][$key][$i][$key2],$y).'>'.$y.'</option>';
								}
								echo '</select>～';
								$key2=$key.'_time3';
								echo '<select name="'.$key.'['.$i.']['.$key2.']">';
								echo '<option value="">-</option>';
								for($y=0;$y<=23;$y++){
									echo '<option value="'.$y.'" '.$m->Selected($display['post'][$key][$i][$key2],$y).'>'.$y.'</option>';
								}
								echo '</select>:';
								$key2=$key.'_time4';
								echo '<select name="'.$key.'['.$i.']['.$key2.']">';
								echo '<option value="">-</option>';
								for($y=0;$y<=55;$y+=5){
									echo '<option value="'.$y.'" '.$m->Selected($display['post'][$key][$i][$key2],$y).'>'.$y.'</option>';
								}
								echo '</select>';
							}elseif($val2['input']=='time2'){
								echo $display['post'][$key][$i][$key2].':';
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								$key2=$key.'_time2';
								echo $display['post'][$key][$i][$key2].'～';
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								$key2=$key.'_time3';
								echo $display['post'][$key][$i][$key2].':';
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								$key2=$key.'_time4';
								echo $display['post'][$key][$i][$key2];
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								if(!$i){
									$display['post'][$key.'_count']--;
								}
							}elseif($val2['input']=='print'){
								echo $display['post'][$key][$i][$key2];
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
							}elseif($val2['input']=='text'){
								echo '<textarea name="'.$key.'['.$i.']['.$key2.']">';
								echo $display['post'][$key][$i][$key2];
								echo '</textarea>';
							}else{
								echo '<input type="text" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" class="'.$val2['input'].'" />';
							}
							echo '</div></div>';
						}
					}
					echo '
					</div>';
				}
				if($flg){
				echo '
					<div class="btnBox">
					<input type="button" class="btn" onclick="sendForm(\'more\')" value="追加" />
					</div>
				';
				}
			}elseif($val['input']=='table'){
				foreach($val['array'] as $key2=>$val2){
					$z=explode('_',$key2);
					$table[$z[0]][$z[1]]=$val2;
				}
				echo '<table class="table_qareg">';
				if($val['thx']){
					echo '<tr>';
					foreach($val['thx'] as $val2){
						echo '<th>'.$val2.'</th>';
					}
					echo '</tr>';
				}
				
				foreach($table as $key2=>$val2){
					echo '<tr>';					
					foreach($val2 as $key3=>$val3){
						echo '<td>';
						if($val3['input']=='no'){
							echo $key2;
						}elseif($val3['input']=='text'){
							echo '<textarea name="'.$key.$key2.'_'.$key3.'">';
							echo $display['post'][$key.$key2.'_'.$key3];
							echo '</textarea>';
						}elseif($val3['input']=='print'){
							echo $display['post'][$key.$key2.'_'.$key3];
							echo '<input type="hidden" name="'.$key.$key2.'_'.$key3.'" value="'.$display['post'][$key.$key2.'_'.$key3].'" />';
						}
						echo '</td>';
					}
					echo '</tr>';
				}
				echo '</table>';
			}else{
				echo '<input type="text" name="'.$key.'" value="'.$display['post'][$key].'" class="'.$val['input'].'" />';
			}
		echo '</div>
		</div>';
	}
}
echo '<br clear="all"></div>';
}

function print_conf($keyArr=''){
	global $display;
	$m = new main();
	if(!$keyArr){
		$keyArr=$display['keyArr'];
	}
echo '
<div class="table">
';
foreach($keyArr as $key => $val){
	if($val['input']=='none'){
		continue;
	}
	if(in_array('checkMust',$val['check'])){
		$val['must']='<span>*</span>';
	}

	if($val['input']=='zip'){
		echo '
		<div class="tr">
			<div class="th">Address'.$val['must'].'</div>
			<div class="td zip">';
			$k=explode('_',$key);
			$key=$k[0].'_address1';
			echo $this->print_err($display['err'][$key]).'<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].'<br>';
			$key=$k[0].'_address2';
			echo $this->print_err($display['err'][$key]).'<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].'<br>';
			$key=$k[0].'_city';
			echo $this->print_err($display['err'][$key]).'<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].'<br>';
			$key=$k[0].'_state';
			echo $this->print_err($display['err'][$key]).'<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].'<br>';
			$key=$k[0].'_zip_code';
			echo $this->print_err($display['err'][$key]).'<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].'<br>';
		echo '</div>
		</div>';
	}elseif($val['input']=='title'){
		echo '<br clear="all">
		</div>
		<h3 id="'.$key.'" name="'.$key.'">'.$val['name'].'</h3>
		<div class="table">
		';
	}elseif($val['input']=='add'){
		continue;
	}elseif($val['input']=='hidden'){
		echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />';
	}elseif($val['input']=='print'){
		if($display['post'][$key]){
			echo '
			<div class="tr">
				<div class="th">'.$val['name'].$val['must'].'</div>
				<div class="td">';
			echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.nl2br($display['post'][$key]);
			echo '</div>
			</div>';
		}
	}elseif($val['input']=='print_arr'){
		if($display['post'][$key]){
			echo '
			<div class="tr">
				<div class="th">'.$val['name'].$val['must'].'</div>
				<div class="td">';
				if(is_array($display['post'][$key])){
					foreach($display['post'][$key] as $val2){
						echo '<input type="hidden" name="'.$key.'[]" value="'.$val2.'" />'.nl2br($display['list'][$key][$val2]);
					}
				}else{
					echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.nl2br($display['list'][$key][$display['post'][$key]]);
				}
			echo '</div>
			</div>';
		}
	}else{
		echo '
		<div class="tr">
			<div class="th">'.$val['name'].$val['must'].'</div>
			<div class="td">';
			echo $this->print_err($display['err'][$key]);
			if($val['input']=='radio' || $val['input']=='check' || $val['input']=='select' || $val['input']=='user_id'){
				if(is_array($display['post'][$key])){
					foreach($display['post'][$key] as $key2){
						echo '<label><input type="hidden" name="'.$key.'[]" value="'.$key2.'" />'.$display['list'][$key][$key2].'</label>';
					}
				}else{
					echo '<label><input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['list'][$key][$display['post'][$key]].'</label>';
				}
			}elseif($val['input']=='other'){
				foreach($display['post'][$key] as $key2){
					echo '<label><input type="hidden" name="'.$key.'[]" value="'.$key2.'" />'.$display['list'][$key][$key2].'</label><br>';
				}
				if(in_array('99',$display['post'][$key])){
					$key=$key.'_other_value';
					echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key];
				}
			}elseif($val['input']=='text'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />';
				echo nl2br($display['post'][$key]);
			}elseif($val['input']=='password'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />';
				$mozi=mb_strlen($display['post'][$key]);
				for($i=0;$i<$mozi;$i++){
					echo '●';
				}
			}elseif($val['input']=='img'){
				$extension=$display['post']['extension'][$key];
				if(!$extension){
					$res=$m->getExtension(array($key=>array('input'=>'img')),$display['session']['user_id'],1);
					$extension=$res[$key];
				}
				
				if($display['post'][$key.'_del']){
					echo '削除<input type="hidden" name="imgdel['.$key.']" value="1" />';
				}else{
					$file='upfile/'.$key.'_'.$display['session']['user_id'];
					if(is_file(HTML_DIR.'admin/'.$file.'.'.$extension)){
						if($extension=='jpg'){
							echo '<img src="'.AHOST.$file.'.jpg'.'" class="photo">';
						}else{
							echo '<a href="'.AHOST.$file.'.'.$extension.'" target="_blank">ファイル</a>';
						}
					}else{
						$extension=$display['post']['extension'][$key];
						$file=$key.'/'.$m->cipher($display['post'][$val['key']]).'.'.$extension;
						if(is_file(UPFILE_DIR.$file)){
							echo '<img src="'.UPFILE_URL.$file.'" class="photo"><br>';
						}
					}
				}
				echo '<input type="hidden" name="extension['.$key.']" value="'.$extension.'" />';
			}elseif($val['input']=='imgprev'){
				$file=$key.'/'.$m->cipher($display['post'][$val['key']]).'.jpg';
				if(is_file(UPFILE_DIR.$file)){
					echo '<img src="'.UPFILE_URL.$file.'" class="photo">';
				}
			}elseif($val['input']=='file'){
				foreach($display['post']['file_key'] as $k => $v){
					echo $m->createFileLink($v,1);
					echo '<input type="hidden" name="file_key[]" value="'.$v.'" />';
				}
				foreach($display['post']['file_del'] as $k => $v){
					if(!$v){
						continue;
					}
					echo '<input type="hidden" name="file_del['.$k.']" value="'.$v.'" />';
				}
			}elseif($val['input']=='tel'){
				if($display['post'][$key.'1']){
					echo $display['post'][$key.'1'].'-'.$display['post'][$key.'2'].'-'.$display['post'][$key.'3'];
					echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key.'1'].'-'.$display['post'][$key.'2'].'-'.$display['post'][$key.'3'].'" />';
				}
			}elseif($val['input']=='percent'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].' ％';
			}elseif($val['input']=='date'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key];
			}elseif($val['input']=='time'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].' 時間';
			}elseif($val['input']=='score' || $val['input']=='score2'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].' / 100点';
			}elseif($val['input']=='unit'){
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['post'][$key].' ';
				$key=$key.'_unit';
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.$display['list'][$key][$display['post'][$key]];
			}elseif($val['input']=='array'){
				for($i=0;$i<=$display['post'][$key.'_count'];$i++){
					echo '
					<input type="hidden" name="'.$key.'_count" value="'.$display['post'][$key.'_count'].'" />
					<div class="table">
					';
					foreach($val['array'] as $key2 => $val2){
						$a='';
						foreach($display['post'][$key][$i] as $val3){
							if($val3){
								$a=1;
							}
						}
						if(!$val2['input'] || !$a){
							continue;
						}elseif($val2['input']=='hidden'){
							echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
						}else{
							echo '<div class="tr">';
							echo '<div class="th">'.$val2['name'].$val['must'].'</div><div class="td">';
							if($val2['input']=='time' || $val2['input']=='time2'){
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								echo $display['post'][$key][$i][$key2].':';
								$key2=$key.'_time2';
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								echo $display['post'][$key][$i][$key2].'～';
								$key2=$key.'_time3';
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								echo $display['post'][$key][$i][$key2].':';
								$key2=$key.'_time4';
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								echo $display['post'][$key][$i][$key2];
							}elseif($val2['input']=='text'){
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								echo nl2br($display['post'][$key][$i][$key2]);
							}else{
								echo '<input type="hidden" name="'.$key.'['.$i.']['.$key2.']" value="'.$display['post'][$key][$i][$key2].'" />';
								echo $display['post'][$key][$i][$key2];
							}
							echo '</div></div>';
						}
					}
					echo '
					<div class="tr">
					</div>';
				}
			}elseif($val['input']=='table'){
				foreach($val['array'] as $key2=>$val2){
					$z=explode('_',$key2);
					$table[$z[0]][$z[1]]=$val2;
				}
				echo '<table class="table_qareg">';
				if($val['thx']){
					echo '<tr>';
					foreach($val['thx'] as $val2){
						echo '<th>'.$val2.'</th>';
					}
					echo '</div>';
				}
				
				foreach($table as $key2=>$val2){
					echo '<tr>';					
					foreach($val2 as $key3=>$val3){
						echo '<td>';
						if($val3['input']=='no'){
							echo $key2;
						}elseif($val3['input']=='text'){
							echo '<input type="hidden" name="'.$key.$key2.'_'.$key3.'" value="'.$display['post'][$key.$key2.'_'.$key3].'" />';
							echo nl2br($display['post'][$key.$key2.'_'.$key3]);
						}else{
							echo $display['post'][$key.$key2.'_'.$key3];
							echo '<input type="hidden" name="'.$key.$key2.'_'.$key3.'" value="'.$display['post'][$key.$key2.'_'.$key3].'" />';
						}
						echo '</td>';
					}
					echo '</tr>';
				}
				echo '</table>';
			}else{
				echo '<input type="hidden" name="'.$key.'" value="'.$display['post'][$key].'" />'.nl2br($display['post'][$key]);
			}
		echo '</div>
		</div>';
	}
}
echo '<br clear="all"></div>';
}

function calendar($url="") {
	global $display;
	if($display['data']['cdate']){
		$date=$display['data']['cdate'];
	}else{
		$date=date("Y-m");
	}
	$ad=explode('-',$date);
	$y=$ad[0];
	$m=(int)$ad[1];
	$l = date("j", mktime(0, 0, 0, $m + 1, 0, $y));
	$s = date("w", mktime(0, 0, 0, $m, 1, $y));
	
	$ldate = date("Y-m", strtotime("-1 month", strtotime($ad[0].'-'.$ad[1].'-01')));
	$rdate = date("Y-m", strtotime("+1 month", strtotime($ad[0].'-'.$ad[1].'-01')));
	if($p=$display['post']['project_id']){
		$p='&project_id='.$p;
	}
	$r='<div class="calendar2">
	<p class="l"><a href="?id='.$display['post']['user_id'].'&date='.$ldate.$p.'">&lt;</a></p>
	<p class="r"><a href="?id='.$display['post']['user_id'].'&date='.$rdate.$p.'">&gt;</a></p>
	<p>'.$y.'年'.$m.'月</p>';
	if($url){
		$r.='<form action="?" method="post" name="calendar_form" id="calendar_form">';
	}
	$r.='<table><tr>';
	foreach($display['list']['week'] as $key => $val){
		if($key > 6){
			break;
		}
		$r.='<th>'.$val.'</th>';
	}
	$r.='</tr><tr>';
	for ($i=1;$i<=$l;$i++) {
		if($s){
			while ($s>0) {
				$r.='<td class="s"></td>';
				$s--;
				$c++;
			}
		}
		if($c>=7){
			$r.='</tr><tr>';
			$c=1;
		}else{
			$c++;
		}
		$d=$y.'-'.str_pad($m,2,'0',STR_PAD_LEFT).'-'.str_pad($i,2,'0',STR_PAD_LEFT);
		if($display['data']['calendar'][$d]['count'] && $d < date('Y-m-d')){
			if(isset($display['data']['calendar2'][$d]['count']) && $display['data']['calendar'][$d]['count']==$display['data']['calendar2'][$d]['count']){
				$r.='<td>';
			}else{
				$r.='<td class="bgc2">';
			}
		}elseif($display['data']['calendar'][$d]['user_attendance_text1']){
		$r.='<td class="bgc7">';
		}else{
		$r.='<td>';
		}
		if($url){
			$r.='<a class="fancybox fancybox.iframe" href="'.$url.'?id='.$display['post']['user_id'].'&date='.$d.'">';
		}
		if($d==date('Y-m-d')){
			$r.='<strong>';
		}
		$r.=$i;
		if($d==date('Y-m-d')){
			$r.='</strong>';
		}
		if($url){
			$r.='</a>';
		}
		if($url){
			$r.='<select name="user_attendance_status['.$d.']">';
			foreach($display['list']['user_attendance_status_disp'] as $key => $val){
				$r.='<option value="'.$key.'" '.Selected($display['data']['calendar'][$d]['user_attendance_status'],$key).'>'.$val.'</option>';
			}
			$r.='</select>';
		}else{
			if($display['data']['calendar'][$d]['user_attendance_status']){
				$r.='<p>'.$display['list']['user_attendance_status_disp'][$display['data']['calendar'][$d]['user_attendance_status']].'</p>';
			}
		}
		$r.='</td>';
	}
	if($c){
		$c = 6-$c;
		while ($c>0) {
			$r.='<td class="s"></td>';
			$c--;
		}
	}
	$r.='</tr></table>
	<div class="rei">';
	foreach($display['list']['user_attendance_status_disp'] as $key => $val){
		if($key){
			$r.='<span class="red">'.$val.'</span>:'.$display['list']['user_attendance_status'][$key].' ';
		}
	}
	$r.='<span class="bgc7">備考欄記載有</span> ';
	$r.='<span class="bgc2">日報未提出</span> ';
	$r.='</div>';
	
	if($url){
	$r.='<div class="btBox">
    <input type="hidden" name="mode" value="all_edit" />
    <input type="hidden" name="user_id" value="'.$display['post']['user_id'].'" />
    <input type="hidden" name="date" value="'.$date.'" />
    <input type="hidden" name="project_id" value="'.$display['post']['project_id'].'" />
	<input type="submit" class="btn" value="一括更新" />
	</div></form>';
	}
	
	$r.='</div>';
	echo $r;
}
function sortBtn($val,$key,$sort){
	global $display;
	$res='<a href="#" onclick="sendForm(\'sort\',\''.$key.'\')">'.$val;
	if($display['session']['src'][$sort]['sort']==$key){ 
		$res.='▼';
	}
	$res.='</a>';
	return $res;
}



















}
?>