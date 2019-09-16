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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		.loader {
		  border: 5px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 5px solid black;
		  width: 30px;
		  height: 30px;
			display: block;
			margin: auto ;
		  -webkit-animation: spin 2s linear infinite; /* Safari */
		  animation: spin 2s linear infinite;
		}

		/* Safari */
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}

		.modal {
		    display: none; /* Hidden by default */
		    position: fixed; /* Stay in place */
		    z-index: 1; /* Sit on top */
		    left: 0;
		    top: 0;
		    width: 100%; /* Full width */
		    height: 100%; /* Full height */
		    overflow: auto; /* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		    -webkit-animation-name: fadeIn; /* Fade in the background */
		    -webkit-animation-duration: 0.4s;
		    animation-name: fadeIn;
		    animation-duration: 0.4s
		}

		/* Modal Content */
		.modal-content {
		    position: fixed;
				height: 70%;
		    bottom: 0;
		    background-color: #fefefe;
		    width: 100%;
				overflow: auto;
		    -webkit-animation-name: slideIn;
		    -webkit-animation-duration: 0.4s;
		    animation-name: slideIn;
		    animation-duration: 0.4s
		}

		/* The Close Button */
		.close {
		    color: white;
		    float: right;
		    font-size: 28px;
		    font-weight: bold;
		}

		.close:hover,
		.close:focus {
		    color: #000;
		    text-decoration: none;
		    cursor: pointer;
		}

		.modal-header {
		    padding: 2px 10px;
		    background-color: pink;
		    color: white;
		}

		.modal-body {padding: 2px 16px;  overflow: auto;}



		/* Add Animation */
		@-webkit-keyframes slideIn {
		    from {bottom: -300px; opacity: 0}
		    to {bottom: 0; opacity: 1}
		}

		@keyframes slideIn {
		    from {bottom: -300px; opacity: 0}
		    to {bottom: 0; opacity: 1}
		}

		@-webkit-keyframes fadeIn {
		    from {opacity: 0}
		    to {opacity: 1}
		}

		@keyframes fadeIn {
		    from {opacity: 0}
		    to {opacity: 1}
		}

	</style>

<script>

$(document).ready(function(){

upload();
var count=0; //控制滾輪以免更新太多次 抓取次數
var update_data=1; //已經沒資料
	function upload(){
	var page=parseInt($("#page").val());

		$.ajax({

				type :"POST",
				url  : "message_page.php",
				data : {
						page : page,
										},
				dataType: "text",
				success : function(data) {
						var next_page=page+1;
					$("#content").append(data);
					$("#page").val(next_page);
					count=0;

					if(data==""){
						update_data=0;
					}


		}
		})
	}

$(".loader").hide();
$(window).scroll(function(){

	var scrollHeight = $(document).height();
		var scrollPosition = $(window).height() + $(window).scrollTop();


		if($(document).height() > $(window).height())
     {
         if($(window).scrollTop() + $(window).height() > $(document).height() - 100 && count==0 && update_data>0){
					 	count++;
					 $(".loader").show(0).delay(200).hide(0,function(){
					 upload();
					 });
         }
     }






});

	$(".close").on('click',function(){
			$(".modal").hide();
	});



});


</script>

<script>

function who(id){ //誰案讚 ajax

		$.ajax({
					type:"POST",
					url:"message_who_grat.php",
					data:{id:id},
					dataType:"text",
					success: function(data){

							$(".modal").show();
								$(".modal-body").empty();
							$(".modal-body").append(data);
					}

		});


}


function grat(data,id){  //讚計算 ajax
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

</head>

<body>

	<div data-role="page" id="page1"  >

		<div data-role="header" data-theme="f" data-tap-toggle="false" data-position="fixed" data-transition="none">
				<h2>留言板</h2>
					 <a is="button" class="ui-btn ui-btn-right ui-btn-icon-right ui-icon-edit" href="add_message.php" target="_parent" style="padding:18px; background:none; border:none;"></a>
		</div>


		<div  id="content" data-role="content" data-iscroll >
			<input  id="page" type="hidden" value="0"/>


						<!-- The Modal -->
						<div id="myModal" class="modal">

						  <!-- Modal content -->
						  <div class="modal-content">
							<div class="modal-header">
							  <span class="close">&times;</span>
							  <h2>誰來按讚</h2>
							</div>
							<div class="modal-body">




							</div>

						  </div>

						</div>


		</div>


		<div data-role="footer" data-position="fixed" data-tap-toggle="false" data-transition="none">
	<div class="loader" ></div>
      <div data-role="navbar" >
      <ul>
        <li><a href="message_board.php" target="_parent" data-icon="home">留言板</a></li>
        <li><a href="chat.php#page2" target="_parent" data-icon="user">個人</a></li>
        <li><a href="chat.php" data-icon="comment">聊天</a></li>
        <li><a href="logout.php" data-icon="power">登出</a></li>

      </ul>
      </div>


		</div>

	</div>








</body>
</html>
