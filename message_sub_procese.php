<?php session_start();
include 'db.php';
if(!isset($_SESSION['online'])){
echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}




  if($_POST){

    $sql= "insert into message_sub (post_id,sub_name,content) values('{$_POST['post_id']}','{$_SESSION['id']}','{$_POST['message']}')";
    $query=mysqli_query($link,$sql);

    $sql="select img,name from user where username='{$_SESSION['id']}'";
    $query=mysqli_query($link,$sql);
    $row=mysqli_fetch_assoc($query);



    echo "<img src='$row[img]' style='width:50px; height:50px; border-radius:50%; clear:left;float:left; margin-top:10px;'>"
        ."<div style='float:left; margin-left:5px; background-color:#d1d1e0;  margin-top:10px; max-width:200px; border-radius:5px; padding:5px;'>"
        ."<span style='float:left; ' >{$row['name']}</span><br>"
        ."<span style='float:left; word-break: break-all;'>{$_POST['message']}</span>"
        ."</div>";

      mysqli_free_result($query);

  }








?>
