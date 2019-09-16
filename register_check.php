<?php
include 'db.php';


        list($width,$height)=getimagesize($_FILES['fepic']['tmp_name']); //抓取圖片長寬
        $newfile=imagecreatefromjpeg($_FILES['fepic']['tmp_name']);

        if($width>$height){ //判斷寬
          $new_width=1024;
          $new_height=$new_width/($width/$height); //等比縮小
        }else{

          $new_height=1024;
          $new_width=($width/$height)*$new_width; //等比縮小
        }


        $truecolor=imagecreatetruecolor($new_width,$new_height); //生成框架
        imagecopyresampled($truecolor,$newfile,0,0,0,0,$new_width,$new_height,$width,$height);  //壓縮圖片


              $name=$_FILES['fepic']['name'];

              if(file_exists($_FILES['fepic']['tmp_name'])){

                    if(file_exists("file/".$name)){   //如果資料夾有重複檔案

                          $file=explode(".",$name);
                          $new_name=$file[0]."-".rand(0,1000);
                          imagejpeg($truecolor,"file/".iconv("utf-8","big5",$new_name).".".$file[1],50);   //生成圖片

                          $photo="file/".$new_name.".".$file[1];
                    }

                    else{

                          imagejpeg($truecolor,"file/".iconv("utf-8","big5",$name),50);   //生成圖片
                          $photo="file/".$name;
                    }
              }



          $name=$_POST['fname'];
          $username=strtolower($_POST['fid']);
          $password=$_POST['fpassword'];
          $email=$_POST['femail'];

        $sql="select * from user where username='{$username}'";
          $query=mysqli_query($link,$sql);

          $sql="select * from user where username='{$username}'";
            $query=mysqli_query($link,$sql);
            if(mysqli_num_rows($query)==1){
                  echo "<script> alert('已有此帳號!');history.go(-1);</script>";
          }else{

            $sql="insert into user (username,password,name,img,email) values ('{$username}','{$password}','{$name}','{$photo}','{$email}')";
          $query=mysqli_query($link,$sql);
          echo '<script>alert("註冊成功!!");window.location.href="index.php";</script>';

          }





?>
