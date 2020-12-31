<?php include_once('config.php');
    session_start();
if(@$_SESSION['isadmin']==True){
    die("<script>alert('您已登录，请开始您的操作');window.location.href='./admin.php';</script>");
}
if(!empty($_POST)){
    if($_POST['username']==$admin_user&&$_POST['password']==$admin_pass){
        $_SESSION['isadmin']= True;
        header('location:admin.php');
    } else {
        die("<script>alert('密码错误');history.go(-1)</script>");
    }
} else {
    include_once('header.php');?>
        <form action="" method="post">
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-wrapping">@</span>
                </div>
                <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-wrapping">@</span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="addon-wrapping">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="login" />
        </form>
    </body>
    </html>



<?php }?>