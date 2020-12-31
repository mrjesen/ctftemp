<?php defined('IN_YZMPHP') or exit('No permission resources.'); ?><!--网站头部-->
<div class="yzm-header-box">
	<div class="yzm-header-top">
		<div class="yzm-member-status">
		<?php if(intval(get_cookie('_userid'))==0) { ?>
		<a href="<?php echo U('member/index/register');?>" target="_blank">注册</a> 
		<a href="<?php echo url_referer(get_url());?>"  target="_blank" class="login">登录</a>
		<?php } else { ?>
		你好：<?php echo safe_replace(get_cookie('_username'));?>，<a href="<?php echo U('member/index/init');?>">会员中心</a> <a href="<?php echo U('member/index/logout');?>">退出</a>
		<?php } ?>
		</div>
		<div class="topleft">
			轻量级开源内容管理系统：<a href="https://www.yzmcms.com" target="_blank">YzmCMS官方网站</a>
		</div>
	</div>
</div>
<div class="yzm-container-box">
	<div class="yzm-header">
		<div class="yzm-logo">
		 <a href="<?php echo SITE_URL;?>">YzmCMS内容管理系统</a>
		 <!-- <a href="<?php echo SITE_URL;?>"><img src="<?php echo STATIC_URL;?>images/logo.png" title="<?php echo $site['site_name'];?>" alt="<?php echo $site['site_name'];?>"></a> -->
		</div>
		<div class="yzm-search">
		<form method="get" action="<?php echo U('search/index/init');?>" target="_blank">
			<div id="searchtxt" class="searchtxt">
				<div class="searchmenu">	
					<div class="searchselected" id="searchselected">全站</div>	
					<div class="searchtab" id="searchtab">
						<ul>
							<li data="0">全站</li>
							<li data="1">文章</li>
							<li data="2">产品</li>
							<li data="3">下载</li>
						</ul>
					</div>
				</div>
				<input type="hidden" name="modelid" value="0" id="modelid" />
				<input name="q" type="text" placeholder="输入关键字"/>
			</div>
			<div class="searchbtn">
				<button id="searchbtn" type="submit">搜索</button>
			</div>
		</form>
	    </div>
		<div class="yzm-add-content"><a href="<?php echo U('member/member_content/init');?>" target="_blank">发布内容</a></div>
	</div>

	<!--网站导航-->
	<div class="yzm-menu">
	  <ul class="yzm-nav">
		 <li><a <?php if(!isset($catid)) { ?> class="current" <?php } ?> href="<?php echo SITE_URL;?>">首页</a></li>
		<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'nav')) {$data = $tag->nav(array('field'=>'catid,catname,arrchildid,pclink,target','where'=>"parentid=0",'limit'=>'20',));}?>
		<?php if(is_array($data)) foreach($data as $v) { ?>
		    <li>
				<a <?php if(isset($catid) && $v['catid']==$catid) { ?> class="current" <?php } ?> href="<?php echo $v['pclink'];?>" target="<?php echo $v['target'];?>"><?php echo $v['catname'];?></a>
				<!-- 这里是二级栏目的循环，不需要的可以删除，代码开始 -->
				<?php if($v['arrchildid']!=$v['catid']) { ?> 
				<?php $r = get_childcat($v['catid']);?>
				<ul class="sub_nav">
					<?php if(is_array($r)) foreach($r as $v) { ?>
					<li><a href="<?php echo $v['pclink'];?>"><?php echo $v['catname'];?></a></li>
					<?php } ?>	
				</ul>
				<?php } ?>
				<!-- 这里是二级栏目的循环，不需要的可以删除，代码结束 -->
			</li>		
		<?php } ?>	
	  </ul>
	</div>
</div>

<!--网站容器-->
<div class="yzm-container">