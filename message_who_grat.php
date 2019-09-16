<?php
session_start();
include 'db.php';
if(!isset($_SESSION['online'])){
echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}

  if($_POST){
    $id=$_POST['id'];
    $sql="select user.name,user.img  from  message_great,user where  message_great.post_id='{$id}' and  message_great.great_user=user.username";
    $query=mysqli_query($link,$sql);


      while($row=mysqli_fetch_assoc($query)) {

          echo "<div style=' display: flex;'>"
              ."<div style='display:inline; position: relative;'>"
              ."<img src='{$row['img']}' style='width:50px; height:50px; border-radius:50%;'>"
              ."<i style='position:absolute; bottom:0; right:0; color:blue;' class='fa fa-thumbs-o-up'></i>"
              ."</div>"
              ."<div style='display:inline-block;  padding-left: 10px;  padding-top: 20px;'>{$row['name']}</div>"
              ."</div>";

    }


    mysqli_free_result($query);
  }


?>
