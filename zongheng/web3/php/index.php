<?php include_once('header.php');?>

<?php 
if(isset($_GET['img'])&&file_exists($_GET['img'])){?>
            <img src="<?php echo $_GET['img'];?>" class="d-inline-block align-top" alt="" loading="lazy">
<?php } else {?>
    <img src="<?php echo $config->logo_url;?>" class="d-inline-block align-top" alt="" loading="lazy">
<?php }?>
    <p><?php echo $config->comment;?></p>



<?php echo $footer;?>
