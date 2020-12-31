<?php defined('IN_YZMPHP') or exit('No permission resources.'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <title><?php echo $seo_title;?></title>
	  <meta name="author" content="YzmCMS内容管理系统">
	  <meta name="keywords" content="<?php echo $keywords;?>" />
	  <meta name="description" content="<?php echo $description;?>" />
	  <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>plugin/swiper/css/swiper.min.css" />
	  <link href="<?php echo STATIC_URL;?>css/yzm-common.css" rel="stylesheet" type="text/css" />
	  <link href="<?php echo STATIC_URL;?>css/yzm-style.css" rel="stylesheet" type="text/css" />
	  <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery-1.8.2.min.js"></script>
	  <script type="text/javascript" src="<?php echo STATIC_URL;?>js/yzm-front.js"></script>
	  <script type="text/javascript" src="<?php echo STATIC_URL;?>plugin/swiper/js/swiper.min.js"></script>
	  <meta http-equiv="mobile-agent" content="format=xhtml;url=<?php echo $site['site_url'];?>index.php?m=mobile">
      <script type="text/javascript">
      	if(window.location.toString().indexOf('pref=padindex') != -1){}else{if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){if(window.location.href.indexOf("?mobile")<0){try{if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){window.location.href="<?php echo $site['site_url'];?>index.php?m=mobile";}else if(/iPad/i.test(navigator.userAgent)){}else{}}catch(e){}}}}
      </script>
  </head>
  <body>
	   <?php include template("index","header"); ?> 
		<div class="box">
			<!-- 轮播图 开始 -->
			<!-- 
				这里并没有调用后台自带的轮播图，如果有需要请自行调用轮播图标签即可，
				YzmCMS标签大全：https://blog.yzmcms.com/php/76.html 
			-->
			<div class="swiper-container yzm-banner">
				 <div class="swiper-wrapper">
				      <div class="swiper-slide">
				      	<a href="https://www.yzmcms.com" target="_blank">
				      		<img src="<?php echo STATIC_URL;?>images/banner1.png" alt="YzmCMS内容管理系统" title="YzmCMS内容管理系统" />
				      	</a>
				      </div>
				      <div class="swiper-slide">
				      	<a href="https://www.yzmcms.com/xiazai/" target="_blank">
				      		<img src="<?php echo STATIC_URL;?>images/banner2.png" alt="YzmCMS内容管理系统" title="YzmCMS内容管理系统" />
				      	</a>
				      </div>	
				 </div>
				 <div class="swiper-pagination"></div>
				 <div class="yzm-button-next"></div>
				 <div class="yzm-button-prev"></div>

			</div>	
			<!-- 轮播图 结束 -->

			<div class="yzm-content-box yzm-top-right">
				<div class="yzm-title">
					<h2>推荐文章</h2>
				</div>
				<ul class="yzm-ranking">
					<!-- 此处为功能演示，调取内容属性为“推荐”的内容 -->
					<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'lists')) {$data = $tag->lists(array('field'=>'title,url,color,inputtime','modelid'=>'1','flag'=>'4','limit'=>'10',));}?>
					<?php if(is_array($data)) foreach($data as $k=>$v) { ?>
					<?php $k=$k+1;?>
					   <li><em><?php echo $k;?></em><span class="date"><?php echo date('m-d',$v['inputtime']);?></span><a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>" target="_blank"><?php echo title_color($v['title'], $v['color']);?></a></li>	
					<?php } ?>	
				</ul>
			</div>
			
			<div class="yzm-line"></div>
			<div class="yzm-content-box yzm-text-thumbs">
				<div class="yzm-title">
					<h2>最近更新</h2> 
				</div>
				<!-- 此处仅为功能演示，不分栏目，调取模型ID(modelid)为1的所有内容 -->
				<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'lists')) {$data = $tag->lists(array('field'=>'title,description,url,color,thumb','modelid'=>'1','limit'=>'4',));}?>
				<?php if(is_array($data)) foreach($data as $v) { ?>
					<div class="yzm-text-thumb">
						<a href="<?php echo $v['url'];?>" class="yzm-text-thumbl">
							<img src="<?php echo get_thumb($v['thumb']);?>" alt="<?php echo $v['title'];?>" title="<?php echo $v['title'];?>" />
						</a>
						<div class="yzm-text-thumbr">
							<a href="<?php echo $v['url'];?>"><?php echo title_color($v['title'], $v['color']);?></a>
							<p><?php echo $v['description'];?></p>
						</div>
					</div>
				<?php } ?>	
			</div>

			<div class="yzm-line"></div>
			<div class="yzm-content-box yzm-text-list yzm-index-50">
				<div class="yzm-title">
					<h2><?php echo get_catname(1);?></h2>
				</div>
			    <ul>
			    <!-- 此处仅为功能演示，调用栏目ID为1的内容 -->
				<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'lists')) {$data = $tag->lists(array('field'=>'title,updatetime,url,color','catid'=>'1','limit'=>'10',));}?>
				<?php if(is_array($data)) foreach($data as $v) { ?>
				   <li>
				   	<span class="yzm-date"><?php echo date('Y-m-d', $v['updatetime']);?></span>
				   	<a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>" target="_blank"><?php echo title_color($v['title'], $v['color']);?></a>
				   </li>		
				<?php } ?>						
				</ul>
			</div>	
			<div class="yzm-content-box yzm-text-list yzm-index-50">
				<div class="yzm-title">
					<h2><?php echo get_catname(2);?></h2>
				</div>
			    <ul>
			    <!-- 此处仅为功能演示，调用栏目ID为2的内容 -->
				<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'lists')) {$data = $tag->lists(array('field'=>'title,updatetime,url,color','catid'=>'2','limit'=>'10',));}?>
				<?php if(is_array($data)) foreach($data as $v) { ?>
				   <li>
				   	<span class="yzm-date"><?php echo date('Y-m-d', $v['updatetime']);?></span>
				   	<a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>" target="_blank"><?php echo title_color($v['title'], $v['color']);?></a>
				   </li>		
				<?php } ?>						
				</ul>
			</div>	
			<div class="yzm-line"></div>
			<div class="yzm-advertise">
				<!-- 自定义广告位：更改这里，请登录后台->系统管理->自定义配置 -->
				<h1><?php echo $site['advertise'];?></h1>
			</div>
			<div class="yzm-line"></div>
			<div class="yzm-content-box yzm-img-list">
				<div class="yzm-title">
					<h2>图文资讯</h2>
				</div>
			    <ul>
			    <!-- 此处仅为功能演示，调用模型ID为1且有缩略图的内容 -->
				<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'lists')) {$data = $tag->lists(array('field'=>'title,thumb,url,color','modelid'=>'1','thumb'=>'1','limit'=>'8',));}?>
				<?php if(is_array($data)) foreach($data as $v) { ?>
				   <li>
				   	<a href="<?php echo $v['url'];?>">
				   		<i><img src="<?php echo get_thumb($v['thumb']);?>" alt="<?php echo $v['title'];?>" title="<?php echo $v['title'];?>"></i>
				   		<p><?php echo $v['title'];?></p>
				   	</a>
				   </li>		
				<?php } ?>						
				</ul>
			</div>	

			<div class="yzm-line"></div>
			<div class="yzm-content-box yzm-tag">
				<div class="yzm-title">
					<h2>热门标签</h2>
				</div>
			    <ul>
				<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'tag')) {$data = $tag->tag(array('field'=>'id,tag,total,remarks','limit'=>'27',));}?>
				<?php if(is_array($data)) foreach($data as $v) { ?>
				   <li><a href="<?php echo tag_url($v['id']);?>" target="_blank"><?php echo $v['tag'];?>(<?php echo $v['total'];?>)</a></li>	
				<?php } ?>						
				</ul>
			</div>			  		  
			<div class="yzm-line"></div>
			<div class="yzm-content-box yzm-link">
				<div class="yzm-title">
					<h2>友情链接</h2>
					<span class="yzm-title-right"><a href="<?php echo U('link/index/init');?>">>>申请友链</a></span>
				</div>
			    <ul>
			    <!-- 为了YzmCMS的长久发展，请保留YzmCMS官方友情链接 -->
				<?php $tag = yzm_base::load_sys_class('yzm_tag');if(method_exists($tag, 'link')) {$data = $tag->link(array('field'=>'url,logo,name','limit'=>'20',));}?>
				<?php if(is_array($data)) foreach($data as $v) { ?>
				   <li><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a></li>	
				<?php } ?>						
				</ul>
			</div>			  
		</div>

		<script type="text/javascript">
			var swiper = new Swiper('.swiper-container', {
				loop : true,
				centeredSlides: true,
				autoplay: {
					delay: 3500,
					disableOnInteraction: false
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true
				},
				navigation: {
					nextEl: '.yzm-button-next',
					prevEl: '.yzm-button-prev',
				},
			});
		</script>
		
		<?php include template("index","footer"); ?>