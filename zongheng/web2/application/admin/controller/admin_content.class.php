<?php
defined('IN_YZMPHP') or exit('Access Denied'); 
yzm_base::load_controller('common', 'admin', 0);

class admin_content extends common {

	/**
	 * 投稿管理
	 */
	public function init() {
		$of = input('get.of');
		$or = input('get.or');
		$of = in_array($of, array('id','catid','username','updatetime','status','userid')) ? $of : 'updatetime';
		$or = in_array($or, array('ASC','DESC')) ? $or : 'DESC';
		yzm_base::load_sys_class('page','',0);
		$all_content = D('all_content');
		$total = $all_content->where(array('issystem'=>0))->total();
		$page = new page($total, 15);
		$data = $all_content->where(array('issystem'=>0))->order("$of $or")->limit($page->limit())->select();		
		include $this->admin_tpl('member_publish_list');
	}


	/**
	 * 稿件浏览
	 */
	public function public_preview() {
		$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(!$catid || !$id) showmsg('参数错误！','stop');
		
		$category = get_category($catid);
		if(!$category) showmsg('内容不存在！','stop');
		$modelid = $category['modelid'];
		$template = $category['show_template'];
		
		$modelinfo = get_modelinfo();
        $modelarr = array();
		foreach($modelinfo as $val){
			$modelarr[$val['modelid']] = $val['tablename'];
		}
		
		if(!isset($modelarr[$modelid]))  showmsg(L('model_not_existent'),'stop');
		$db = D($modelarr[$modelid]);
		$data = $db->where(array('id'=>$id))->find();
		extract($data);
		
		//SEO相关设置
		$site = get_config();
		
		//获取相同分类的上一篇/下一篇内容	
		$pre = $db->field('title,url')->where(array('id<'=>$id , 'status'=>'1' , 'catid'=>$catid))->order('id DESC')->find();
		$next = $db->field('title,url')->where(array('id>'=>$id , 'status'=>'1', 'catid'=>$catid))->order('id ASC')->find();
		$pre = $pre ? '<a href="'.$pre['url'].'">'.$pre['title'].'</a>' : '已经是第一篇';
		$next = $next ? '<a href="'.$next['url'].'">'.$next['title'].'</a>' : '已经是最后一篇';
		
		include template('index', $template);
	}
	
	
	/**
	 * 稿件删除
	 */
	public function del() {
		if($_POST && is_array($_POST['ids'])){	
			$all_content = D('all_content');
			foreach($_POST['ids'] as $val){
				$res = $all_content->field('modelid,id')->where(array('allid' => $val))->find(); 
				if(!$res) continue;
				$all_content->delete(array('allid' => $val)); 
				$content_tabname = D(get_model($res['modelid']));
				$content_tabname->delete(array('id' => $res['id']));
			}
			showmsg(L('operation_success'));			
		}
	}
	
	
	/**
	 * 通过审核
	 */
	public function adopt() {
		if($_POST && is_array($_POST['ids'])){	
			$all_content = D('all_content');
			$member = D('member');
			$pay = D('pay');
			$ip = getip();
			$publish_point = get_config('publish_point');
			
			foreach($_POST['ids'] as $val){
				$data = $all_content->field('modelid,catid,id,userid,username,status')->where(array('allid' => $val))->find();
				if($data['status'] == 1) continue;

				$modelid = $data['modelid'];
				$catid = $data['catid'];
				$id = $data['id'];
				
				$updatearr['status'] = '1';
				$updatearr['url'] = get_content_url($catid, $id);
				$content_tabname = D(get_model($modelid));
				$content_tabname->update($updatearr, array('id' => $id));
				$all_content->update($updatearr, array('allid' => $val));
				
				//投稿奖励积分和经验
				if($publish_point > 0){
					$member->update('`point`=`point`+'.$publish_point.',`experience`=`experience`+'.$publish_point, array('userid' => $data['userid']));  
					$pay->insert(array('trade_sn'=>create_tradenum(), 'userid'=>$data['userid'], 'username'=>$data['username'], 'money'=>$publish_point, 'creat_time'=>SYS_TIME, 'msg'=>'投稿奖励','remarks'=>$catid.'_'.$id, 'type'=>'1', 'status'=>'1', 'ip'=>$ip));		
				}
			}
			showmsg(L('operation_success'));			
		}
	}
	
	
	/**
	 * 退稿
	 */
	public function rejection() {
		if($_POST && is_array($_POST['ids'])){
			
			$data = array();
			$data['send_from'] = '系统';
			$data['issystem'] = '1';
			$data['message_time'] = SYS_TIME;
			$data['subject'] = '您的稿件被退回，请修改后重新提交';

			if($_POST['content_c']=='请输入退稿理由，退稿理由将会以短消息方式发送！'){
				$data['content_c'] = '';
			}else{
				$data['content_c'] = strip_tags($_POST['content_c']);
			}

			$message = D('message');
			$all_content = D('all_content');
			foreach($_POST['ids'] as $val){
				$r = $all_content->field('modelid,catid,id,title,username')->where(array('allid' => $val))->find();
				if(!$r) showmsg('内容不存在！', 'stop');
				$all_content->update(array('status' => '2'), array('allid' => $val)); 
				$data['send_to'] = $r['username'];  //收件人
				$data['content'] = '您发送的投稿不满足我们的要求，请重新编辑投稿！<br>标题：'.$r['title'].'<br><a href="'.U('member/member_content/edit_through',array('catid'=>$r['catid'], 'id'=>$r['id'])).'" style="color:red">点击这里修改</a><br>'.$data['content_c'];
				$message->insert($data);
			}
			showmsg(L('operation_success'));			
		}
	}
	
}