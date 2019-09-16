<!DOCTYPE html>
<html>
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

	<?php
   session_start();
   if(isset($_SESSION['online'])&&$_SESSION['online']){
   echo "<script type='text/javascript'>window.location.href = 'chat.php';</script>";
   }
    ?>
	<div data-role="page" id="page1" data-position="fixed">

		<div data-role="header" data-theme="f">
				<h2>聊天</h2>
		</div>


		<div data-role="content" style="overflow:auto;">
		<img  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSG6D6DWES3hYoRhRlS82u5mJRxJ25ER0bYfX3MqS34IdOKGHCK" class="custom-img"  />
		<form action="check.php" method="post" data-ajax="false"> <!-- jquery mobole 如果不用ajax 要加上false-->
		<label for="user_id">帳號</label>
		<input  name="user_id" type="text" />
		<label for="password" >密碼</label>
		<input  name="password" type="password" />
		<button type="submit"  style="background: #89C7F7; color: white;" >登入</button>
		</form>
		<a href="register.php"  data-role="button"  >尚未註冊</a>
		<a href="#">忘記密碼</a>



		</div>



		<div data-role="footer" data-position="fixed">



		</div>

	</div>








</body>
</html>
