<!DOCTYPE html>
<?php session_start();
include 'db.php';
if(!isset($_SESSION['online'])){
echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}
?>
<html >
<head>
  <meta charset="utf-8" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
  <!-- IE可能不見得有效 -->
  <META HTTP-EQUIV="EXPIRES" CONTENT="0">
  <!-- 設定成馬上就過期 -->
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<title>線上聊天室</title>

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

</head>

<body>

	<div data-role="page" id="page1" data-position="fixed">

		<div data-role="header" data-theme="f">
      	<a is="button" class="ui-btn ui-btn-left ui-btn-icon-left" href="message_board.php" target="_parent" style="background:none; border:none;"><i class="fa fa-mail-reply" style="font-size:20px"></i></a>
				<h2>發表文章</h2>
			<a is="button" class="ui-btn ui-btn-right ui-btn-icon-right " onclick="check()">發文</a>
		</div>


		<div data-role="content" style="overflow:auto;">
      <?php
        $sql="select * from user where username='{$_SESSION['id']}'";
        $query=mysqli_query($link,$sql);
        $row=mysqli_fetch_assoc($query);
      ?>
		<img src="<?php echo $row['img']?>" style="width:50px; height:50px; border-radius:50%; float:left;">
		<span style="float:left; margin-left:10px;" ><?php echo $row['name'];?></span><br>
		<span style="float:left;margin-left:10px;"><?php echo  date("Y/m/d");?></span>
    <form action="#" method="post" name="form1"  data-ajax="false">
		<textarea  type="text" name="message" placeholder="請輸入內容" style="resize:none;"></textarea>

    <label for="file" style="text-align:center; margin-top:12px; background-color:#ffe6f2;  border-radius:12px;"><i class="fa fa-file-photo-o" style="font-size:24px"></i>上傳圖片</label>
		<input type="file" id="file" name="file" style='display:none;' data-role="none" accept=".jpg, .jpeg, .png"></input>
    <input type="hidden" id="img_src" name="img_src"></input>
    <div align="center"><img id="show" style="max-width:300px;" /></div>
    </form>

		</div>

    <script>

    $(document).on("ready", function() {
       /**
        * 圖片上傳
        */
       //上傳圖片的input更動的時候

       $("input[name='file']").on("change", function() {

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


               $("#show").attr("src",data);
               $("#img_src").val(data);


           }).fail(function(data) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(jqXHR.responseText);
           });




       });
      });


	function check(){

        if(document.forms['form1']['message'].value=="" && document.forms['form1']['file'].value==""){
           alert("請輸入內容或上傳圖片!!");
           return false;
        }else{
          document.forms['form1'].submit();
        }

    }
    </script>

      <?php
          if($_POST){

            $message=addslashes(nl2br($_POST['message'])); //nl2br 解決換行問題
            $img=addslashes($_POST['img_src']);
            $sql="insert into message_board (post_user,content,post_img) values('{$_SESSION['id']}','{$message}','{$img}')";
            $query=mysqli_query($link,$sql);
            header("Location:message_board.php");
          }
      ?>






		<div data-role="footer" data-position="fixed">



		</div>

	</div>








</body>
</html>
