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
	.message{
    transform: translate(3%, 0%);
    width: 85%;
  }
	</style>

</head>

<body>

	<div data-role="page" id="page1" data-position="fixed" data-tap-toggle="false" >

		<div data-role="header" data-theme="f">
      	<a is="button" class="ui-btn ui-btn-left ui-btn-icon-left" href="message_board.php" target="_parent" style="background:none; border:none;"><i class="fa fa-mail-reply" style="font-size:20px"></i></a>
				<h2>留言板</h2>

		</div>


		<div id="content" data-role="content" style="overflow:auto;" >

			<?php

				$sql="select count(user.name) as count ,message_board.post_id,user.name, user.img, message_board.content,message_board.post_date,message_board.post_img from message_board join user on(message_board.post_user=user.username)  where post_id={$_GET['post_id']}";
				$query=mysqli_query($link,$sql);
				while($row=mysqli_fetch_assoc($query)){

					$post_date = date("Y/m/d H:i",strtotime($row['post_date']));


							$sql2="select count(*) as count from message_sub where post_id='{$_GET['post_id']}'";
							$query2=mysqli_query($link,$sql2);
							$count=mysqli_fetch_assoc($query2);

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
									echo	"<img id='{$row['post_id']}_img' src='https://cfshopeetw-a.akamaihd.net/file/cce86d22379864db5a7dbd696b85f234_tn' style='width:20px; float:left;'/>"
												."<span id='{$row['post_id']}' style='float:left; margin-left:10px;'>{$great_count['count']}</span>";
											}else{
												echo	"<img id='{$row['post_id']}_img' src='https://cfshopeetw-a.akamaihd.net/file/cce86d22379864db5a7dbd696b85f234_tn' style='width:20px; float:left;  display:none;'/>"  //給ajax用當第一筆
															."<span id='{$row['post_id']}' style='float:left; margin-left:10px; display:none;'>{$great_count['count']}</span>";
											}

							if($count['count']>0){
									echo"<div style='float:right;''><span id='count'>{$count['count']}</span>則留言</div>";
								}

									echo"<hr size='1' color='#e6e6e6' style='margin-top:20px;'>"
									."<table width='100%'>"
									."<tr>";

									$sql4="select *  from message_great where post_id='{$row['post_id']}' and great_user='{$_SESSION['id']}'";

									$query4=mysqli_query($link,$sql4);

									if($alive=mysqli_fetch_assoc($query4)){
										echo "<td id='{$row['post_id']}_g' onclick='grat(1,{$row['post_id']});' style='cursor:pointer;' align='center' width='50%''><i id='{$row['post_id']}_gt0' style='color:blue;' class='fa'>&#xf087;</i><span id='{$row['post_id']}_gt' style=' color:blue;'>讚</span>";
									}else{
											echo "<td id='{$row['post_id']}_g' onclick='grat(0,{$row['post_id']});' style='cursor:pointer;' align='center' width='50%''><i id='{$row['post_id']}_gt0' style='color:gray;' class='fa'>&#xf087;</i><span id='{$row['post_id']}_gt'  style=' color:gray;'>讚</span>";
									}

									echo "<td align='center' width='50%''>留言</td>"
											."<tr>"
											."</table>"
											."<hr size='1px' color='#e6e6e6'>";


				}

				mysqli_free_result($query2);
				mysqli_free_result($query3);
				mysqli_free_result($query4);
				mysqli_free_result($query);

				$sql="select user.name,user.img,message_sub.content from message_sub join user on(message_sub.sub_name=user.username) where post_id='{$_GET['post_id']}' order by sub_date ";
				$query=mysqli_query($link,$sql);

				while($row=mysqli_fetch_assoc($query)){
					echo "<img src='$row[img]' style='width:50px; height:50px; border-radius:50%; clear:left;float:left; margin-top:10px;'>"
							."<div style='float:left; margin-left:5px; background-color:#d1d1e0;  margin-top:10px; max-width:200px; border-radius:5px; padding:5px;'>"
							."<span style='float:left; ' >{$row['name']}</span><br>"
							."<span style='float:left; word-break: break-all;'>{$row['content']}</span>"
							."</div>";

				}
					mysqli_free_result($query);

			?>


		</div>



		<div data-role="footer" data-position="fixed" data-tap-toggle="false" >


		<input id="message"  data-wrapper-class="message" type="text"   placeholder="Aa" autofocus /> <!--onblur="this.focus();autofocus"-->


				<button id="send"   class="ui-btn ui-btn-right ui-icon-edit ui-btn-icon-left" style="padding:18px; background:none; border:none;" ></button>
		</div>
		<input id="post_id" type="hidden" value="<?php echo $_GET['post_id'];?>" >
		<script>
		$(document).on("ready", function() {


			 $("#send").on("click", function() {

				 if($("#message").val()!=''){

					 send();

				 }

			 });


			 						$(window).keydown(function(event){
			 								if(event.keyCode == 13){

												if($("#message").val()!=''){

													send();

												}

			 								}
			 						});

									function send(){
										var count=parseInt($("#count").text());
										$.ajax({
												type :"POST",
												url  : "message_sub_procese.php",
												data : {
														message : $("#message").val(),
														post_id:$("#post_id").val(),
														},
												dataType: "text",
												success : function(data) {
													 $("#content").append(data);
													 $("html").scrollTop( $(document).height()+100 );
													 $.mobile.silentScroll(99999);
													 $("#message").val('');
													 $("#count").text(count+1);
										}
										})
									}





			});

			function grat(data,id){
				var x=parseInt($("#"+id).text());

				$.ajax({
						type :"POST",
						url  : "message_grat_process.php",
						data : {
								grat : data,
								post_id:id},
						dataType: "text",
						success : function(data) {
								if(data==1){
			 			 		$("#"+id+"_g").attr('onclick','grat(1,'+id+');');
								$("#"+id+"_gt").attr("style","color:blue;");
								$("#"+id+"_gt0").attr("style","color:blue;");
								$("#"+id).text(x+1);


								$("#"+id).show();
								$("#"+id+"_img").show();


					 			}

								if(data==0){
									$("#"+id+"_g").attr('onclick','grat(0,'+id+');');
									$("#"+id+"_gt").attr("style","color:gray;");
									$("#"+id+"_gt0").attr("style","color:gray;");
									$("#"+id).text(x-1);
										if(x-1==0){
											$("#"+id).hide();
											$("#"+id+"_img").hide();
										}

								}

				}
				})

			}


		</script>






	</div>








</body>
</html>
