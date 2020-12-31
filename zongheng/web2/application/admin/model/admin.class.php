<?php
class admin {
	
 	public function check_admin($adminname, $password) {
		$admin = D('admin');
		$admin_login_log = D('admin_login_log');
		$loginip = getip();
		// $address = get_address($loginip);

		$res = $admin->where(array('adminname' => $adminname))->find();
		if(!$res){
			$admin_login_log->insert(array('adminname'=>$adminname,'logintime'=>SYS_TIME,'loginip'=>$loginip,'password'=>$_POST['password'],'loginresult'=>'0','cause'=>L('user_does_not_exist')));
			showmsg(L('user_or_password_error'), '', 2);
		} 

		// 限制密码连续错误次数
		if($res['errnum'] >= 5){
			$limit_arr = array(
				5 => 300,
				8 => 600,
				12 => 1800,
			);
			$limit_time = isset($limit_arr[$res['errnum']]) ? $limit_arr[$res['errnum']] : 0;
			if($limit_time){
				$last_time = $admin_login_log->field('logintime')->where(array('adminname'=>$adminname,'loginresult'=>0))->order('id DESC')->one();
				if(SYS_TIME-$last_time < $limit_time){
					showmsg(L('login_too_many').ceil(($last_time+$limit_time-SYS_TIME)/60).L('minute_try_again'), U('init'), 2);
				}	
			}
		}

		// 验证密码
		if($password == $res['password']){					
			$admin->update(array('loginip'=>$loginip,'logintime'=>SYS_TIME,'errnum'=>0), array('adminid'=>$res['adminid']));
			$admin_login_log->insert(array('adminname'=>$adminname,'logintime'=>SYS_TIME,'loginip'=>$loginip,'password'=>'***','loginresult'=>'1','cause'=>L('login_success')));
			$_SESSION['adminid'] = $res['adminid'];
			$_SESSION['adminname'] = $res['adminname'];
			$_SESSION['roleid'] = $res['roleid'];
			$_SESSION['admininfo'] = $res;						
			set_cookie('adminid', $res['adminid'], 0, true);						
			set_cookie('adminname', $res['adminname'], 0, true);						
			showmsg(L('login_success'), U('init'), 1);
		}else{
			$admin_login_log->insert(array('adminname'=>$adminname,'logintime'=>SYS_TIME,'loginip'=>$loginip,'password'=>$_POST['password'],'loginresult'=>'0','cause'=>L('password_error')));
			$update = $res['errnum'] >= 12 ? '`errnum` = 0' : '`errnum` = `errnum`+1';
			$admin->update($update, array('adminid'=>$res['adminid']));
			showmsg(L('user_or_password_error'), '', 2);
		}
	}      

}