<!DOCTYPE html>
<?php session_start(); include 'db.php';
 if(!isset($_SESSION['online'])){
 echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
 }

?>
<html>
<head>
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

  .message{
    transform: translate(3%, 0%);
    width: 85%;
  }
</style>


	<script>

	function acc()
{
$("html").scrollTop( $(document).height()+100 );
$.mobile.silentScroll(99999);
}
	setTimeout(acc,100);

        $(function(){


            var wsurl = 'ws://127.0.0.1:9505/websocket/server.php';
            var websocket;
            // 閒置用變數
            var i = 0;
            var default_title=$("title").html();
            var oTimerId;
            //閒置用變數
            if(window.WebSocket){
                websocket = new WebSocket(wsurl);



                //websocket接建立
                websocket.onopen = function(evevt){
                    console.log("Connected to WebSocket server.");
                }
                //收到消息
                websocket.onmessage = function(event) {
                  //  i++;
									var userrecive_v=$('#userrecive').val();
									var usersend_v=$('#usersend').val();
                  var msg = JSON.parse(event.data);
                  var message = msg.message;
									var userrecive=msg.userrecive;
									var usersend=msg.usersend;
									var img=msg.img;
									var chat_read=msg.chat_read;
								//	var read=msg.read;
 									console.log('有');

								//	console.log(chat_read+'123');
								//	console.log(usersend_v);
									if(chat_read==usersend_v){
										//	$(".a2").append("<span id='"+i+"'style='clear:right; float:right; line-height:30px;font-size:12px; font-weight:normal;'><font color='green' class='read'>已讀</font>&nbsp;&nbsp;<div style='clear:right;float:right;background-color:#99ccff; line-height:30px; border-radius: 5px;font-size:20px; font-size:20px'>"+message+"</div></span><br><br>");
										$(".read").show();

											}
                  if(message!=null){


										if(usersend==usersend_v && userrecive==userrecive_v){


													$(".a2").append("<span id='"+i+"'style='clear:right; float:right; line-height:30px;font-size:12px; font-weight:normal;'><font color='green' class='read' style='display:none;'>已讀</font>&nbsp;&nbsp;<div style='clear:right;float:right;background-color:#99ccff; line-height:30px; border-radius: 5px;font-size:20px; font-size:20px'>"+message+"</div></span><br><br>");

												 // 沒有已讀 方式 $(".a2").append("<span id='"+i+"' style='clear:right; float:right; background-color:#99ccff; line-height:30px; border-radius:5px; font-size:20px;'>"+message+"</span><br><br>");

											 //	window.location.hash = '#'+i;
                       $("html").scrollTop( $(document).height()+100 );
                       $.mobile.silentScroll(99999);

													}

												if(usersend==userrecive_v && userrecive==usersend_v)	{

														$(".a2").append("<img src='"+img+"' style='border-radius:50%; width:40px; height:40px;'/><span id='"+i+"' style='background-color:#d1d1e0; line-height:30px; border-radius: 5px; font-size:20px; '>"+message+"</span><br><br>");
                                i++;
														//window.location.hash = '#'+i;
                          //  $("title").html("您有新訊息("+i+")");

                          //閒置提醒 start


                          $(document).mousemove(function(){
                            notification();

                          });

                          function Timeout(){
                                if(i>0){
                                $("title").html("您有新訊息("+i+")");
                              }
                          }
                          function notification(){
                            clearTimeout(oTimerId);
                            oTimerId=setTimeout(Timeout, 1 * 1 * 1000);
                          }
                            setTimeout(notification,500);

                          //閒置提醒 End
                            $("html").scrollTop( $(document).height()+100 );
                            $.mobile.silentScroll(99999);
                            read();
												}

                  }
                }




                websocket.onerror = function(event){
                    console.log("Connected to WebSocket server error");
										history.go(0);

                }

                websocket.onclose = function(event){
                    console.log('websocket Connection Closed. ');

                }



            }
            else{
                console.log('您的瀏覽器不支援websocket!!');
            }


            //判定已讀狀態

						function read(){
					 var a=$('#userrecive').val();
					 var b=$('#usersend').val();
					 var msg={
							 a:a,
							 b:b,
					 };
					 try{
							 websocket.send(JSON.stringify(msg));
					 } catch(ex) {
							 console.log(ex);
					 }
				 }
				 setTimeout(read,500);

						function send(){


									var message = $('#message').val();
									var userrecive=$('#userrecive').val();
									var usersend=$('#usersend').val();


									if(message==""){

											return false;
								                        }

											var msg = {
													message: message,
													userrecive:userrecive,
													usersend:usersend,
																					};
											try{
													websocket.send(JSON.stringify(msg));
											} catch(ex) {
													console.log(ex);
											}
                        //閒置結束 start
                        $("title").html(default_title);
                          clearTimeout(oTimerId);
                          i=0;
                          //閒置結束end
				}

						$('#send').bind('click',function(){

								send();
                setTimeout(function(){
                 $("#message").focus();
                 Keyboard.show();
               },100);

							$("#message").val('');
              	$("#message").focus();


							});

							$(window).keydown(function(event){
								if(event.keyCode == 13){

											send();
                      setTimeout(function(){
                       $("#message").focus();
                     },500);
										$("#message").val('');

								}
						});


        });

        </script>

</head>

<body>

	<div data-role="page"  id="page1">

		<div data-role="header" data-theme="f" data-position="fixed" data-tap-toggle="false" >

				<a is="button" class="ui-btn ui-btn-left ui-btn-icon-left" href="chat.php" target="_parent" style="background:none; border:none;"><i class="fa fa-mail-reply" style="font-size:20px"></i></a>
				<?php
				 $sql="select * from user where username='{$_GET['userrecive']}'";
				 $query=mysqli_query($link,$sql);
				 $row=mysqli_fetch_assoc($query);

				 ?>
				 <h2><?php echo $row['name']; ?></h2>
		</div>

		<div data-role="content" >

			<?php
				$sql="select * from chatroom where (userrecive='{$_SESSION['id']}' and usersend='{$_GET['userrecive']}') or (userrecive='{$_GET['userrecive']}' and usersend='{$_SESSION['id']}') ";
				$query=mysqli_query($link,$sql);

				while($row2=mysqli_fetch_assoc($query)){

						if($row2['usersend']==$_SESSION['id']){

										if($row2['chat_read']==1){
												echo "<span style='clear:right; float:right; line-height:30px;font-size:12px; font-weight:normal;'><font color='green'>已讀</font>&nbsp;&nbsp;<div style='clear:right;float:right;background-color:#99ccff; line-height:30px; border-radius: 5px;font-size:20px; font-size:20px'>{$row2['message']}</div></span><br><br>";
										}
										else{
													echo"<span style='clear:right; float:right; background-color:#99ccff; line-height:30px; border-radius:5px; font-size:20px;'>{$row2['message']}</span><br><br>";
												}
						}
						else{


									echo"<img src='{$row['img']}' style='border-radius:50%; width:40px; height:40px;'/><span style='background-color:#d1d1e0; line-height:30px; border-radius: 5px; font-size:20px; '>{$row2['message']}</span><br><br>";

						}

				}
			?>

<!--
			<span style='float:right; line-height:30px;font-size:12px; font-weight:normal;'><font color='green'>已讀</font>&nbsp;&nbsp;<div style=' float:right;background-color:#99ccff; line-height:30px; border-radius: 5px;font-size:20px; font-size:20px'>我才大尾</div></span><br>
			<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8i6L905mfI2LDLA-rjBc_KySUmm15Tpdf2sjUXSai-oHcww7L_w' style='border-radius:50%; width:40px; height:40px;'/><span style='background-color:#d1d1e0;line-height:30px; border-radius: 5px; font-size:20px;'>笑死人啦</span><br><br>
			<span style='clear:right; float:right; background-color:#99ccff; line-height:30px; border-radius:5px; font-size:20px;'>我才大尾</span><br><br>
			<span style='clear:right; float:right; background-color:#99ccff; line-height:30px; border-radius:5px; font-size:20px;'>我才大尾</span><br><br>
			<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8i6L905mfI2LDLA-rjBc_KySUmm15Tpdf2sjUXSai-oHcww7L_w' style='border-radius:50%; width:40px; height:40px;'/><span style='background-color:#d1d1e0; line-height:30px; border-radius: 5px; font-size:20px; '>垃圾啦說謊都不用打炒搞得啦廢物拉基</span><br><br>
-->
		<div class='a2' >

		</div>

		<?php

	  	$sql="update chatroom set chat_read=1 where usersend='{$_GET['userrecive']}' and userrecive='{$_SESSION['id']}'";
	  	$query=mysqli_query($link,$sql);


	   ?>

		</div>

		<div data-role="footer" data-position="fixed" data-tap-toggle="false">

			<input id="userrecive" type="hidden" value="<?php echo $_GET['userrecive'];  ?>" />
			<input id="usersend" type="hidden" value="<?php echo $_SESSION['id']; ?>"  />
			<input id="message" data-wrapper-class="message"  type="text"  placeholder="Aa" autofocus /> <!--onblur="this.focus();autofocus"-->
     <button id="send"  class="ui-btn ui-btn-right ui-icon-edit ui-btn-icon-left" style="padding:18px; background:none; border:none;" ></button>




		</div>

	</div>



</body>
</html>
