<?php
$admin = new admin();
$admin->admin_check();
$dbHelper = new DbHelper();
$dbHelper->open();

$display['post']['user_id']=$_SESSION['user_id'];
if(!checkUser($display['post']['user_id'])){
	gfErr('権限がありません。参加者登録をして下さい。');
}

$params = $dbHelper->sanitize($display['post']);

if (!empty($_FILES)) {
$tempFile = $_FILES['file']['tmp_name'];

switch ($_FILES['file']['error']) {
	case UPLOAD_ERR_OK: // OK
		break;
	case UPLOAD_ERR_NO_FILE:   // ファイル未選択
		echo 'ファイルが選択されていません。';
		exit();
	case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
	case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
		echo 'ファイルサイズが大きすぎます。';
		exit();
	default:
		echo 'その他のエラーが発生しました。';
		exit();
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$ftype = $finfo->file($tempFile);
$k=array('text/plain','application/pdf','application/msword','application/x-zip-compressed','image/png','image/jpeg','image/gif','application/msword','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.presentationml.presentation');
if(!in_array($ftype,$k)){
	echo '許可されてないファイルの種類です。';
	exit();
}

$filename = basename($_FILES['file']['name']);
$type = substr($filename, strrpos($filename, '.') + 1);
if($type=='jpeg'){
	$type='jpg';
}
$key = md5(uniqid(rand(),1));

$arrValue='';
$arrValue['upfile_name']=$filename;
$arrValue['upfile_type']=$type;
$arrValue['upfile_key']=$key;

$targetFile = TMP_UPFILE_DIR.$key.'.'.$type;
if(!move_uploaded_file($tempFile,$targetFile)){
	echo 'アップロードに失敗しました。';
	exit();
}

$return=$dbHelper->sql_send('upfile',array_merge(array_keys($arrValue),array('upfile_create_time','upfile_create_user','upfile_update_time','upfile_update_user')),$arrValue);

$img_size=getimagesize($targetFile);

echo $key;

switch ($img_size[2]){
	case IMAGETYPE_GIF:
		$imageType = "gif";
		break;
	case IMAGETYPE_JPEG:
		$imageType = "jpeg";
		break;
	case IMAGETYPE_PNG:
		$imageType = "png";
		break;
	default:
		exit();
}
$max_w=500;
$max_h=500;

if($img_size[0] >= $img_size[1] && $img_size[0] > $max_w){
	$xhi=($max_w/$img_size[0]);
	$x=$max_w;
	$y=$img_size[1]*$xhi;
	$imageFunc = "imagecreatefrom{$imageType}";
	$src = $imageFunc($targetFile);
	$dst=imagecreatetruecolor($x,$y);
	imagecopyresampled($dst,$src,0,0,0,0,$x,$y,$img_size[0],$img_size[1]);
	$imageFunc = "image{$imageType}";
	$imageFunc($dst, $targetFile);
	
}elseif($img_size[0] < $img_size[1] && $img_size[1] > $max_h){
	$yhi=($max_h/$img_size[1]);
	$x=$img_size[0]*$yhi;
	$y=$max_h;
	$imageFunc = "imagecreatefrom{$imageType}";
	$src = $imageFunc($targetFile);
	$dst=imagecreatetruecolor($x,$y);
	imagecopyresampled($dst,$src,0,0,0,0,$x,$y,$img_size[0],$img_size[1]);
	$imageFunc = "image{$imageType}";
	$imageFunc($dst, $targetFile);
}

}