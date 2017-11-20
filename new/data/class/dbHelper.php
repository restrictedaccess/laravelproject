<?php
class DbHelper {
	var $db;
	function open(){
		$p=new page();
		$this->db = mysql_connect(DB_HOST, DB_USER, DB_PASS);
		if ($this->db){
			$ret = mysql_select_db(DB_NAME, $this->db);
			if ($ret){
				$this->execute('set names ' . PHP_ENC);
			}
			else {
				$p->gfErr('DbHelper->open():' . mysql_error($this->db));
			}
		}
		else {
			$p->gfErr('DbHelper->open():データベースの接続に失敗しました。');
		}
			
		return $this->db;
	}
	function execute($_sql){
		$p=new page();
		$m=new main();
		$this->add_sql($_sql);
		if(preg_match("/^\s*(?:select|show|describe|explain|set names)/i", $_sql)){
			$ret = mysql_query($_sql, $this->db);
		}else{
			mysql_query("begin");
			if($ret = mysql_query($_sql, $this->db)){
				if(preg_match("/^\s*(?:insert into)/i", $_sql)){
					$id = mysql_insert_id();
				}
				if(DEBUG_MODE != 1){
					$m->pLog('db.log',$_sql);
				}
				mysql_query("commit");
			}else{
				mysql_query("rollback");
			}
		}
		if (!$ret){
			$p->gfErr($_sql . mysql_error($this->db));
		}elseif($id){
			return $id;
		}
		return $ret;
	}
	function add_sql($sql){
		global $display;
		if(DEBUG_MODE == 1){
			$display['sql'][] = $sql;
		}
	}	
	function sanitize($_vals, $_is_html_sanitize = ''){
		$ret = array();
		if ($_is_html_sanitize){
			$_vals = gf_html_sanitize($_vals);
		}
		if (is_array($_vals)){
			foreach($_vals as $key => $val){
				if (is_array($val)){
					$ret[$key] = $this->sanitize($val,$_is_html_sanitize);
				}
				else {
					$ret[$key] = mysql_real_escape_string($val);
				}
			}
		}else{
			$ret = mysql_real_escape_string($_vals);
		}
		return $ret;
	}
	function sql_stripslashes($_vals){
		$_vals = str_replace(array('\r\n','\r','\n'), "\n", $_vals);
		$_vals = str_replace('\t',"\t",$_vals);
		$ret=stripslashes($_vals);
		return $ret;
	}
	function select_hash_array($sql, $_value, $_display){
		$result = $this->execute($sql);
		$ret = array();
		while($row = mysql_fetch_array($result)){
			array_push($ret, array('display'=>$row[$_display], 'value'=>$row[$_value]));
		}
		return $ret;
	}
	
	
	function sql_send($table,$post_array,$key=''){
		$key_array=$this->sql_get_columns($table);
		$post_array=$this->sanitize($post_array);
		for($i=0;$i<count($key_array);$i++){
			if($key_array[$i]==$table.'_create_time' || $key_array[$i]==$table.'_update_time'){
				$array[$key_array[$i]] = '';
			}elseif(isset($post_array[$key_array[$i]])){
				$array[$key_array[$i]] = $post_array[$key_array[$i]];
			}
		}
		$count=count($array);
		$tstamp=date("Y-m-d H:i:s");
		if(!$post_array[$key]){
			$sql='insert into `'.$table.'` set ';
			for($i=0;$i<count($array);$i++){
				$data=each($array);
				if($data['key']==$key){
					continue;
				}elseif($data['key']==$table.'_create_time'){
					$sql.='`'.$data['key'].'`="'.$tstamp.'"';
				}elseif($data['key']==$table.'_update_time'){
					$sql.='`'.$data['key'].'`="'.$tstamp.'"';
				}elseif($data['key']==$table.'_create_user'){
					$sql.='`'.$data['key'].'`="'.$_SESSION['user_id'].'"';
				}elseif($data['key']==$table.'_update_user'){
					$sql.='`'.$data['key'].'`="'.$_SESSION['user_id'].'"';
				}elseif($data['value']=='NULL'){
					$sql.='`'.$data['key'].'`=NULL';
				}else{
					$sql.='`'.$data['key'].'`="'.$data['value'].'"';
				}
				if($i+1!=$count){
					$sql.=',';
				}
			}
			$return['insert_id']=$this->execute($sql);
			
		}else{
			$sql='update `'.$table.'` set ';
			for($i=0;$i<count($array);$i++){
				$data=each($array);
				if($data['key']==$key){
					continue;
				}elseif($data['key']==$table.'_create_time'){
					continue;
				}elseif($data['key']==$table.'_update_time'){
					$sql.='`'.$data['key'].'`="'.$tstamp.'"';
				}elseif($data['key']==$table.'_create_user'){
					continue;
				}elseif($data['key']==$table.'_update_user'){
					$sql.='`'.$data['key'].'`="'.$_SESSION['user_id'].'"';
				}elseif($data['value']=='NULL'){
					$sql.='`'.$data['key'].'`=NULL';
				}else{
					$sql.='`'.$data['key'].'`="'.$data['value'].'"';
				}
				if($i+1!=$count){
					$sql.=',';
				}
			}
			$sql.=' where `'.$key.'`="'.$post_array[$key].'";';
			$this->execute($sql);
		}
		return $return;
	}
	function sql_get_contents($table,$val='',$key=''){
		if(!$key){
			$key=$table.'_id';
		}
		$sql='select * from `'.$table.'` where `'.$key.'`="'.$this->sanitize($val).'" limit 1;';
		$result = $this->execute($sql);
		$array = mysql_fetch_assoc($result);
		for($i=0;$i<count($array);$i++){
			$data=each($array);
			$array2[$data['key']]=$this->sql_stripslashes($data['value']);
		}
		$return['contents']=$array2;
		return $return;
	}
	function where($where,$order,$group,$limit){
		if(is_array($where)){
			foreach($where as $key => $val ){
				if($sql){
					$sql .=' and ';
				}else{
					$sql .=' where ';
				}
				if(strpos($key,'<') || strpos($key,'>') || strpos($key,'!')){
					$sql.= $key . "'".mysql_real_escape_string($val)."'";
				}elseif(strpos($key,'=')){
					$sql.= $key . mysql_real_escape_string($val);
				}elseif(strpos($key,' like')){
					$val=mysql_real_escape_string($val);
					$val=str_replace ('%', '\%', $val);
					$val=str_replace ('_', '\_', $val);
					$sql.= $key ."'%". $val."%'";
				}elseif(strpos($key,'join')===0){
					$sql.= $val;
				}elseif(strpos($key,' in')){
					if(is_array($val)){
						$arrIn='';
						foreach($val as $in){
							if($arrIn){
								$arrIn.=',';
							}
							$arrIn.="'".mysql_real_escape_string($in)."'";
						}
					}elseif($val){
						$arrIn="'".$val."'";
					}else{
						$arrIn='NULL';
					}
					$sql.= $key . "(".$arrIn.")";
					
				}elseif($val==='NULL'){
					$sql.= $key .' is '. $val;
				}else{
					$sql.= $key . " = '".mysql_real_escape_string($val)."'";
				}
			}
		}elseif($where){
			$sql.=' where '.$where;
		}
		if($group){
			if(is_array($group)){
				$order=implode(',',$group);
			}
			$sql.=' group by '.$group;
		}
		if($order){
			if(is_array($order)){
				$order=implode(',',$order);
			}
			$sql.=' order by '.$order;
		}
		if($limit){
			if(is_array($limit)){
				$sql.=' limit '.$limit[0].' offset '.(int)$limit[1];
			}else{
				$sql.=' limit '.$limit;
			}
		}
		return $sql;
	}
	function limit($page,$table){
		global $display;
		if(is_array($page)){
			$res[0]=$page[0];
			if($page[1]){
				$res[1]=$page[1];
			}else{
				$res[1]=0;
			}
		}if($page){
			if($table){
				$maxPage=$display['list'][$table.'_limit'];
			}
			if(is_array($page)){
				$res=$page;
			}elseif($maxPage){
				if($page==1){
					$res=$maxPage;
				}else{
					$res[0]=$maxPage;
					$res[1]=($page-1)*$maxPage;
				}
			}else{
				if($page==1){
					$res=MAX_PAGE;
				}else{
					$res[0]=MAX_PAGE;
					$res[1]=($page-1)*MAX_PAGE;
				}
			}
		}
		return $res;
	}
	function table($table){
		if(is_array($table)){
			foreach($table as $key => $val){
				if($key==='join'){
					$join[]=$val;
				}else{
					$r[]=$val;
				}
			}
			$res=implode(',',$r);
			if($join){
				$res.=' '.implode(' ',$join);
			}
			return $res;
		}else{
			return $table;
		}
	}
	function add_where($table,$where){
		if(!is_array($table)){
			$table=array($table);
		}
		foreach($table as $key=>$val){
			if($key==='join' || strpos($val,'_join_')){
				continue;
			}
			if(is_array($where)){
				if(!isset($where[$val.'_del_flg'])){
					$where[$val.'_del_flg']='0';
				}
			}else{
				if($where){
					$where.=' and ';
				}
				$where.=$val.'_del_flg = 0';
			}
		}
		return $where;
	}
	function sql_get_one($col,$table,$where,$order,$group){
		if(is_array($col)){
			$col=implode(',',$col);
		}
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$where=$this->where($where,$order,$group);
		$sql='select '.$col.' from '.$table.$where.' limit 1';
		$result = $this->execute($sql);
		while( $array = mysql_fetch_assoc( $result ) ){
			foreach($array as $key => $val){
				return $this->sql_stripslashes($val);
			}
		}
		return $return;
	}
	function sql_get_one2($col,$table,$where,$order,$group){
		if(is_array($col)){
			$col=implode(',',$col);
		}
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$where=$this->where($where,$order,$group);
		$sql='select '.$col.' from '.$table.$where.' limit 1';
		$result = $this->execute($sql);
		
		$array = mysql_fetch_assoc($result);
		foreach($array as $key => $val){
			$return[$key]=$this->sql_stripslashes($val);
		}
		return $return;
	}
	
	function sql_get_low($col,$table,$where,$order,$group,$limit){
		if(is_array($col)){
			$col=implode(',',$col);
		}
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$where=$this->where($where,$order,$group,$limit);
		$sql='select '.$col.' from '.$table.$where;
		$result = $this->execute($sql);
		while( $array = mysql_fetch_assoc( $result ) ){
			foreach($array as $key => $val){
				$return[]=$this->sql_stripslashes($val);
			}
		}
		return $return;
	}
	function sql_get_low2($col,$table,$where,$order,$group,$limit){
		$where=$this->add_where($table,$where);
		$where=$this->where($where,$order,$group,$limit);
		if(is_array($table)){
			$from=implode(',',$table);
			$table_id=$table[0].'_id';
		}else{
			$from=$table;
			$table_id=$table.'_id';
		}
		$sql='select '.$col.','.$table_id.' from '.$from.$where;
		$result = $this->execute($sql);
		while( $array = mysql_fetch_assoc( $result ) ){
			$return[$array[$table_id]]=$this->sql_stripslashes($array[$col]);
		}
		return $return;
	}
	function sql_get_col($col,$table,$where,$order,$group,$limit){
		if(is_array($col)){
			$col=implode(',',$col);
		}
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$where=$this->where($where,$order,$group,$limit);
		$sql='select '.$col.' from '.$table.$where;
		$result = $this->execute($sql);
		while( $array = mysql_fetch_assoc( $result ) ){
			$res='';
			foreach($array as $k => $v){
				$res[$k]=$this->sql_stripslashes($v);
			}
			$return[]=$res;
		}
		return $return;
	}
	function sql_get_col2($col,$table,$where,$order,$group,$limit){
		if(is_array($col)){
			$col=implode(',',$col);
		}
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$where=$this->where($where,$order,$group,$limit);
		$sql='select '.$col.' from '.$table.$where;
		$result = $this->execute($sql);
		while( $array = mysql_fetch_assoc( $result ) ){
			foreach($array as $k => $v){
				$return[$k]=$this->sql_stripslashes($v);
			}
		}
		return $return;
	}
	
	function sql_get_list($table,$where='',$page='',$order='',$group=''){
		$return['count']=(int)$this->sql_get_count($table,$where);
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$limit=$this->limit($page,$table);
		$where=$this->where($where,$order,$group,$limit);
		$sql='select * from '.$table.$where;
		$result = $this->execute($sql);
		$i=0;
		while( $array = mysql_fetch_assoc( $result ) ){
			foreach($array as $key => $val){
				$res[$i][$key]=$this->sql_stripslashes($val);
			}
			$i++;
		}
		$return['list']=$res;
		return $return;
	}
	function sql_get_select($table,$where='',$order='',$group='',$limit=''){
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$where=$this->where($where,$order,$group,$limit);
		$sql='select * from '.$table.$where;
		$result = $this->execute($sql);
		$i=0;
		while( $array = mysql_fetch_assoc( $result ) ){
			foreach($array as $key => $val){
				$res[$i][$key]=$this->sql_stripslashes($val);
			}
			$i++;
		}
		return $res;
	}
		
	function sql_delete_contents($table,$key,$del=0,$img_count=0){
		global $display;
		if($del){
			$sql='delete from `'.$table.'` where `'.$table.'_id`="'.$key.'" limit 1;';
		}else{
			$sql='update `'.$table.'` set '.$table.'_del_flg = 1 where `'.$table.'_id`="'.$key.'" limit 1;';
		}
		$result = $this->execute($sql);
		for($i=1;$i<=$img_count;$i++){
			$file=UP_DIR1.$table.'/'.$key.'_'.$i.'.jpg';
			if(is_file($file)){
				unlink($file);
			}
		}
		if($c=$display['list']['upfile_class'][$table]){
			$table='upfile';
			$sql='update `'.$table.'` set '.$table.'_del_flg = 1 where upfile_class = "'.$c.'" and `upfile_join_id`="'.$key.'";';
			$result = $this->execute($sql);
		}
		return $return;
	}
	function sql_delete_list($table,$where=''){
		$table=$this->table($table);
		$sql='delete from '.$table;
		$res=$this->where($where);
		$result = $this->execute($sql.$res);
		return $return;
	}
	function sql_update_list($table,$params,$where=''){
		$table=$this->table($table);
		$sql='update '.$table.' set ';
		$set='';
		foreach($params as $k => $v){
			if($set){
				$set.=',';
			}
			$set.='`'.$k.'`="'.$v.'"';
		}
		$res=$this->where($where);
		$result = $this->execute($sql.$set.$res);
		return $return;
	}
	function sql_get_count($table,$where='',$group=''){
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$sql="select count(*) as c from ".$table;
		$res=$this->where($where,'',$group);
		$result = $this->execute($sql.$res);
		while( $array = mysql_fetch_assoc( $result ) ){
			 $r[]=$array['c'];
		}
		if(count($r)==1){
			return $r[0];
		}
		return $r;
	}
	function sql_get_max($table,$col,$where='',$group=''){
		$where=$this->add_where($table,$where);
		$table=$this->table($table);
		$sql="select max(".$col.") as c from ".$table;
		$res=$this->where($where,'',$group);
		$result = $this->execute($sql.$res);
		while( $array = mysql_fetch_assoc( $result ) ){
			 $r[]=$array['c'];
		}
		if(count($r)==1){
			return $r[0];
		}
		return $r;
	}
	function sql_get_columns($table){
		$sql='SHOW COLUMNS FROM '.$table;
		$result = $this->execute($sql);
		while( $array = mysql_fetch_assoc( $result ) ){
			 $r[]=$array['Field'];
		}
		return $r;
	}
}
?>