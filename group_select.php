<!DOCTYPE html>
<?php session_start(); include 'db.php';  ?>
<html>
<head>
<meta charset="utf-8" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<!-- IE可能不見得有效 -->
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<!-- 設定成馬上就過期 -->
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <title>建立群組</title>

  <style>
  	.ui-bar-f
  		{
  			color:white;
  			background-color:#F3A0B0;
  		}
  		.custom-img
  	{

  		  position: relative;
  			left: 50%;
  			width: 100px;
  			height: 100px;
  			transform: translate(-50%, 0%);

  	}
  	.custom-btn{
  		background: #89C7F7;
  		}

  	</style>
    <script>

    	   $(document).on("ready", function() {
            /**
             * 圖片上傳
             */
            //上傳圖片的input更動的時候

            $("input[name='group_img']").on("change", function() {

              //產生 FormData 物件
              var file_data = new FormData();

              //$(this)[0].files[0] 網頁暫存的檔案入靜
          file_data.append("file", $(this)[0].files[0]); //此資料等ajax過去

                      $.ajax({

                 type : 'POST',
                 url : 'upload_img.php',
                 data : file_data,
                 cache : false, //因為只有上傳檔案，所以不要暫存
                 processData : false, //因為只有上傳檔案，所以不要處理表單資訊
                 contentType : false, //送過去的內容，由 FormData 產生了，所以設定false
                 dataType : 'html'

                }).done(function(data) {


                    $("#nice").attr("src",data);
                    $("#img_src").val(data);


                }).fail(function(data) {
                 //失敗的時候
                 alert("有錯誤產生，請看 console log");
                 console.log(jqXHR.responseText);
                });




            });
    		   });
    	</script>
</head>
<body>

  <div data-role="page" id="group" >

		<div data-role="header" data-theme="f">
				<h2>建立群組</h2>
	<a href="#" onclick="document.forms['myform'].submit();" class="ui-btn-right"   >完成</a>
		</div>

		<div data-role="content" >
      <form action="" method="post" name="myform"  data-ajax="false" >
      <label for="group_img"><img src="https://images.clipartlogo.com/files/istock/previews/1051/105183623-camera-icon-stock-vector-illustration-flat-design.jpg" id="nice" class="custom-img" style="border-radius:50%;"></label>
      <input type="file" id="group_img" name="group_img" style="display:none;" data-role="none" accept=".jpg, .jpeg, .png"></input>
      <input type="hidden" id="img_src" name="img_src"></input>
      <input type="text" name="group_name" placeholder="輸入群組名稱..."></input>



<?php
    $sql="select * from user ";
    	$query=mysqli_query($link,$sql);

      	while($row=mysqli_fetch_assoc($query)){

            if($_SESSION['id']==$row['username']){ //自己預設為勾選

              echo "<input data-iconpos='right'
                    name='group_select[]'
                   id='{$row['username']}' style='display:none;'
                   type='checkbox' value='{$row['username']}' checked>
              <label for='{$row['username']}'  style='display:none;'><img src='{$row['img']}' style='width:80px; height:80px; border-radius:50%;' /><b style='position:absolute; top:50%' >{$row['name']}</b></label>
              </input>";
            }else{

          echo "<input data-iconpos='right'
                name='group_select[]'
               id='{$row['username']}'
               type='checkbox' value='{$row['username']}'>
          <label for='{$row['username']}'><img src='{$row['img']}' style='width:80px; height:80px; border-radius:50%;' /><b style='position:absolute; top:50%' >{$row['name']}</b></label>
          </input>";
        }

        }

?>

</form>


<?php

  if($_POST){
    $group_name=$_POST['group_name'];
    $group_select=$_POST['group_select'];
    $group_img=$_POST['img_src'];

      if($group_name==""){
        echo "<script>alert('請輸入群組姓名!!');history.go(-1);</script>";
        return false;
      }

      if(count($group_select)<3){
        echo "<script>alert('最少選擇2名人員!!');history.go(-1);</script>";
          return false;
      }
      if($group_img==""){
          echo "<script>alert('請上傳群組圖片!!');history.go(-1);</script>";
            return false;
      }

      $group_id="";
      $word = 'abcdefghijkmnpqrstuvwxyz0123456789';
      $len = strlen($word); //取得長度
      for($i = 0; $i < 5; $i++){ //總共取 幾次
        $group_id=$group_id.$word[rand() % $len];//隨機取得一個字元 字串相加要用(.)
      }

      foreach ($group_select as  $value) {
        $sql="insert into group_chat (group_id,group_name,username,group_img) values ('{$group_id}','{$group_name}','{$value}','{$group_img}')";
        $query=mysqli_query($link,$sql);

      }
      echo "<script>alert('新增成功!!');window.location='chat.php';</script>";
  }
?>




		</div>

		<div data-role="footer" data-position="fixed">

			<div data-role="navbar" >
			<ul>
        <li><a href="chat.php#page2" data-icon="user">個人</a></li>
        <li><a href="chat.php" data-icon="comment">聊天</a></li>
        <li><a href="logout.php" data-icon="power">登出</a></li>

			</ul>
			</div>

		</div>

	</div>





</body>

</html>
