<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'message';

header('Content-Type: text/html; charset = utf-8');
$db->query("SET NAMES utf8");

$sqlquery = "SELECT `studentinfo`.`sname`,`complaint`.`cmsg`, `complaint`.`cdate`, `complaint`.`cclock` FROM `parents` 
    LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
    INNER JOIN `complaint` ON `studentinfo`.`sid` = `complaint`.`csid` 
    WHERE `parents`.`parent_id`='$login_session1' 
    ORDER BY `complaint`.`cclock` DESC ";

    $result = $db->query($sqlquery);
    $rowCount = $result->num_rows;
    if($rowCount > 0) { $found=1;} else{ $found=0;   }
    
    
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">My Message</a></div>
                    </div>
    <!-- <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
       <ul class="dropdown-menu"></ul>
      </li>
    </ul> -->
                </div>
            </div>
            <?php
            if ($found == 1) {
                while($row = $result->fetch_assoc()) { ?>


            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                    <div class="card-panel grey darken-3">
                        <span class="white-text">
                            <span class="card-title" style="font-size:14px;font-family:Roboto Condensed, sans-serif;">Message date: <?php echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['cclock']))) : date('Y-m-d', strtotime($row['cclock'])))." ".date('g:i A', strtotime($row['cclock'])); ?></span>
                            
                            <div class="card-content">
                                <blockquote class="flow-text"><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Message" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">message</i>&nbsp;<?php echo "Message: ".$row["cmsg"]." on date: ".(($login_date_type==2)? eToN($row["cdate"]) : $row["cdate"])." for: ".$row["sname"]; ?> </div> </blockquote>
                                </div>
                        </span>
                    </div>
                </div>
            </div>
                </div>


            <?php
            }
            } else if($found == 0){?>
                <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No homework complaint found for your child!!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </main>



       <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>


 <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 load_unseen_notification();
 
 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});
</script> -->