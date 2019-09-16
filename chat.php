<!DOCTYPE html>
<?php session_start();include 'db.php';
if(!isset($_SESSION['online'])){
echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}
?>
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
	<script>
			 $(function(){
					 var wsurl = 'ws://127.0.0.1:9505/websocket/server2.php';
					 var websocket;
					 if(window.WebSocket){
							 websocket = new WebSocket(wsurl);
							 //websocket接建立
							 websocket.onopen = function(evevt){
									 console.log("Connected to WebSocket server.");
							 }
							 //收到消息
							 websocket.onmessage = function(event) {
								 var myself=$("#myself").val();
								 var msg = JSON.parse(event.data);
								 var message = msg.message;
								 var userrecive=msg.userrecive;
								 	var usersend=msg.usersend;
								 var count=msg.count;
								 var img=msg.img;
								 var send_name=msg.send_name;
								 var x=$('#group_count').val();


									 if(message!=null){


													for(var u=1;u<=x;u++){

												if(userrecive==myself||userrecive==$('#group_id'+u).val()){


													if($("#li_"+usersend).size()>0){



												if(userrecive==myself){
														console.log(message);
													$("#"+usersend).text(message);  //最新訊息
													$("#count"+usersend).show();
													$("#count"+usersend).text(count); //讀訊息次數
													}
													$("#music").html('<audio   style="display:none;" defaultMuted autoplay controls ><source src="1404450490.mp3" type="audio/mpeg"></audio>');
													//console.log(count);

													var f=$("#menu").children(); //抓取 Li元素


													for(var i = 0;i < f.length;i++){


															if(f.eq(i).attr("id")==$("#li_"+usersend).attr("id")&&userrecive==myself){  //抓出最新消息 是在li 第幾個位置

    															var j=i;   //在判斷下面的排序要跑幾次  位置 1 跑兩次 因此類推
																	var x=$("#li_"+usersend).html();


																}




															}

														for(var k=j;k>=0;k--){

																	if(k==0){

																		f.eq(k).html(x);
																		f.eq(k).attr("id","li_"+usersend);   //要更換ID 否則第一個迴圈無法判斷

																	}else{

																			f.eq(k).html(f.eq(k-1).html());
                                      f.eq(k).attr("id",f.eq(k-1).attr("id")); //要更換ID 否則第一個迴圈無法判斷


																	}

														}

												}else{ //列表上沒有值時 表示為第一筆的聊天紀錄


														//	$("#menu").append("<li id='li_"+userrecive+"'data-icon='false' class='ui-li-has-count ui-li-has-thumb ui-first-child ui-last-child'><a href='chatroom_group.php?userrecive="+userrecive+"' target='_parent' class='ui-btn'><img src='https://tva4.sinaimg.cn/crop.18.47.190.190.180/542184b2jw8f8wx75o2dtj206o06o3yk.jpg' style='width:80px; height:80px;' /><h1>"+userrecive+"</h1><p id='"+userrecive+"'>"+message+"</p>");

														$("#menu").append("<li id='li_"+usersend+"'data-icon='false' class='ui-li-has-count ui-li-has-thumb ui-first-child ui-last-child'><a href='chatroom.php?userrecive="+usersend+"' target='_parent' class='ui-btn'><img src='"+img+"' style='width:80px; height:80px;' /><h1>"+send_name+"</h1><p id='"+usersend+"'>"+message+"</p><span id='count"+usersend+"'class='ui-li-count' style='background-color:red; color:white; '>"+count+"</span></a></li>");


													$("#music").html('<audio   style="display:none;" defaultMuted autoplay controls ><source src="1404450490.mp3" type="audio/mpeg"></audio>');
													$("#no_record").hide(); //有紀錄了

													var f=$("#menu").children(); //抓取 Li元素

													for(var i = 0;i < f.length;i++){



															if(f.eq(i).attr("id")==$("#li_"+usersend).attr("id")&&userrecive==myself){  //抓出最新消息 是在li 第幾個位置

    															var j=i;   //在判斷下面的排序要跑幾次  位置 1 跑兩次 因此類推
																	var x=$("#li_"+usersend).html();


																}

															}

														for(var k=j;k>=0;k--){

																	if(k==0){

																	f.eq(k).html(x);
																	f.eq(k).attr("id","li_"+usersend);   //要更換ID 否則第一個迴圈無法判斷


																	}else{
																			f.eq(k).html(f.eq(k-1).html());
																			 f.eq(k).attr("id",f.eq(k-1).attr("id")); //要更換ID 否則第一個迴圈無法判斷

																	}

														}

														}

													if($("#li_"+userrecive).size()>0){

														if(userrecive==$('#group_id'+u).val()){ //群組訊息
																$("#"+userrecive).text(message);  //最新訊息
																$("#count"+userrecive).show();
																$("#count"+userrecive).text(count); //讀訊息次數
														}

														$("#music").html('<audio   style="display:none;" defaultMuted autoplay controls ><source src="1404450490.mp3" type="audio/mpeg"></audio>');
														//console.log(count);

														var f=$("#menu").children(); //抓取 Li元素


														for(var i = 0;i < f.length;i++){

															if(f.eq(i).attr("id")==$("#li_"+userrecive).attr("id")){  //抓出最新消息 是在li 第幾個位置

																	var j=i;   //在判斷下面的排序要跑幾次  位置 1 跑兩次 因此類推
																	var y=$("#li_"+userrecive).html();


																}


																}

															for(var k=j;k>=0;k--){

																		if(k==0){


																					f.eq(k).html(y);
																					f.eq(k).attr("id","li_"+userrecive);

																		}else{

																				f.eq(k).html(f.eq(k-1).html());
																				f.eq(k).attr("id",f.eq(k-1).attr("id")); //要更換ID 否則第一個迴圈無法判斷


																		}

															}

													}else{

													}



								 }
							 }

							 }
						 }


							 websocket.onerror = function(event){

							 }

							 websocket.onclose = function(event){
									 console.log('websocket Connection Closed. ');
							 }



					 }
					 else{
							 alert('您的瀏覽器不支援websocket!!');
					 }

			 });
			 </script>

</head>

<body>

	<div data-role="page" id="page1" >

		<div data-role="header" data-theme="f">
				<h2>聊天</h2>
				 <a is="button" class="ui-btn ui-btn-left ui-btn-icon-left ui-icon-bars" href="#left-menu" style="padding:18px; background:none; border:none;"></a>
				 <a is="button" class="ui-btn ui-btn-right ui-btn-icon-right " href="group_select.php"  style=" background:none; border:none;"><i class="fa fa-users"style="font-size:20px"></i></a>

		</div>

			<div id="left-menu" data-role="panel" data-position="left" style="overflow:auto;" ><!--data-position-fixed="false" data-display="overlay" 左邊過來蓋過-->
			<ul data-role="listview">

				<?php

				$sql_group="select * from group_chat where username='{$_SESSION['id']}'";
				$query_group=mysqli_query($link,$sql_group);

				$i=0;
				while($row_group=mysqli_fetch_assoc($query_group)){
					$i++;
					$sql_count="select count(username) as count from group_chat where group_id='{$row_group['group_id']}'";
					$query_count=mysqli_query($link,$sql_count);
					$row_count=mysqli_fetch_assoc($query_count);

					echo "<li data-icon='false'>
								<a href='chatroom_group.php?userrecive={$row_group['group_id']}' target='_parent'>
								<img src='{$row_group['group_img']}' style='width:80px; height:80px; border-radius:50%;'>
								<br>
								<h2>{$row_group['group_name']}({$row_count['count']})</h2>
								</a>
								</li>
								";
								//<div style=' float:right; margin-top:25%; display:inline;background-color:green; width:10px; height:10px; border-radius:50%;'></div>
										echo "<input type='hidden' id='group_id{$i}' value='{$row_group['group_id']}'/>";  //判斷本身 是否能接受該群組訊息


				}
					echo "<input type='hidden' id='group_count' value='{$i}'/>";

					$sql="select * from user";
					$query=mysqli_query($link,$sql);

						while($row=mysqli_fetch_assoc($query)){

								if($row['username']!=$_SESSION['id'])
								{
								echo "<li data-icon='false'>
								      <a href='chatroom.php?userrecive={$row['username']}' target='_parent'>
											<img src='{$row['img']}' style='width:80px; height:80px; border-radius:50%;'>
											<br>
											<h2>{$row['name']}</h2>
											</li>
											</a>
											";
										}
						}

				?>


			 </ul>
			 </div>

		<div data-role="content" style="overflow:auto;">
			<ul id="menu" data-role="listview">
						<?php

								$sql="select * FROM (SELECT * FROM `chatroom` WHERE userrecive='{$_SESSION['id']}' or usersend='{$_SESSION['id']}' or userrecive  in (SELECT group_id FROM group_chat WHERE username='{$_SESSION['id']}') order by chatroom.idchat desc LIMIT 999) as q GROUP BY chat_num ORDER by idchat desc"; //limit 9999解決mysql 子查詢無法排序問題
								$query=mysqli_query($link,$sql);

										while($row=mysqli_fetch_assoc($query)){


											if( $row['group_chat']=='1'){

												$sql2="select group_name,group_img,count(*) as count from group_chat where group_id='{$row['userrecive']}' ";
												$query2=mysqli_query($link,$sql2);
												$row2=mysqli_fetch_assoc($query2);

												$sql_group_count="select count(*) as count from chatroom where userrecive='{$row['userrecive']}' and usersend!='{$_SESSION['id']}' and group_user_read not like '%{$_SESSION['id']}%'";
												$query_group_count=mysqli_query($link,$sql_group_count);
												$row_group_count=mysqli_fetch_assoc($query_group_count);

												if($row_group_count['count']>0){
													echo "<li id='li_{$row['userrecive']}' data-icon='false' >
																<a href='chatroom_group.php?userrecive={$row['userrecive']}' target='_parent'>
																<img src='{$row2['group_img']}' style='width:80px;height:80px;'>
																<h2>{$row2['group_name']} ({$row2['count']})</h2>
																<p id='{$row['userrecive']}'>{$row['message']}</p>
																<span id='count{$row['userrecive']}'class='ui-li-count' style='background-color:red; color:white;'>{$row_group_count['count']}</span>
																</a></li>";
											}else{

												echo "<li id='li_{$row['userrecive']}' data-icon='false' >
															<a href='chatroom_group.php?userrecive={$row['userrecive']}' target='_parent'>
															<img src='{$row2['group_img']}' style='width:80px;height:80px;'>
															<h2>{$row2['group_name']} ({$row2['count']})</h2>
															<p id='{$row['userrecive']}'>{$row['message']}</p>
															<span id='count{$row['userrecive']}'class='ui-li-count' style='background-color:red; color:white; display:none;'></span>
															</a></li>";

												}

											}

                        if($row['usersend']==$_SESSION['id'] && $row['group_chat']=='0'){  // 當傳送者是自己時 私聊


													$sql2="select * from user where username='{$row['userrecive']}'";
													$query2=mysqli_query($link,$sql2);
													$row2=mysqli_fetch_assoc($query2);

													echo "<li id='li_{$row['userrecive']}' data-icon='false' >
																<a href='chatroom.php?userrecive={$row['userrecive']}' target='_parent'>
																<img src='{$row2['img']}' style='width:80px;height:80px;'>
																<h2>{$row2['name']}</h2>
																<p id='{$row['userrecive']}'>{$row['message']}</p>
																<span id='count{$row['userrecive']}'class='ui-li-count' style='background-color:red; color:white; display:none;'></span>
																</a></li>
																	";

												}
											   if($row['userrecive']==$_SESSION['id'] && $row['group_chat']=='0'){   // 當傳送者不是自己時  私聊

												$sql2="select * from user where username='{$row['usersend']}'";
												$query2=mysqli_query($link,$sql2);
												$row2=mysqli_fetch_assoc($query2);

												$sql3="select COUNT(chat_read) FROM `chatroom` where chat_read=0 and usersend='{$row['usersend']}' and userrecive='{$_SESSION['id']}'";
	 											$query3=mysqli_query($link,$sql3);
												$row3=mysqli_fetch_assoc($query3);
												$count=$row3['COUNT(chat_read)'];

												if($count>0){  // 沒即時傳輸時
											 echo "<li id='li_{$row['usersend']}' data-icon='false'>
														<a href='chatroom.php?userrecive={$row['usersend']}' target='_parent'>
														<img src='{$row2['img']}' style='width:80px;height:80px;'>
														<h2>{$row2['name']}</h2>
														<p id='{$row['usersend']}'>{$row['message']}</p>
														<span id='count{$row['usersend']}'class='ui-li-count' style='background-color:red; color:white;'>{$count}</span>
														</a></li>";

											}
												else{  //有即時傳輸時
												echo "<li id='li_{$row['usersend']}'  data-icon='false'>
															<a href='chatroom.php?userrecive={$row['usersend']}' target='_parent'>
															<img src='{$row2['img']}' style='width:80px;height:80px;'>
															<h2>{$row2['name']}</h2>
															<p id='{$row['usersend']}'>{$row['message']}</p>
															<span id='count{$row['usersend']}'class='ui-li-count' style='background-color:red; color:white; display:none;'></span>
															</a></li>	";

														}

											}

							}






			?>



			</ul>
			<?php 				if(mysqli_num_rows($query)==0){
								echo"<h1 id='no_record' style='position: absolute;left:50% ; top:50%;transform: translate(-50%,-50%);'>無聊天紀錄</h1>";
							}?>
				<input id="myself" type="hidden" value="<?php echo $_SESSION['id'];?>" />
				<div id="music">
				</div>


		</div>

		<div data-role="footer" data-position="fixed">

			<div data-role="navbar" >
			<ul>
				<li><a href="message_board.php" target="_parent" data-icon="home">留言板</a></li>
				<li><a href="#page2" target="_parent" data-icon="user">個人</a></li>
				<li><a href="#" data-icon="comment">聊天</a></li>
				<li><a href="logout.php" data-icon="power">登出</a></li>

			</ul>
			</div>

		</div>

	</div>

		<div data-role="page" id="page2" >

		<div data-role="header" data-theme="f">
				<h2>個人資訊</h2>

		</div>

		<div data-role="content" >
			<?php
				$sql="select * from user where username='{$_SESSION['id']}'";
				$query=mysqli_query($link,$sql);
				$row=mysqli_fetch_assoc($query);
			?>

			<a href="#page3" data-rel="dialog"><img src="<?php echo $row['img'];?>" class="custom-img"></img><span style="position:relative; left:50%  ">更換大頭貼</span></a>
			<label for="name">姓名</label>
			<input id="name"type="text" value="<?php echo $row['name'];?>"></input>
			<label for="name">電子郵件</label>
			<input id="email" type="text" value="<?php echo $row['email'];?>"></input>
			<label for="name">密碼</label>
			<input id="password" type="password" value=""></input>
			<label for="name">確認密碼</label>
			<input id="password2" type="password" value=""></input>
			<a href="#" data-role="button" >更改個人資訊</a>


		</div>

		<div data-role="footer" data-position="fixed">

			<div data-role="navbar" >
			<ul>
				<li><a href="message_board.php" data-icon="home" target="_parent">留言板</a></li>
				<li><a href="#" data-icon="user" >個人</a></li>
				<li><a href="#page1" data-icon="comment">聊天</a></li>
				<li><a href="logout.php" data-icon="power">登出</a></li>

			</ul>
			</div>

		</div>

	</div>



	<div data-role="page" id="page3" >

		<div data-role="header" data-theme="f">
				<h2>大頭貼</h2>

		</div>

		<div data-role="content" >

      <label for="fepic">大頭照:</label>
			<input type="file" name="fepic" id="fepic">
			<a href="#page2" data-role="button" >上傳圖片</a>

		</div>

		<div data-role="footer" data-position="fixed">



		</div>

	</div>







</body>
</html>
