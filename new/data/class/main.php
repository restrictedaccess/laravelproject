<?php
class main {
function gf_init(){
	global $display;
	if(!$_SESSION['referer']){
		$_SESSION['referer']=$_SERVER['HTTP_REFERER'];
	}
	if(strpos($_SERVER['REQUEST_URI'],'?')){
		$getArr1=explode('?',$_SERVER['REQUEST_URI']);
		if(strpos($getArr1[1],'&')){
			$getArr2=explode('&',$getArr1[1]);
		}else{
			$getArr2[]=$getArr1[1];
		}
		foreach($getArr2 as $val){
			if(strpos($val,'=')){
				$getArr3=explode('=',$val);
				$_GET[$getArr3[0]]=$getArr3[1];
			}
		}
	}
	if(!$_POST){
		$this->setToken();
	}
	else{
//		$this->checkToken();
	}
	
	if($_GET['utm_campaign']){
		$_SESSION['utm_campaign']=$_GET['utm_campaign'];
	}
	if($_GET['utm_medium']){
		$_SESSION['utm_medium']=$_GET['utm_medium'];
	}
	if($_GET['utm_source']){
		$_SESSION['utm_source']=$_GET['utm_source'];
	}
	
	$display['get']=$this->gf_html_sanitize($_GET);
	$display['post']=$this->gf_html_sanitize($_POST);
	$display['session']=$this->gf_html_sanitize($_SESSION);
}
function setToken(){
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}
function checkToken(){
    if(!isset($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])){
		echo 'token error';
        exit;
    }
}	
function gf_add_error_message($_msg){
	global $display;
	$display['errmsg'] = $_msg;
	$display['errarr'][] = $_msg;
}
function gf_html_sanitize($_vals,$flg=1){
	$ret = "";
	if (is_array($_vals)){
		$ret = array();
		foreach($_vals as $key => $val){
			if (is_array($val)){
				$ret[$key] = $this->gf_html_sanitize($val,$flg);
			}
			else {
				if (get_magic_quotes_gpc()) {
					$val = stripslashes($val);
				}
				if($flg){
					$ret[$key] = htmlspecialchars($val);
				}else{
					$ret[$key] = $val;
				}
			}
		}
	}
	else {
		if (get_magic_quotes_gpc()) {
			$ret = stripslashes($_vals);
		}
		if($flg){
			$ret = htmlspecialchars($_vals);
		}else{
			$ret = $_vals;
		}
	}
	return $ret;

}
function gf_stripslashes($_vals){
	$ret = "";
	if (get_magic_quotes_gpc()) {
		if (is_array($_vals)){
			$ret = array();
			foreach($_vals as $key => $val){
				if (is_array($val)){
					$ret[$key] = $this->gf_stripslashes($val);
				}
				else {
					$ret[$key] = stripslashes($val);
				}
			}
		}
		else {
			$ret = stripslashes($_vals);
		}
	}
	return $ret;
}
function Checked($value, $str){
	if(is_array($value)){
		if(in_array($str,$value)){
			$var="checked";
		}
	}else{
		if(isset($value) && $value!=='' && $value == $str){
			$var="checked";
		}
	}
return $var;
}

function Selected($value, $str){
	if(is_array($value)){
		if(in_array($str,$value)){
			$var="selected";
		}
	}else{
		if(isset($value) && $value!=='' && $value == $str){
			$var="selected";
		}
	}
return $var;
}

function ifActive($no,$id){
	if($no==$id){
		return '_active';
	}
}
function check($keyArr,$data,$search=''){
	foreach($keyArr as $key => $val){
		if(is_array($data[$key])){
			foreach($data[$key] as $key2=>$val2){
				if($err=$this->check($val['array'],$val2,$search)){
					$arrErr[$key][$key2]=$err;
				}
			}
		}elseif($val['check']){
			if(in_array('checkMust',$val['check']) && !$search){
				if($data['mode']=='conf' && $val['input']=='tel'){
					if(!$data[$key.'1'] || !$data[$key.'2'] || !$data[$key.'3']){
						$arrErr[$key]='Please enter a '.$val['name'];
					}
				}elseif(!$data[$key]){
					$arrErr[$key]='Please enter a '.$val['name'];
				}
			}
			if(in_array('checkDate',$val['check'])){
				if($data['mode']=='search'){
					if($data[$key.'_s'] && !(preg_match("|^\d{4}\/\d{2}\/\d{2}$|", $data[$key.'_s']) || preg_match("|^\d{4}\-\d{2}\-\d{2}$|", $data[$key.'_s']))) {
						$arrErr[$key]='Please enter the correct date '.$val['name'];
					}
					if($data[$key.'_e'] && !(preg_match("|^\d{4}\/\d{2}\/\d{2}$|", $data[$key.'_e']) || preg_match("|^\d{4}\-\d{2}\-\d{2}$|", $data[$key.'_e']))) {
						$arrErr[$key]='Please enter the correct date '.$val['name'];
					}
				}else{
					if($data[$key] && !(preg_match("|^\d{4}\/\d{2}\/\d{2}$|", $data[$key]) || preg_match("|^\d{4}\-\d{2}\-\d{2}$|", $data[$key]))) {
						$arrErr[$key]='Please enter the correct date '.$val['name'];
					}
				}
			}
			if(in_array('checkDate',$val['checkTimeStmp'])){
				if($data['mode']=='search'){
					if($data[$key.'_s'] && !(preg_match("|^\d{4}\/\d{2}\/\d{2}$|", $data[$key.'_s']) || preg_match("|^\d{4}\-\d{2}\-\d{2}$|", $data[$key.'_s']))) {
						$arrErr[$key]='Please enter the correct date '.$val['name'];
					}
					if($data[$key.'_e'] && !(preg_match("|^\d{4}\/\d{2}\/\d{2}$|", $data[$key.'_e']) || preg_match("|^\d{4}\-\d{2}\-\d{2}$|", $data[$key.'_e']))) {
						$arrErr[$key]='Please enter the correct date '.$val['name'];
					}
				}else{
					if($data[$key] && !(preg_match("|^\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}$|", $data[$key]))) {
						$arrErr[$key]='Please enter the correct date '.$val['name'];
					}
				}
			}
			if(in_array('checkInt',$val['check'])){
				  if($data[$key] && !preg_match("/^[0-9]+$/i", $data[$key])) {
					  $arrErr[$key]='Please enter a numeric value '.$val['name'];
				  }
			}
			if(in_array('checkTime',$val['check'])){
				  if($data[$key] && !is_numeric($data[$key])) {
					  $arrErr[$key]='Please enter the correct time '.$val['name'];
				  }
			}
			if(in_array('checkTel',$val['check'])){
				  if($data[$key] && !preg_match("/^\d{2,5}-?\d{2,5}-?\d{4,5}$/", $data[$key])) {
					  $arrErr[$key]='Please enter the correct '.$val['name'];
				  }
			}
			if(in_array('checkNumStr',$val['check'])){
				  if($data[$key] && !preg_match("/^[a-zA-Z0-9]+$/i", $data[$key])) {
					  $arrErr[$key]='Please enter alphanumeric '.$val['name'];
				  }
			}
			if(in_array('checkScore',$val['check'])){
				  if($data[$key] && !preg_match("/^[0-9]+$/i", $data[$key])) {
					  $arrErr[$key]='Please enter a numeric value '.$val['name'];
				  }elseif($data[$key] > 100){
					  $arrErr[$key]=$val['name'].'は100以下で入力して下さい';
				  }
			}
			if(in_array('checkMail',$val['check'])){
				if ($data['mode']!='search' && !preg_match("/^([a-zA-Z0-9+])+([a-zA-Z0-9+\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $data[$key])) {
					$arrErr[$key]='Please enter the correct '.$val['name'];
				}			
			}
			if(in_array('checkMailStr',$val['check'])){
				  if($data[$key] && !preg_match("/^[a-zA-Z0-9+\._\-@]+$/i", $data[$key])) {
					  $arrErr[$key]='Please enter alphanumeric '.$val['name'];
				  }
			}
			if(in_array('checkImg',$val['check'])){
				if($_FILES[$key]['name']){
					$name = mb_convert_kana($_FILES[$key]['name'], "KVas");
					$name = mb_strtolower($name);
					$ex=substr($name, strrpos($name, '.') + 1);
					if($ex!='jpeg' && $ex!='jpg') {
					  $arrErr[$key]=$val['name'].'is JPG only';
					}
				}
			}
			if(in_array('checkLoginID',$val['check']) && !$arrErr){
				$dbHelper = new DbHelper();
				$dbHelper->open();
				$where='';
				$where[$key]=$data[$key];
				$keys=explode('_',$kye);
				if($data['consultant_id']){
					$where['consultant_id !=']=$data['consultant_id'];
				}
				if($dbHelper->sql_get_count('consultant',$where)){
					$arrErr[$key]=$val['name'].' is already in use';
				}
			}
			if(in_array('checkManagerLoginID',$val['check']) && !$arrErr){
				$dbHelper = new DbHelper();
				$dbHelper->open();
				$where='';
				$where[$key]=$data[$key];
				$keys=explode('_',$kye);
				if($data['manager_id']){
					$where['manager_id !=']=$data['manager_id'];
				}
				if($dbHelper->sql_get_count('manager',$where)){
					$arrErr[$key]=$val['name'].' is already in use';
				}
			}
			if(in_array('menuType',$val['check'])){
				foreach($data[$key] as $key2 => $val2){
					if($val2['check']){
						$check=1;
						break;
					}
				}
				if(!$check) {
					$arrErr[$key]='Please enter one or more of the '.$val['name'];
				}
			}
			if(in_array('checkLength',$val['check']) && $data[$key]){
				if($val['min'] && $val['max']){
					if(strlen($data[$key]) > $val['min']){
						$arrErr[$key]='Please enter at least '.$val['min'].' characters more than '.$val['max'].' characters the '.$val['name'];
					}
				}elseif($val['max']){
					if(strlen($data[$key]) > $val['max']){
						$arrErr[$key]='Please enter the '.$val['min'].' letters following of the '.$val['name'];
					}
				}elseif($val['min']){
					if(strlen($data[$key]) < $val['min']){
						$arrErr[$key]='Please enter at least '.$val['min'].' characters of the '.$val['name'];
					}
				}
			}

		}
	}
	return $arrErr;
}
function searchWhere($keyArr,$data){
	foreach($keyArr as $key => $val){
		if($val['search']){
			if($val['search']=='date'){
				if($data[$key.'_s']){
					$w[$key.' >=']=$data[$key.'_s'];
				}
				if($data[$key.'_e']){
					$w[$key.' < ']=date("Y-m-d", strtotime($data[$key.'_e']." +1 day"));
				}
			}elseif($val['search']=='range'){
				if($data[$key.'_s']){
					$w[$key.' >=']=$data[$key.'_s'];
				}
				if($data[$key.'_e']){
					$w[$key.' <= ']=$data[$key.'_e'];
				}
			}elseif($val['search']=='check'){
				if($data[$key]){
					$w[$key.' in']=$data[$key];
				}
			}elseif($val['search']=='text'){
				if($data[$key]){
					$w[$key.' like']=$data[$key];
				}
			}elseif($data[$key]){
				if(is_array($data[$key])){
					$w[$key.' in']=$data[$key];
				}else{
					$w[$key]=$data[$key];
				}
			}
		}
	}
	if($data['keyword']){
		$keyword=mysql_real_escape_string($data['keyword']);
		$keyword=str_replace ('%', '\%', $keyword);
		$keyword=str_replace ('_', '\_', $keyword);
		foreach($keyArr as $key => $val){
			if(strpos($key,'_text') || strpos($key,'_name')){
				if(!$w['join_keyword']){
					$w['join_keyword']='('.$key.' like "%'.$keyword.'%"';
				}else{
					$w['join_keyword'].=' or '.$key.' like "%'.$keyword.'%"';
				}
			}
		}
		if($w['join_keyword']){
			$w['join_keyword'].=')';
		}
	}
	return $w;
}
function pLog($log_file,$data){
	$file = LOG_DIR.$log_file;
	if(is_file($file) && filesize($file) > 1000000){
		rename($file,$file.date("Ymd"));
	}
	if(is_array($data)){
		ob_start();
		var_dump($data);
		$data = ob_get_contents();
		ob_end_clean();
	}
	error_log(date("Y-m-d H:i:s ").$data . "\n", 3, $file);
	return;
}
function location($url){
	header("Location: ".$url);
	exit();
}

function getUser($id){
	if($id){
		$dbHelper = new DbHelper();
		$dbHelper->open();
		$where='';
		$where['user_id']=$id;
		return $dbHelper->sql_get_one2('*','user',$where);
	}
}


function sendmail($to,$subject,$body,$bcc='',$cc=''){
	return $this->phpmailersend('',$to,$subject,$body,$bcc,$cc);
}
function sendmailHtml($to,$subject,$body,$bcc='',$cc=''){
	return $this->phpmailersend(1,$to,$subject,$body,$bcc,$cc);
}

function phpmailersend($html,$toadress,$subject,$body,$bccadress='',$ccadress=''){

	if(!is_array($toadress)){
		$toadress  = explode ( ',', preg_replace ( '/\s/', '', $toadress  ) );
	}
	if(!is_array($ccadress)){
		$ccadress  = explode ( ',', preg_replace ( '/\s/', '', $ccadress  ) );
	}
	if(!is_array($bccadress)){
		$bccadress = explode ( ',', preg_replace ( '/\s/', '', $bccadress ) );
	}
	$mailer = new PHPMailer();
	
	$mailer -> CharSet = "iso-2022-jp";
	$mailer -> Encoding = "7bit";
	
	$mailer -> IsSMTP();
	$mailer -> Host = MAIL_HOST . ":" . MAIL_PORT;
	$mailer -> SMTPAuth = TRUE;
	$mailer -> Username = MAIL_USERNAME; 
	$mailer -> Password = MAIL_PASSWORD;
	$mailer -> From     = MAIL_FROM;
	$mailer -> FromName = mb_encode_mimeheader ( mb_convert_encoding ( $fromname, "JIS", "UTF-8" ) );
	$mailer -> Subject  = mb_encode_mimeheader ( mb_convert_encoding ( $subject, "JIS", "UTF-8" ) );
	$mailer -> Body     = mb_convert_encoding ( $body, "JIS", "UTF-8" );
	
	if($html){
		$mailer->isHTML(true);
	}
	foreach ( $toadress as $to ) {
		$mailer -> AddAddress ( $to );
	}
	foreach ( $ccadress as $cc ) {
		$mailer -> AddCC  ( $cc );
	}
	foreach ( $bccadress as $bcc ) {
		$mailer -> AddBCC ( $bcc );
	}
	if( !$mailer -> Send() ){
		return $mailer->ErrorInfo;
	} else {
		return;
	}
	
}

function mailBody($type,$data){
	$body=file_get_contents(DATA_DIR.'template/mail/'.$type.'.php');
	$data['year']=date('Y');
	$data['AHOST']=AHOST;
	foreach($data as $k => $v){
		$body=str_replace('<?=$'.$k.'?>',stripslashes($v),$body);
	}
	return $body;
}

function file_upload($keyArr,$dir,$id,$x,$y){
	foreach($keyArr as $key => $val){
		if($val['input']=='file' || $val['input']=='img'){
			if($_FILES[$key]['name']){
				$_FILES[$key]['name']=mb_convert_kana(mb_strtolower($_FILES[$key]['name']), "KVas");
				$extension=substr($_FILES[$key]['name'], strrpos($_FILES[$key]['name'], '.') + 1);
				if($extension=='jpeg'){
					$extension='jpg';
				}
				$path=$dir.$key.'_'.$id.'.'.$extension;
				if(is_file($path)){
					unlink($path);
				}
				if(!move_uploaded_file($_FILES[$key]['tmp_name'],$path)){
					echo 'ファイルのアップロードに失敗しました。';
					exit();
				}
				if($extension=='jpg'){
					orientationFixed($path);
					resize($path,$x,$y);
				}
				if($extension){
					$res[$key]= $extension;
				}
			}
		}
	}
	return $res;
}

function resize($img,$max_w,$max_h){
	
	$img_size=getimagesize($img);

	if($img_size[0] >= $img_size[1] && $img_size[0] > $max_w){
		$xhi=($max_w/$img_size[0]);
		$x=$max_w;
		$y=$img_size[1]*$xhi;
	}elseif($img_size[0] < $img_size[1] && $img_size[1] > $max_h){
		$yhi=($max_h/$img_size[1]);
		$x=$img_size[0]*$yhi;
		$y=$max_h;
	}
		
	$src=imagecreatefromjpeg($img);
	$dst=imagecreatetruecolor($x,$y);

	imagecopyresampled($dst,$src,0,0,0,0,$x,$y,$img_size[0],$img_size[1]);
	imagejpeg($dst, $img);
}

function file_release($keyArr,$path1,$path2,$id1,$id2,$post){
	foreach($keyArr as $key => $val){
		if($val['input']=='file' || $val['input']=='img'){
			$file1=$path1.$key.'_'.$id1.'.'.$post['extension'][$key];
			$file2=$path2.$key.'/'.$this->cipher($id2).'.'.$post['extension'][$key];
			if($post['imgdel'][$key]){
				$this->file_delete($path2.$key,cipher($id2));
			}elseif(is_file($file1)){
				$this->file_delete($path2.$key,cipher($id2));
				rename($file1,$file2);
			}
		}
	}
}
function file_delete($key,$id){
	$files=glob($key.'/'.$id.".*");
	foreach($files as $val){
		unlink($val);
	}
}
function cipher($str){
	return hash('sha256',md5($str).SALT);
}
function deleteTemp($keyArr,$id){
	foreach($keyArr as $key => $val){
		if($val['input']=='file' || $val['input']=='img'){
			$this->file_delete(HTML_DIR.'admin/upfile/',$key.'_'.$id);
		}
	}
}
function getExtension($keyArr,$id,$admin=0){
	foreach($keyArr as $key => $val){
		if($val['input']=='file' || $val['input']=='img' || $val['input']=='imgprev'){
			if($admin){
			$files=glob(HTML_DIR.'admin/upfile/'.$key.'_'.$id.".*");
			}else{
			$files=glob(UPFILE_DIR.$key.'/'.cipher($id).".*");
			}
			$res[$key]=substr($files[0], strrpos($files[0], '.') + 1);
		}
	}
	return $res;
}

function list_dir_by_opendir($dir)
{
    $ret[] = $dir;
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $file = $dir . DIRECTORY_SEPARATOR . $file;
            $ret[] = $file;
        }
        closedir($dh);
    }
    return $ret;
}

function orientationFixed($raw)
  {
    $img = new Imagick();
    $ver = $img->getVersion();
    
    $img->readImage($raw);
    $orientation = 0;
    if( method_exists($img, "getImageOrientation") ){
      $orientation = $img->getImageOrientation();
    }
    switch((int)$orientation) {
      case 0:#未定義
        break;
      case 1:#通常
        break;
      case 2:#左右反転
        $img->flopImage();
		break;
      case 3:#180°回転
        $img->rotateImage(new ImagickPixel(), 180 );
        break;
      case 4:#上下反転
        $img->flipImage();
        break;
      case 5:#反時計回りに90°回転 上下反転
        $img->rotateImage(new ImagickPixel(), 270 );
        $img->flipImage();
        break;
      case 6:#時計回りに90°回転
        $img->rotateImage(new ImagickPixel(), 90 );
        break;
      case 7:#時計回りに90°回転 上下反転
        $img->rotateImage(new ImagickPixel(), 90 );
        $img->flipImage();
        break;
      case 8:#反時計回りに90°回転
        $img->rotateImage(new ImagickPixel(), 270 );
        break;
    }
	if((int)$orientation > 1){
		$img->setimageorientation(imagick::ORIENTATION_TOPLEFT);
		$img->writeImage();
	}
}

function complete($table,$arrKey,$params){
	global $display;
	$dbHelper = new DbHelper();
	$dbHelper->open();
	foreach($arrKey as $key => $val){
		if($params['daily_id'] && $key=='daily_user_id'){
			continue;
		}
		if($val['input']!='img' && $val['input']!='imgprev' && $val['input']!='file' && $val['input']!='array' && $val['input']!='submit' && $val['name']){
			$key_array[]=$key;
		}
	}
	$return=$dbHelper->sql_send($table,$key_array,$params,$table.'_id');
	if($return['insert_id']){
		$params[$table.'_id']=$return['insert_id'];
	}
	if($params['file_key']){
		foreach($params['file_key'] as $key){
			$where['upfile_key']=$key;
			$where['upfile_enabled']=0;
			$type=$dbHelper->sql_get_one('upfile_type','upfile',$where);
			if(!$type){
				continue;
			}
			$file=$key.'.'.$type;
			if(!is_file(TMP_UPFILE_DIR.$file)){
				continue;
			}
			$arrValues='';
			$arrValues['upfile_enabled']=1;
			$arrValues['upfile_class']=$display['list']['upfile_class'][$table];
			$arrValues['upfile_join_id']=$params[$table.'_id'];
			$arrValues['upfile_update_time']=date("Y-m-d H:i:s");
			$arrValues['upfile_update_user']=$_SESSION['user_id'];
			$dbHelper->sql_update_list('upfile',$arrValues,$where);
			rename (TMP_UPFILE_DIR.$file, SAVE_UPFILE_DIR.$file);
		}
	}
	if($params['file_del']){
		foreach($params['file_del'] as $key => $val){
			if(!$val){
				continue;
			}
			$where['upfile_id']=$key;
			$res=$dbHelper->sql_get_one2('*','upfile',$where);
			if(!$res){
				continue;
			}
			$file=$res['upfile_key'].'.'.$res['upfile_type'];
			$dbHelper->sql_delete_contents('upfile',$key,1);
			if(is_file(SAVE_UPFILE_DIR.$file)){
				unlink(SAVE_UPFILE_DIR.$file);
			}
		}
	}
}

function createFileLink($key,$flg=''){
	$dbHelper = new DbHelper();
	$dbHelper->open();
	$where['upfile_key']=$key;
	if($flg){
		$where['upfile_enabled']=0;
	}
	$res=$dbHelper->sql_get_one2('*','upfile',$where);
	$img=array('jpg','gif','png');

	$file=$key.'.'.$res['upfile_type'];
	if($flg){
		if(!is_file(TMP_UPFILE_DIR.$file)){
			return;
		}
		$key.='&t=1';
	}else{
		if(!is_file(SAVE_UPFILE_DIR.$file)){
			return;
		}
	}
	if(in_array($res['upfile_type'],$img)){
		return '<a class="fancybox" href="file.html?key='.$key.'" data-fancybox-type="image"><img src="file.html?key='.$key.'" alt="'.$res['upfile_name'].'" class="photo"></a>';
	}else{
		return '<span class="'.$res['upfile_type'].'"><a href="file.html?key='.$key.'">'.$res['upfile_name'].'</a></span>';
	}
}

function createParams($keys,$params){
	foreach($keys as $k => $v){
		if($v['input']=='other'){
			$params[$k]=implode('/',$params[$k]);
		}elseif($v['input']=='date'){
			if(!$params[$k]){
				$params[$k]='NULL';
			}
		}elseif($v['input']=='password'){
			if($params[$k]=='dummy123'){
				unset($params[$k]);
			}
		}
	}
	return $params;
}

function checkClient($id){
	$dbHelper = new DbHelper();
	$dbHelper->open();
	$where['client_id']=$id;
	return sql_get_count('client',$where);
}

function createBMI($h,$hu,$w,$wu){
	if($h && $w){
		if($hu==1){
			$h2=explode('′',$h);
			$height=$h2[0]*0.3048+$h2[1]*0.0254;
		}else{
			$height=$h*0.01;
		}
		if($wu==1){
			$weigh=$w*0.453592;
		}else{
			$weigh=$w;
		}
		$res=round($weigh/($height*$height),1);
		return $res;
	}
}

function utc($time,$utc,$flg){
	if($utc >= 0 || !$utc){
		$utc='+'.(int)$utc;
	}
	if($flg==1){
	return date("j M Y", strtotime($time." ".$utc." hour")).'(UTC'.$utc.')';
	}elseif($flg==2){
	return date("H:i", strtotime($time." ".$utc." hour")).'(UTC'.$utc.')';
	}else{
	return date("j M Y H:i:s", strtotime($time." ".$utc." hour")).'(UTC'.$utc.')';
	}
}

function age($birthday){
	if($birthday){
		return floor((date('Ymd') - str_replace('-','',$birthday))/10000);
	}
}

function time_diff($time_from, $time_to='',$flg=0)
{
	$from=strtotime($time_from);
	if($time_to){
		$to=strtotime($time_to);
	}else{
		$to=strtotime("now");
	}
    // 日時差を秒数で取得
    $dif = $to - $from;
    // 時間単位の差
    $dif_time = date("H:i:s", $dif);
    // 日付単位の差
    $dif_days = (strtotime(date("Y-m-d", $dif)) - strtotime("1970-01-01")) / 86400;
	
	$res='';
	if($dif_days){
		$res=$dif_days;
		if($flg!=2){
			$res.='days ';
		}
	}
	if(!$flg){
		$res.=$dif_time;
	}
    return $res;
}

function checkUserAgent($flg=0){
	if (empty($user_agent)) {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	}
	if($flg==1){
		/** os判定 */
		if (preg_match('/Windows NT 6.3/', $user_agent)) {
			$os = 'Windows 8.1';
		} elseif (preg_match('/Windows NT 6.2/', $user_agent)) {
			$os = 'Windows 8';
		} elseif (preg_match('/Windows NT 6.1/', $user_agent)) {
			$os = 'Windows 7';
		} elseif (preg_match('/Windows NT 6.0/', $user_agent)) {
			$os = 'Windows Vista';
		} elseif (preg_match('/Windows NT 5.2/', $user_agent)) {
			$os = 'Windows Server 2003 / Windows XP x64 Edition';
		} elseif (preg_match('/Windows NT 5.1/', $user_agent)) {
			$os = 'Windows XP';
		} elseif (preg_match('/Windows NT 5.0/', $user_agent)) {
			$os = 'Windows 2000';
		} elseif (preg_match('/Windows NT 4.0/', $user_agent)) {
			$os = 'Microsoft Windows NT 4.0'; 
		} elseif (preg_match('/Mac OS X ([0-9\._]+)/', $user_agent, $matches)) {
			$os = 'Macintosh Intel ' . str_replace('_', '.', $matches[1]);
		} elseif (preg_match('/Linux ([a-z0-9_]+)/', $user_agent, $matches)) {
			$os = 'Linux ' . $matches[1];
		} elseif (preg_match('/OS ([a-z0-9_]+)/', $user_agent, $matches)) {
			$os = 'iOS ' . str_replace('_', '.', $matches[1]);
		} elseif (preg_match('/Android ([a-z0-9\.]+)/', $user_agent, $matches)) {
			$os = 'Android ' . $matches[1];
		} else {
			$os = 'unknown';
		}
		return $os;
	}elseif($flg==2){
	/** ブラウザ判定（PC以外はスマホと表示） */
    // マイナー
    if (preg_match('/(Iron|Sleipnir|Maxthon|Lunascape|SeaMonkey|Camino|PaleMoon|Waterfox|Cyberfox)\/([0-9\.]+)/', $user_agent, $matches)) {
        $browser = $matches[1];
        $version = $matches[2];
    // 主要
    } elseif (preg_match('/(^Opera|OPR).*\/([0-9\.]+)/', $user_agent, $matches)) {
        $browser = 'Opera';
        $version = $matches[2];
    } elseif (preg_match('/Chrome\/([0-9\.]+)/', $user_agent, $matches)) {
        $browser = 'Chrome';
        $version = $matches[1]; 
    } elseif (preg_match('/Firefox\/([0-9\.]+)/', $user_agent, $matches)) {
        $browser = 'Firefox';
        $version = $matches[1];
    } elseif (preg_match('/(MSIE\s|Trident.*rv:)([0-9\.]+)/', $user_agent, $matches)) {
        $browser = 'Internet Explorer';
        $version = $matches[2];
    } elseif (preg_match('/\/([0-9\.]+)(\sMobile\/[A-Z0-9]{6})?\sSafari/', $user_agent, $matches)) {
        $browser = 'Safari';
        $version = $matches[1];
    // ゲーム機
    } elseif (preg_match('/Nintendo (3DS|WiiU)/', $user_agent, $matches)) {
        $browser = 'Nintendo';
        $version = $matches[1];
    } elseif (preg_match('/PLAYSTATION (3|Vita)/', $user_agent, $matches)) {
        $browser = 'PLAYSTATION';
        $version = $matches[1];
    // BOT
    } elseif (preg_match('/(Googlebot|bingbot)\/([0-9\.]+)/', $user_agent, $matches)) {
        $browser = $matches[1];
        $version = $matches[2];
    } else {
        $browser = 'unknown';
        $version = '';
    }
		return $browser.' '.$version;
	}else{
		/** デバイス判定 */
		if (preg_match('/iPhone;/', $user_agent)) {
			$device = 'iPhone';
		} elseif (preg_match('/iPod/', $user_agent)) {
			$device = 'iPod';
		} elseif (preg_match('/iPad/', $user_agent)) {
			$device = 'iPad';      
		} elseif (preg_match('/Android/', $user_agent)) {
			$device = 'Android';
		} elseif (preg_match('/Windows Phone/', $user_agent)) {
			$device = 'Windows Phone';
		} elseif (preg_match('/(BlackBerry|BB)/', $user_agent)) {
			$device = 'BlackBerry';
		} elseif (preg_match('/PlayStation Vita/', $user_agent)) {
			$device = 'PlayStation Vita';
		} elseif (preg_match('/PlayStation Portable/', $user_agent)) {
			$device = 'PlayStation Portable';
		} elseif (preg_match('/(PS2|PLAYSTATION 3|PlayStation 4)/', $user_agent)) {
			$device = 'PlayStation';
		} elseif (preg_match('/Nintendo 3DS/', $user_agent)) {
			$device = 'Nintendo 3DS';
		} elseif (preg_match('/Nintendo (Wii|WiiU)/', $user_agent)) {
			$device = 'Nintendo Wii(U)';
		} else {
			$device = 'PC';
		}
		if($flg==3){
			return $device;
		}else{
			if($device != 'PC'){
				return true;
			}
		}
	}
}

}