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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  	<title>線上聊天室</title>

  	<style>
    *{margin:0px;padding:0px}
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
    $(function(){
        $("#gogo").click(function(){
            $("#panel").slideToggle('fast');
        });
    });

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
              var step=0;
              var x=0;
              var i = 0;
              var default_title=$("title").html();
              var oTimerId;
              var xx;
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
                    var chat_read_g=msg.chat_read_g;
                    var usersend_g=msg.usersend_g;
                  //  console.log(usersend_g);
                        console.log("已讀"+chat_read_g);
                    if(chat_read_g >0 &&  msg.chat_read_g!=null ){

                        $(".read").show();
                        $(".read").text('已讀'+chat_read_g);

                    }



                    if(message!=null){

                      if(usersend==usersend_v && userrecive==userrecive_v){



                            $(".a2").append("<span id='"+i+"'style='clear:right; float:right; line-height:30px;font-size:12px; font-weight:normal;'><font color='green' class='read' style='display:none;'>已讀</font>&nbsp;&nbsp;<div style='clear:right;float:right;background-color:#99ccff; line-height:30px; border-radius: 5px;font-size:20px; font-size:20px'>"+message+"</div></span><br><br>");

                           // 沒有已讀 方式 $(".a2").append("<span id='"+i+"' style='clear:right; float:right; background-color:#99ccff; line-height:30px; border-radius:5px; font-size:20px;'>"+message+"</span><br><br>");

                        //  window.location.hash = '#'+i;
                        $("html").scrollTop( $(document).height()+100 );
                        $.mobile.silentScroll(99999);

                            }

                          if(usersend!=usersend_v && userrecive==userrecive_v)	{
                              $(".a2").append("<img src='"+img+"' style='border-radius:50%; width:40px; height:40px;'/><span id='"+i+"' style='background-color:#d1d1e0; line-height:30px; border-radius: 5px; font-size:20px; '>"+message+"</span><br><br>");
                            //  window.location.hash = '#'+i;


                            //閒置提醒 start
                              i++;


                            $(document).mousemove(function(){
                              notification();
                                if(x==0){
                                  //閒置結束 start

                                  $("title").html(default_title);
                                    i=0;
                                    //閒置結束end
                                }
                              x++;
                            });

                      function Timeout(){

                            setInterval(
                              function(){
                              step++;
                              if(i>0){
                               if(step==3){step=1}
                               if(step==1){$("title").html("您有新訊息("+i+")");}
                               if(step==2){$("title").html("您有新訊息");}
                                  //  $("title").html("您有新訊息("+i+")");
                                  x=0;
                                }

                              },500);

                            }
                            function notification(){
                              clearTimeout(oTimerId);
                              oTimerId=setTimeout(Timeout, 500);
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



              function send(){


                    var message = $('#message').val();
                    var userrecive=$('#userrecive').val();
                    var usersend=$('#usersend').val();
                    var group=1;


                    if(message==""){

                        return false;
                                          }

                        var msg = {
                            message: message,
                            userrecive:userrecive,
                            usersend:usersend,
                            group:group
                                            };
                        try{
                            websocket.send(JSON.stringify(msg));
                        } catch(ex) {
                            console.log(ex);
                        }


          }

              $('#send').bind('click',function(){

                  send();
                  setTimeout(function(){
                   $("#message").focus();
                   Keyboard.show();
                 },100);

                $("#message").val('');



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

              function read(){

             var a=$('#userrecive').val();
             var b=$('#usersend').val();
             var group_read=1;
             var msg={
                 a:a,
                 b:b,
                 group_read:group_read,
             };
             try{
                 websocket.send(JSON.stringify(msg));
                 
             } catch(ex) {
                 console.log(ex);
             }
           }
           setTimeout(read,500);

          });
    </script>
</head>
<body>
  <div data-role="page" id="page1" >

  		<div data-role="header" data-theme="f" data-position="fixed" data-tap-toggle="false">
        	<a is="button" class="ui-btn ui-btn-left ui-btn-icon-left" href="chat.php" target="_parent" style="background:none; border:none;"><i class="fa fa-mail-reply" style="font-size:20px"></i></a>
          <?php
            $sql="select group_name,count(*) as count from group_chat where group_id='{$_GET['userrecive']}' ";
            $query=mysqli_query($link,$sql);
            $row=mysqli_fetch_assoc($query);


          ?>
          <h2 id="gogo"><?php echo $row['group_name']."({$row['count']})"; ?> <i class="fa fa-lightbulb-o" style="color:black;"></i></h2>
          <div id="panel" style="display:none; overflow:auto;" >
            <?php
              $sql="select * from group_chat where group_id='{$_GET['userrecive']}'";
              $query=mysqli_query($link,$sql);

                while ($row=mysqli_fetch_assoc($query)) {
                $sql2="select * from user where username='{$row['username']}'";
                $query2=mysqli_query($link,$sql2);
                    while($row2=mysqli_fetch_assoc($query2)){
                      echo "<img src='{$row2['img']}' style='width:40px; height:40px; border-radius:50%;' />&nbsp;";
                    }
                }
             ?>
          </div>
  		</div>

<div data-role="content">
      <?php
      $sql="select * from chatroom where userrecive='{$_GET['userrecive']}'";
      $query=mysqli_query($link,$sql);

          while($row=mysqli_fetch_assoc($query)){

            if($row['usersend']==$_SESSION['id']){
                if($row['chat_read']>0){
                  	echo "<span style='clear:right; float:right; line-height:30px;font-size:12px; font-weight:normal;'><font color='green' >已讀{$row['chat_read']}</font>&nbsp;&nbsp;<div style='clear:right;float:right;background-color:#99ccff; line-height:30px; border-radius: 5px;font-size:20px; font-size:20px'>{$row['message']}</div></span><br><br>";
                }else{

              echo"<span style='clear:right; float:right; background-color:#99ccff; line-height:30px; border-radius:5px; font-size:20px;'>{$row['message']}</span><br><br>";
            }
            }
            else{

                $sql2="select * from user where username='{$row['usersend']}'";
                $query2=mysqli_query($link,$sql2);
                $row2=mysqli_fetch_assoc($query2);

                  echo"<img src='{$row2['img']}' style='border-radius:50%; width:40px; height:40px;'/><span style='background-color:#d1d1e0; line-height:30px; border-radius: 5px; font-size:20px; '>{$row['message']}</span><br><br>";

            }

          }
      ?>
      <div class='a2' >

  		</div>

      <?php //群組計次問題 已讀
            $sql="select * from chatroom where userrecive='{$_GET['userrecive']}' and usersend!='{$_SESSION['id']}' and group_user_read not like '%{$_SESSION['id']}%'";
            $query=mysqli_query($link,$sql);

              while($row=mysqli_fetch_assoc($query)){
                $chat_read=(int)$row['chat_read'];
                $sql_update="update chatroom set chat_read=$chat_read+1,group_user_read='{$row['group_user_read']}{$_SESSION['id']}/' where idchat='{$row['idchat']}'";
                $query_update=mysqli_query($link,$sql_update);
              }



      ?>

</div>



  		<div data-role="footer" data-position="fixed" data-tap-toggle="false">
        <input id="userrecive" type="hidden" value="<?php echo $_GET['userrecive'];  ?>" />
        <input id="usersend" type="hidden" value="<?php echo $_SESSION['id']; ?>"  />
        <input id="message" data-wrapper-class="message" type="text"   placeholder="Aa" autofocus /> <!--onblur="this.focus();autofocus"-->
        <button id="send"  class="ui-btn ui-btn-right ui-icon-edit ui-btn-icon-left" style="padding:18px; background:none; border:none;" ></button>
  			</div>

  		</div>


</body>

</html>
