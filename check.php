<?php
  session_start();
include "db.php";



  $username=preg_replace("/[\'\"]+/" , '' ,strtolower($_POST['user_id']));


  $password = preg_replace("/[\'\"]+/" , '' ,strtolower($_POST['password']));




  $sql="select * from  user where username='{$username}' and password='{$password}'";

  $query=mysqli_query($link,$sql);





    if(mysqli_num_rows($query)==1){
      $_SESSION['online']=true;
      $_SESSION['id']=$username;
      while($row=mysqli_fetch_array($query)){
        $_SESSION['name']=$row['name'];
        $_SESSION['img']=$row['img'];
      }
      header("location:chat.php");

    }else{

      echo '<script>alert("帳號密碼錯誤!!");history.go(-1);</script>';

    }



?>
