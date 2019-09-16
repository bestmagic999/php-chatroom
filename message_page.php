<?php session_start();
include 'db.php';
if(!isset($_SESSION['online'])){
echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}

  if($_POST){

    $pick=4;
    $page=$_POST['page']*$pick;

    $sql="select message_board.post_id,user.name, user.img, message_board.content,message_board.post_date,message_board.post_img from message_board join user on(message_board.post_user=user.username) order by post_date desc limit {$page},{$pick}";
    $query=mysqli_query($link,$sql);
    while($row=mysqli_fetch_assoc($query)){

        $sql2="select count(*) as count from message_sub where post_id='{$row['post_id']}'";
        $query2=mysqli_query($link,$sql2);
        $count=mysqli_fetch_assoc($query2);

      $post_date = date("Y/m/d H:i",strtotime($row['post_date']));
        echo "<img src='{$row['img']}'style='width:50px; height:50px; border-radius:50%; float:left;' />"
              ."<span style='float:left; margin-left:10px;' >{$row['name']}</span><br>"
              ."<span style='float:left;margin-left:10px;''>{$post_date}</span>"
              ."<div style='clear:left; margin-top:10px; margin-left:10px;'>{$row['content']}</div>";
            if($row['post_img']!=null){
            echo	"<br><img src='{$row['post_img']}' style='width:100%; display:block; margin:auto;'/>";
            }

          $sql3="select count(*) as count from message_great where post_id='{$row['post_id']}'";
          $query3=mysqli_query($link,$sql3);
          $great_count=mysqli_fetch_assoc($query3);

          if($great_count['count']>0){  //讚數計算
          echo	"<img id='{$row['post_id']}_img' onclick='who({$row['post_id']});' src='https://cfshopeetw-a.akamaihd.net/file/cce86d22379864db5a7dbd696b85f234_tn' style='width:20px; float:left; cursor:pointer;'/>"
                ."<span id='{$row['post_id']}'  onclick='who({$row['post_id']});' style='float:left; margin-left:10px; cursor:pointer;'>{$great_count['count']}</span>";
              }else{
                echo	"<img id='{$row['post_id']}_img' onclick='who({$row['post_id']});' src='https://cfshopeetw-a.akamaihd.net/file/cce86d22379864db5a7dbd696b85f234_tn' style='width:20px; float:left;  display:none; cursor:pointer;'/>"  //給ajax用當第一筆
                      ."<span id='{$row['post_id']}' onclick='who({$row['post_id']});' style='float:left; margin-left:10px; display:none; cursor:pointer;'>{$great_count['count']}</span>";
              }

        if($count['count']>0){ //留言數計算
          echo	"<div style='float:right;''><a href='message_sub.php?post_id={$row['post_id']}' target='_parent' style='text-decoration:none; color:#4D2078;'>{$count['count']}則留言</a></div>";
              }

        echo "<hr size='1' color='#e6e6e6' style='margin-top:20px;'>"
              ."<table width='100%'>"
              ."<tr>";

          $sql4="select *  from message_great where post_id='{$row['post_id']}' and great_user='{$_SESSION['id']}'";

          $query4=mysqli_query($link,$sql4);

          if($alive=mysqli_fetch_assoc($query4)){
            echo "<td id='{$row['post_id']}_g' onclick='grat(1,{$row['post_id']});' style='cursor:pointer;' align='center' width='50%''><i id='{$row['post_id']}_gt0' style=' color:blue;' class='fa'>&#xf087;</i><span  id='{$row['post_id']}_gt' style=' color:blue;'>讚</span>";
          }else{
              echo "<td  id='{$row['post_id']}_g' onclick='grat(0,{$row['post_id']});' style='cursor:pointer;' align='center' width='50%''><i id='{$row['post_id']}_gt0' style='color:gray;' class='fa'>&#xf087;</i><span id='{$row['post_id']}_gt' style=' color:gray;'>讚</span>";
          }

        echo  "<td align='center' width='50%''><a href='message_sub.php?post_id={$row['post_id']}' target='_parent' style='text-decoration:none; color:gray;'>留言</a></td>"
              ."<tr>"
              ."</table>"
              ."<hr size='1px' color='#e6e6e6' >";


    }
    if(mysqli_num_rows($query)>0){
    mysqli_free_result($query2);
    mysqli_free_result($query3);
    mysqli_free_result($query4);
    mysqli_free_result($query);
}








  }


?>
