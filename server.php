<?php
include 'db.php';
$host = '127.0.0.1';
$port = '9505';
$null = NULL;

//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
//bind socket to specified host
socket_bind($socket, 0, $port);

//listen to port
socket_listen($socket);

//client socket
$clients = array($socket);


while (true) {

    $changed = $clients;

    socket_select($changed, $null, $null, 0, 10);


    if (in_array($socket, $changed)) {

        $socket_new = socket_accept($socket);
        $clients[] = $socket_new; //有新的連線就寫入$clents陣列裡
         // print_r($clients);
        //讀取客戶端sokcet資料
        $header = socket_read($socket_new, 1024);
        perform_handshaking($header, $socket_new, $host, $port);

        //取得連線者的IP位置

        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }

    //詢問客戶端的接
    foreach ($changed as $changed_socket) {

        //如果客戶端有發送資料過來

        while(@socket_recv($changed_socket, $buf, 1024, 0) >= 1)
        {
            //解碼數據
            $userrecive_read="";
            $usersend_read="";
            $group_read=0;

           $received_text2=unmask($buf);
            $tst_msg2 = json_decode($received_text2);
            if(isset($tst_msg2->a) && isset($tst_msg2->b)){  //當資料時報錯問題
            $userrecive_read=$tst_msg2->a;
            $usersend_read=$tst_msg2->b;

            }
            if(isset($tst_msg2->group_read)){
              $group_read=$tst_msg2->group_read;
            }




                if($userrecive_read!='' &&$usersend_read!=''){

                  if($group_read==0){  //個人聊天 已讀
                    $chat_read_sql="update chatroom set chat_read=1 where usersend='{$userrecive_read}' and userrecive='{$usersend_read}'";
                    $chat_read_query=mysqli_query($link,$chat_read_sql);

                    $response_text2 = mask(json_encode(array('chat_read'=>$userrecive_read)));
                    send_message($response_text2);
                  }

                  if($group_read==1){  //個人聊天 已讀
                    $sql="select * from chatroom where userrecive='{$userrecive_read}' and usersend!='{$usersend_read}' and group_user_read not like '%{$usersend_read}%'";
                    $query=mysqli_query($link,$sql);

                      while($row=mysqli_fetch_assoc($query)){
                        $chat_read=(int)$row['chat_read'];
                        $chat_read_sql="update chatroom set chat_read=$chat_read+1,group_user_read='{$row['group_user_read']}{$usersend_read}/' where idchat='{$row['idchat']}'";
                        $chat_read_query=mysqli_query($link,$chat_read_sql);


                        $sql_t="select * from chatroom where userrecive='{$userrecive_read}' and usersend='{$usersend_read}' ORDER by idchat desc limit 1";
                        $query_t=mysqli_query($link,$sql_t);
                        $row_t=mysqli_fetch_assoc($query_t);
                        $chat_read=$row_t['chat_read'];

                          //echo $chat_read;
                          $response_text2 = mask(json_encode(array('chat_read_g'=>$chat_read)));
                          send_message($response_text2);
                      }



                  }



                }


            $received_text = unmask($buf);
            $tst_msg = json_decode($received_text);


              $message="";
              $userrecive="";
              $usersend="";
              $group=0;

              if(isset($tst_msg->message) ){       //解決已讀報錯問題 解碼的 message 不存在 部存取

                $message = $tst_msg->message;
                $userrecive=$tst_msg->userrecive;
                 $usersend=$tst_msg->usersend;


              }
              if(isset($tst_msg->group)){
                 $group=$tst_msg->group;
              }




              if($message!='' && $userrecive!='' && $usersend!=''){

                if($group==0){   //個人聊天
                $chat_num_sql="select * from chatroom where (usersend='{$usersend}' and userrecive='{$userrecive}') or (usersend='{$userrecive}' and userrecive='{$usersend}') ";
                $chat_num_query=mysqli_query($link,$chat_num_sql);
                if(mysqli_num_rows($chat_num_query)>0){
                    $chat_num_row=mysqli_fetch_assoc($chat_num_query);
                    $chat_num=$chat_num_row['chat_num'];
                  }else{
                    $chat_num="";
                    $word = 'abcdefghijkmnpqrstuvwxyz0123456789';
                    $len = strlen($word); //取得長度
                    for($i = 0; $i < 5; $i++){ //總共取 幾次
                      $chat_num=$chat_num.$word[rand() % $len];//隨機取得一個字元 字串相加要用(.)
                    }
                  }
                }
                  if($group==1){  //  群組聊天
                    $chat_num_sql="select * from chatroom where  userrecive='{$userrecive}' ";
                    $chat_num_query=mysqli_query($link,$chat_num_sql);

                    if(mysqli_num_rows($chat_num_query)>0){
                        $chat_num_row=mysqli_fetch_assoc($chat_num_query);
                        $chat_num=$chat_num_row['chat_num'];
                      }else{
                        $chat_num="";
                        $word = 'abcdefghijkmnpqrstuvwxyz0123456789';
                        $len = strlen($word); //取得長度
                        for($i = 0; $i < 5; $i++){ //總共取 幾次
                          $chat_num=$chat_num.$word[rand() % $len];//隨機取得一個字元 字串相加要用(.)
                        }
                      }
                  }




            $sql="insert into chatroom (usersend,userrecive,message,date,chat_num,group_chat) values('{$usersend}','{$userrecive}','{$message}',CURRENT_TIMESTAMP,'{$chat_num}','{$group}')";
            $query=mysqli_query($link,$sql);




            $sql2="select * from user where username='{$usersend}' ";
            $query2=mysqli_query($link,$sql2);
            $row=mysqli_fetch_assoc($query2);



            if($group==0){
            $sql3="select COUNT(*) as count  FROM `chatroom` where chat_read=0 and usersend='{$usersend}' and userrecive='{$userrecive}'";
            $query3=mysqli_query($link,$sql3);
            $row3=mysqli_fetch_assoc($query3);
          }

          if($group==1){
          $sql3="select COUNT(*) as count FROM `chatroom` where userrecive='{$userrecive}' and usersend!='sa' and group_user_read not like '%sa%'";
          $query3=mysqli_query($link,$sql3);
          $row3=mysqli_fetch_assoc($query3);
        }

              if($group==1){

                $sql_t="select * from chatroom where userrecive='{$userrecive}' and usersend='{$usersend}' ORDER by idchat desc limit 1";

                $query_t=mysqli_query($link,$sql_t);
                $row_t=mysqli_fetch_assoc($query_t);
                $chat_read=$row_t['chat_read'];
              }
              if($group==0){
                $chat_read=$userrecive_read;
              }

            //把訊息傳送給所有連線到server的客戶端
            $response_text = mask(json_encode(array('message'=>$message,'userrecive'=>$userrecive,'usersend'=>$usersend,'img'=>$row['img'],'count'=>$row3['count'],'chat_read'=>$chat_read,'send_name'=>$row['name'])));
            send_message($response_text);

            }


         break 2;

      }


      //检查offline的client
    $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
    if ($buf === false) {
        $found_socket = array_search($changed_socket, $clients);
        socket_getpeername($changed_socket, $ip);
        unset($clients[$found_socket]);
       // print_r($clients);

    }

    }
}
// 關閉連線
socket_close($sock);


//傳送訊息
function send_message($msg)
{
    global $clients;
    foreach($clients as $changed_socket)
    {
        @socket_write($changed_socket,$msg,strlen($msg));
    }
    return true;
}


//解密
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}

//加密
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}

//handshake new client. HTTP 升級到 websocket
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
    "Upgrade: websocket\r\n" .
    "Connection: Upgrade\r\n" .
    "WebSocket-Origin: $host\r\n" .
    "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
    "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
}
