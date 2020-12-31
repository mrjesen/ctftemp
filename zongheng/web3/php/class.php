<?php
include('config.php');
class Config{
    public $title;
    public $comment;
    public $logo_url;
    public function __construct(){
        global $title;
        global $comment;
        global $logo_url;
        $this->title= $title;
        $this->comment = $comment;
        $this->logo_url = $logo_url;
    }
    public function upload_logo(){
        if(!empty($_FILES)){
            $path='./static/'.md5(time()).'.jpg';
            move_uploaded_file($_FILES["file"]["tmp_name"],'./static/'.md5(time()).'.jpg');
        }
    }
    public function update_title($title,$comment){
        #垃圾老板就给我这么点钱，叫我怎么帮你做事。
    }
    
    public function __destruct(){
        $file = file_get_contents(pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname'].'/config.php');
        $file = preg_replace('/\$title=\'.*?\';/', "\$title='$this->title';", $file);
        $file = preg_replace('/\$comment=\'.*?\';/', "\$commnet='$this->comment';", $file);
        file_put_contents(pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname'].'/config.php', $file);
    }
    
}
$config=new Config;
?>