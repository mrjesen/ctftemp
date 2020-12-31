<?php
defined('IN_YZMPHP') or exit('Access Denied'); 
yzm_base::load_controller('common', 'admin', 0);
yzm_base::load_common('lib/content_form'.EXT, 'admin');
yzm_base::load_sys_class('page','',0);

class content extends common {
	
	private $content;
	public function __construct() {
		parent::__construct();
		$this->content = M('content_model');
	}

	/**
	 * 内容列表
	 */
	public function init() {
		$of = input('get.of');
		$or = input('get.or');
		$of = in_array($of, array('id','catid','click','username','updatetime','status','is_push')) ? $of : 'id';
		$or = in_array($or, array('ASC','DESC')) ? $or : 'DESC';
		$modelinfo = $this->content->modelarr;
		$content_db = D('article'); //默认加载文章列表
		$modelid = 1; //默认加载文章模型
		$catid = 0; //默认加载全部分类
		$where = $_SESSION['roleid']==1 ? array() : array('userid'=>$_SESSION['adminid']);
		$total = $content_db->where($where)->total();
		$page = new page($total, 15);
		$data = $content_db->where($where)->order("$of $or")->limit($page->limit())->select();	
		include $this->admin_tpl('content_list');
	}


	/**
	 * 内容搜索
	 */
	public function search() {
		$of = input('get.of');
		$or = input('get.or');
		$of = in_array($of, array('id','catid','click','username','updatetime','status','is_push')) ? $of : 'id';
		$or = in_array($or, array('ASC','DESC')) ? $or : 'DESC';
		$modelinfo = $this->content->modelarr;
		$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 1;
		$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
		$content_db = D($this->content->tabname);
		$where = $_SESSION['roleid']==1 ? '1=1' : 'userid='.$_SESSION['adminid'];
		if(isset($_GET['dosubmit'])){	
		
			$searinfo = isset($_GET['searinfo']) ? safe_replace(trim($_GET['searinfo'])) : '';
			$type = isset($_GET["type"]) ? $_GET["type"] : 1;

			if($searinfo != ''){
				if($type == '1')
					$where .= ' AND title LIKE \'%'.$searinfo.'%\'';
				else
					$where .= ' AND username LIKE \'%'.$searinfo.'%\'';
			}

			if($catid != '0'){
				$where .= ' AND catid='.$catid;
			}

			if(isset($_GET["start"]) && $_GET["start"] != '' && $_GET["end"]){		
				$where .= ' AND updatetime BETWEEN '.strtotime($_GET["start"]).' AND '.strtotime($_GET["end"]);
			}

			if(isset($_GET["flag"]) && $_GET["flag"] != '0'){
				$where .= ' AND FIND_IN_SET('.intval($_GET["flag"]).',flag)';
			}

			if(isset($_GET["status"]) && $_GET["status"] != '99'){
				$where .= ' AND status = '.intval($_GET["status"]);
			}	
			
		}
		$_GET = array_map('htmlspecialchars', $_GET);
		$total = $content_db->where($where)->total();
		$page = new page($total, 15);
		$data = $content_db->where($where)->order("$of $or")->limit($page->limit())->select();		
		include $this->admin_tpl('content_list');
	}
	
	
	/**
	 * 添加内容
	 */
	public function add() {

		if(isset($_POST['dosubmit'])) {
			$r = $this->content->content_add($_POST);
			if($r){
				echo '<script type="text/javascript">parent.location.reload();</script>';
			}else{
				showmsg(L('data_not_modified'));
			}
		}else{
			$catid = isset($_GET['catid']) ? intval($_GET['catid']) : intval(get_cookie('catid'));
			$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
			$content_form = new content_form($modelid);
			$string = $content_form->content_add();
			$member_group = get_groupinfo();
			include $this->admin_tpl('content_add');
		}
	}
	
	
	/**
	 * 修改内容
	 */
	public function edit() {
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$content_db = D($this->content->tabname);
		$data = $content_db->where(array('id'=>$id))->find();
		if($_SESSION['roleid']>1 && $data['userid']!==$_SESSION['adminid']){
			showmsg(L('illegal_operation'), 'stop');
		}
		if(isset($_POST['dosubmit'])) {
			$r = $this->content->content_edit($_POST, $id);
			if($r){
				echo '<script type="text/javascript">parent.location.reload();</script>';
			}else{
				showmsg(L('data_not_modified'));
			}
		}else{
			$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 1;
			$tags = D('tag_content')->alias('a')->field('tag')->join('yzmcms_tag b ON a.tagid=b.id', 'LEFT')->where(array('modelid'=>$modelid, 'aid'=> $id))->order('id ASC')->select();
			$content_form = new content_form($_GET['modelid']);
			$string = $content_form->content_edit($data);
			$member_group = get_groupinfo();
			include $this->admin_tpl('content_edit');	
		}
	}
	
	
	/**
	 * 删除内容
	 */
	public function del() {
		if($_POST && is_array($_POST['ids'])){
			foreach($_POST['ids'] as $id){
				if($_SESSION['roleid'] > 1){
					$userid = D($this->content->tabname)->field('userid')->where(array('id'=>$id))->one();
					if($userid!==$_SESSION['adminid']) continue;
				}
				$this->content->content_delete($id); 
			}
		}
		showmsg(L('operation_success'),'',1);
	}


	/**
	 * 数据快速修改
	 */
	public function public_fast_edit(){
		$id = input('post.pk', 0, 'intval');
		$value = input('post.value', 0, 'intval');
		if(!$id) return_json(array('status'=>0, 'message'=>L('illegal_parameters')));	
		$db = D($this->content->tabname);
		$db->update(array('click'=>$value), array('id'=>$id));
		return_json(array('status'=>1, 'message'=>L('operation_success')));	
	}


	/**
	 * 百度主动推送
	 */
	public function baidu_push() {
		if($_POST && is_array($_POST['ids'])){
			$ids_arr = array_map('intval', $_POST['ids']);
			if(empty($ids_arr)) showmsg(L('lose_parameters'), 'stop');
			$ids = join(',', $ids_arr);
			$content = D($this->content->tabname);
			$data = $content->field('url,is_push')->where('id IN ('.$ids.')')->select();
			$urls = array();
			foreach ($data as $value) {
				if($value['is_push']) continue;
				$urls[] = strpos($value['url'], '://') ? $value['url'] : SERVER_PORT.HTTP_HOST.$value['url'];
			}
			if(!empty($urls)){
				$baidu_push_token = get_config('baidu_push_token');
				if(!$baidu_push_token) showmsg('token值为空，请到系统设置中配置！', 'stop');
				$api_url = 'http://data.zz.baidu.com/urls?site='.HTTP_HOST.'&token='.$baidu_push_token;
				$ch = curl_init();
				$options =  array(
				    CURLOPT_URL => $api_url,
				    CURLOPT_POST => true,
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_POSTFIELDS => implode("\n", $urls),
				    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
				);
				curl_setopt_array($ch, $options);
				$result = curl_exec($ch);
				curl_close($ch);
				$result = json_decode($result, true);
				if(isset($result['success'])){
					$content->update(array('is_push' => 1), 'id IN ('.$ids.')');
					showmsg('成功推送'.$result['success'].'条URL地址！', '', 2);
				}else{
					showmsg('推送失败，错误码：'.$result['error'], 'stop');
				}
			}

			showmsg('没有数据被推送！');
		}
	}

	
	
	/**
	 * 移动分类
	 */
	public function remove() {
		if(isset($_POST['dosubmit'])) {
			$ids = safe_replace($_POST['ids']);
			$ids_arr = explode(',', $ids);
			$catid = intval($_POST['catid']);
			$db = D($this->content->tabname);
			foreach ($ids_arr as $id) {
				$url = get_content_url($catid, $id);
				$db->update(array('catid' => $catid, 'url' => $url), array('id'=>$id));
				D('all_content')->update(array('catid' => $catid, 'url' => $url), array('modelid'=>$this->content->modelid, 'id'=>$id));
			}
			return_json(array('status' => 1, 'message' => '操作成功'));
		}else{
			$flag = false;
			$modelid = $this->content->modelid;
			include $this->admin_tpl('content_remove');	
		}
	}



	/**
	 * 复制内容
	 */
	public function copy() {
		if(isset($_POST['dosubmit'])) {
			$ids = safe_replace($_POST['ids']);
			$ids_arr = array_reverse(explode(',', $ids));
			$catid = intval($_POST['catid']);
			$target_modelid = get_category($catid, 'modelid');
			if(!$target_modelid) return_json(array('status' => 0, 'message' => '模型错误，请检查！'));
			$db = D($this->content->tabname);
			$target_db = D(get_model($target_modelid));
			$all_content = D('all_content');
			foreach ($ids_arr as $id) {
				$id = intval($id);
				$res = $db->where(array('id' => $id))->find();
				if(!$res) continue;
				$res['catid'] = $catid;
				$res['is_push'] = 0;
				$target_id = $target_db->insert($res);
				if(!strstr($res['flag'], '7')){
					$target_db->update(array('url' => get_content_url($catid, $target_id)), array('id' => $target_id));
					$res['url'] = get_content_url($catid, $target_id);
				}
				$res['modelid'] = $target_modelid;
				$res['id'] = $target_id;
				$all_content->insert($res);
			}
			return_json(array('status' => 1, 'message' => '操作成功'));
		}else{
			$flag = true;
			$modelid = $this->content->modelid;
			include $this->admin_tpl('content_remove');	
		}
	}
	

	/**
	 * 增加/删除 内容属性
	 */
	public function attribute_operation(){
		if(isset($_POST['dosubmit'])) {
			$op = isset($_POST['op']) ? intval($_POST['op']) : 1;
			$ids = safe_replace($_POST['ids']);
			$ids_arr = explode(',', $ids);
			$ids_arr = array_map('intval', $ids_arr);
			$flag = isset($_POST['flag']) && is_array($_POST['flag']) ? $_POST['flag'] : array();
			if(!$flag) return_json(array('status' => 0, 'message' => '请勾选信息！'));

			$db = D($this->content->tabname);
			foreach($ids_arr as $id){
				$data_flag = $db->field('flag')->where(array('id' => $id))->one();
				if($op){
					$new_flag = $data_flag ? array_unique(array_merge(explode(',', $data_flag), $flag)) : $flag;
				}else{
					$new_flag = $data_flag ? array_diff(explode(',', $data_flag), $flag) : array();
				}
				sort($new_flag);

				$where['listorder'] = array_search(1, $new_flag)!==false ? 1 : 10;
				$where['flag'] = join(',', $new_flag);

				$db->update($where, array('id' => $id));
			}
			return_json(array('status' => 1, 'message' => '操作成功'));
			
		}else{
			$modelid = $this->content->modelid;
			$op = isset($_GET['op']) ? intval($_GET['op']) : 1;
			include $this->admin_tpl('attribute_operation');	
		}
	}
	

}