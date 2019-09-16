<?php session_start();
include 'db.php';
if(!isset($_SESSION['online'])){
echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}

  if($_POST){

    if($_POST['grat']==0){
    $sql="insert into message_great (post_id,great_user) values('{$_POST['post_id']}','{$_SESSION['id']}')";
     $query=mysqli_query($link,$sql);
     echo 1;
    }

    if($_POST['grat']==1){
      $sql="delete from message_great where post_id='{$_POST['post_id']}' and great_user='{$_SESSION['id']}'";
       $query=mysqli_query($link,$sql);
        echo 0;
    }

  }


?>
