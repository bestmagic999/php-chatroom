<!DOCTYPE html>
<html >
<head>
	<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
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






	<div data-role="page" id="page1">

		<div data-role="header" data-position="fixed" data-theme="f">
			<a href="index.php"><</a>
			<h1>註冊</h1>
		</div>

		<div data-role="content">

			<form action="register_check.php"  method="post"   name="form1" onsubmit="return check();" data-ajax="false"  enctype="multipart/form-data" >

			<lable for="fname">姓名:</lable>
			<input type="text" name="fname" id="fname">
			<lable for="fid">帳號:</lable>
			<input type="text" name="fid" id="fid">
			<lable for="fpassword">密碼:</lable>
			<input type="password" name="fpassword" id="fpassword">
			<lable for="fconfirm">確認密碼:</lable>
			<input type="password" name="fconfirm" id="fconfirm">
			<lable for="femail">電子郵件:</lable>
			<input type="email" name="femail" id="femail">
			<lable for="fepic">大頭照:</lable>
			<input type="file" name="fepic" id="fepic" accept=".jpg, .jpeg, .png">
			<input type="submit" value="註冊" style="background:#b32400; color: white;"  ></input>

			</form>

			<script>
								function check(){

											if(document.forms['form1']['fname'].value==""){
												alert("請輸入姓名!");
												return false;
											}

											if(document.forms['form1']['fid'].value==""){
												alert("請輸入帳號!");
												return false;
											}

											if(document.forms['form1']['fpassword'].value==""){
												 alert('請輸入密碼!');
												 return false;
											}

											if(document.forms['form1']['fconfirm'].value==""){
												 alert('請輸入確認密碼!');
												 return false;
											}
											if(document.forms['form1']['fpassword'].value!=document.forms['form1']['fconfirm'].value){
												 alert('確認密碼有誤!');
												 return false;
											}

											if(document.forms['form1']['femail'].value==""){
												alert('請輸入信箱!');
												return false;
											}

											if(document.forms['form1']['fepic'].value==""){
												alert('請上傳大頭照!');
												return false;
											}

								}

			</script>



		</div>

		<div data-role="footer" data-position="fixed" >


		</div>

	</div>

</body>
</html>
