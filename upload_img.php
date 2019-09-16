<?php

if(file_exists($_FILES['file']['tmp_name']))
{

list($width,$height)=getimagesize($_FILES['file']['tmp_name']); //抓取圖片長寬
$newfile=imagecreatefromjpeg($_FILES['file']['tmp_name']);

if($width>1024 || $height>1024){  //當長寬大於1024才壓縮
if($width>$height){ //判斷寬

  $new_width=1024;
  $new_height=$new_width/($width/$height); //等比縮小
}else{

  $new_height=1024;
  $new_width=($width/$height)*$new_width; //等比縮小
  }
}
else{
  $new_width=$width;
  $new_height=$height;
}


$truecolor=imagecreatetruecolor($new_width,$new_height); //生成框架
imagecopyresampled($truecolor,$newfile,0,0,0,0,$new_width,$new_height,$width,$height);  //壓縮圖片


  if(file_exists("file/".$_FILES['file']['name'])){   //檔名重複改黨


    $file=explode(".",$_FILES['file']['name']); //類似js split
      $new_name=$file[0]."-".rand(0,1000);

      imagejpeg($truecolor,"file/".iconv("utf-8","big5",$new_name).".".$file[1],80);   //生成圖片
    //  move_uploaded_file($_FILES['file']['tmp_name'],"file/".iconv("utf-8","big5",$new_name).".".$file[1]);
         //$file[1] 副檔名
        echo "file/".$new_name.".".$file[1];
  }
  else
  {
      imagejpeg($truecolor,"file/".iconv("utf-8","big5",$_FILES['file']['name']),80);   //生成圖片
    //move_uploaded_file($_FILES['file']['tmp_name'],"file/" . iconv("utf-8","big5",$_FILES['file']['name']));
    echo "file/".$_FILES['file']['name'];
  }


}
else
{
  echo "暫存檔不存在，上傳失敗";
}






?>
