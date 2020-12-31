<?php
session_start();
include 'class.php';
if (!@$_SESSION['isadmin'] == True) {
	die("<script>alert('请登录');history.go(-1);</script>");
}

if (!isset($_GET['upload']) && !isset($_GET['update'])) {

	include_once 'header.php';?>
    <nav class="navbar navbar-light bg-light">
    <p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#upload" aria-expanded="false" aria-controls="upload">
    上传网站图标
  </button>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#update" aria-expanded="false" aria-controls="update">
    修改网站标题
  </button>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#reset" aria-expanded="false" aria-controls="reset">
    恢复出厂设置
  </button>
  </nav>
</p>
<div id="upload">
  <div class="card card-body">
    <form action="admin.php?upload" method="POST" enctype='multipart/form-data'>
        <input type="file" name='file' value='abs'>
        <input type="submit" class="btn btn-primary" value='上传'>
    </form>
  </div>
</div>
<div id="update">
  <div class="card card-body">
  垃圾老板就给我这么点钱，叫我怎么帮你做事。
    <form action="admin.php?update" method="post">
        <input type="text" name="lalal" placeholder='请输入网站标题' class='form-control'>
        <input type="submit" class='btn btn-primary'>
    </form>
  </div>
</div>
<div class="collapse" id="reset">
  <div class="card card-body">
    删库跑路的艺术就是想删就删，想恢复就恢复。
    <a id="resetbtn" class="btn btn-primary">点我重置</a>
  </div>
</div>

    <script>
    $("#resetbtn").click(function(){
        xhr = new XMLHttpRequest();
xhr.open('GET', './reset.php', true);
xhr.send();
location.reload();
});</script>

<?php } else if (isset($_GET['upload'])) {
	$config->upload_logo();
} else if (isset($_GET['update'])) {
	die('<script>alert(垃圾老板就给我这么点钱，叫我怎么帮你做事./);history.go(-1)</script>');
}
echo $footer;
?>