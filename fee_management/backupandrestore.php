<?php
  require('account_management.php');
$account = new account_management_classes();
$tables=json_decode($account->get_list_of_tables_from_database());

?>


<!DOCTYPE html>
<html>
  <title>Back Up And Restore Database</title>


 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>A1Pathshala</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    <link href="assets/css/style.css" rel="stylesheet">

    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script src="assets/js/chart-master/Chart.js"></script>

  </head>


<body>

<?php include('externalnavbar.php'); ?>

<section id="main-content">
  <section class="wrapper">
    <div class="table-agile-info" id='load_edit_teacher_record'>
      <div class="panel panel-default">
        <div class="panel-heading">Back Up And Restore Database</div>
        
        <div class="">

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#backup">Back Up</a></li>
    <li><a data-toggle="tab" href="#restore">Restore</a></li>
  </ul>

  <div class="tab-content">
    <div id="backup" class="tab-pane fade in active">
      <h3>back Up</h3>
      <form method="POST" id="backupform">
        <?php
          foreach ($tables as $key) 
          {
          ?>

          <div class="checkbox">
            <label>
              <!-- <input type="checkbox" class="checkbox_table" name="table[]" value="<?php echo $key->table_name ;?>" > -->
              <?php echo $key->table_name; ?>
            </label>
          </div>

            
        <?php
          }
        ?>
        <input type="submit" name="backup" value="Back Up" class="btn btn-primary">
      </form>

    </div>
    <?php
    if(isset($_POST['backup']))
  {

define("BACKUP_PATH", "../");

$server_name   = "localhost";
$username      = "root";
$password      = "root";
$database_name = "accountant";
$date_string   = date("Ymd");

$cmd = "mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";

exec($cmd);
 }
   

    ?>

    <div id="restore" class="tab-pane fade">
      <h3>Restore</h3>
      <form method="POST" id="restoreform">
        <input type="button" name="backup" value="Restore" class="btn btn-primary">
      </form>
    </div>
    
  </div>
</div>

      </div>
    </div>
  </section>
</section>


<!-- script to back up database -->
<<!-- script type="text/javascript">
  
  $.(document).ready(function(){
    $.('#backupform').click(function(){
    var a=<?php echo "nepal"; ?>      
    });
  });  

</script> -->

<script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.sparkline.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <script src="assets/js/sparkline-chart.js"></script>    
    <script src="assets/js/zabuto_calendar.js"></script>    

</body>
</html>