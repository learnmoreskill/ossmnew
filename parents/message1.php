<?php 
    //require_once("session.php");

    
?>
<!DOCTYPE html>
<html>
<head>
    <title>Facebook Style Private Messaging System in php</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <center>
        <!-- <a href="http://blog.hackerkernel.com/2015/09/17/jqueryui-autocomplete-dropdown-with-php-and-json" target="_blank">Tutorial</a> / 
        <a href="http://demo.hackerkernel.com/download.php?url=1ozuzawpkwuzjd3uzmomwbrt5pnzpjsa" target="_blank">Download Script</a> / 
        <a href="http://hackerkernel.com/contact.php" target="_blank">Want Me to Work on your Dream Project</a> --> / 
        <br>
        <strong>Welcome <a href="logout.php">logout</a></strong>
    </center>
     
    <div class="message-body">
        <div class="message-left">
            <ul>
                <?php
                    
                    /*$q = mysqli_query($con, "SELECT * FROM `user` WHERE id!='$user_id'");
                    
                    while($row = mysqli_fetch_assoc($q)){
                        echo "<a href='message.php?id={$row;'id';}'><li><img src='{$row;'img';}'> {$row['username']}</li></a>";
                    }*/
                ?>
            </ul>
        </div>
 
        <div class="message-right">
            <!-- display message -->
            <div class="display-message">
            <?php
                //check $_GET&#91;'id'&#93; is set
               /* if(isset($_GET;'id';)){
                    $user_two = trim(mysqli_real_escape_string($con, $_GET;'id';));
                    //check $user_two is valid
                    $q = mysqli_query($con, "SELECT `id` FROM `user` WHERE id='$user_two' AND id!='$user_id'");
                    //valid $user_two
                    if(mysqli_num_rows($q) == 1){
                        //check $user_id and $user_two has conversation or not if no start one
                        $conver = mysqli_query($con, "SELECT * FROM `conversation` WHERE (user_one='$user_id' AND user_two='$user_two') OR (user_one='$user_two' AND user_two='$user_id')");
 
                        //they have a conversation
                        if(mysqli_num_rows($conver) == 1){
                            //fetch the converstaion id
                            $fetch = mysqli_fetch_assoc($conver);
                            $conversation_id = $fetch;'id';
                        }else{ //they do not have a conversation
                            //start a new converstaion and fetch its id
                            $q = mysqli_query($con, "INSERT INTO `conversation` VALUES ('','$user_id',$user_two)");
                            $conversation_id = mysqli_insert_id($con);
                        }
                    }else{
                        die("Invalid $_GET ID.");
                    }
                }else {
                    die("Click On the Person to start Chating.");
                }*/
            ?>
            </div>
            <!-- /display message -->
 
            <!-- send message -->
            <div class="send-message">
                <!-- store conversation_id, user_from, user_to so that we can send send this values to post_message_ajax.php -->
                <!-- <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                <input type="hidden" id="user_form" value="<?php echo base64_encode($user_id); ?>">
                <input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>"> -->
                <div class="form-group">
                    <textarea class="form-control" id="message" placeholder="Enter Your Message"></textarea>
                </div>
                <button class="btn btn-primary" id="reply">Reply</button> 
                <span id="error"></span>
            </div>
            <!-- / send message -->
        </div>
    </div>
</body>
</html>
<style type="text/css">
	.message-body{
    display: block;
    height: 600px;
    width: 70%;
    margin:0px auto;
    border:1px solid #ccc;
	}
	.message-left{
	    display: block;
	    height: 100%;
	    width: 30%;
	    float: left;
	    overflow-y: scroll;
	    border-right: 1px solid #ccc;
	}
	.message-right{
	    display: block;
	    height: 100%;
	    width: 70%;
	    float: left;
	}
	.message-left ul{
	    list-style: none;
	    margin: 0;
	    padding: 0;
	    width: 100%;
	}
	.message-left ul a{
	    text-decoration: none;
	}
	.message-left ul a li{
	    padding: 5px;
	    border-bottom: 1px solid #ccc;
	    font-weight: bold;
	    color: black;
	}
	.message-left ul a li img{
	    height: 50px;
	    width: 50px;
	}
	.message-left ul a li:hover{
	    background: #EBEDF5;
	}
	.message-left ul a li.active{
	    background: #6B83B3;
	}
	.message-right .display-message{
	    display: block;
	    height: 80%;
	    width: 100%;
	    border-bottom: 1px solid #ccc;
	    overflow-y:scroll;
	}
	.message-right .send-message{
	    height: 20%;
	    background: #eee;
	    padding: 10px;
	}
	.display-message .message{
	    min-height: 60px;
	    padding: 5px;
	}
	.message .img-con{
	    width: 10%;
	    float: left;
	    height: inherit;
	}
	.message .img-con > img{
	    height: 50px;
	    width: 50px;
	}
	.message .text-con{
	    width: 90%;
	    float: left;
	    height: inherit;
	}
	hr{
	    margin-top: 0;
	    margin-bottom: 0;
	    border-top:1px solid #ccc;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
    /*post message via ajax*/
    $("#reply").on("click", function(){
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            user_form = $.trim($("#user_form").val()),
            user_to = $.trim($("#user_to").val()),
            error = $("#error");
 
        if((message != "") && (conversation_id != "") && (user_form != "") && (user_to != "")){
            error.text("Sending...");
            $.post("post_message_ajax.php",{message:message,conversation_id:conversation_id,user_form:user_form,user_to:user_to}, function(data){
                error.text(data);
                //clear the message box
                $("#message").val("");
            });
        }
    });
 
 
    //get message
    c_id = $("#conversation_id").val();
    //get new message every 2 second
    setInterval(function(){
        $(".display-message").load("get_message_ajax.php?c_id="+c_id);
    }, 2000);
 
    $(".display-message").scrollTop($(".display-message")[0].scrollHeight);
});
</script>