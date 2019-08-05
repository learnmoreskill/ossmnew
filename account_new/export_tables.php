<?php include('session.php'); ?>
<?php
//require("nepaliDate.php");
// require("account_management.php");
include('load_backstage.php'); 

// $account = new account_management_classes();
// $school_details = json_decode($account->get_school_details_by_id());
$tables = json_decode($account->get_list_of_table_from_database());
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>A1Pathshala</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
    <link rel="stylesheet" type="text/css" href="assets/fontawesome--5.0.13/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets\css\nprogress.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">  
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script src="assets/js/chart-master/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

    <script>
    function loadScript() {
      $('#export_Table').DataTable( {
          dom: 'Bfrtip',
          bFilter: false,
          responsive: true,
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print',
          ]
      } );
    }
    </script>
  </head>

  <body>


  <section id="container" >
       
      <?php include('header.php'); ?>
      <?php include('externalnavbar.php'); ?> 

      <!--main content start-->
      <section id="main-content">

          <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-responsive table-striped b-t b-light display">
                      <thead>
                        <tr>
                          <th>S.N</th>
                          <th>Database Tables</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
                        $sn=1;
                       foreach ($tables as $key) {
                       
                            echo'<tr>
                                    <td>'.$sn.'</td>
                                    <td>'.$key->table_name.'</td>
                                    <td>  <a class="btn btn-sm tableID" style="background-color:#58d68d; color:#fff;" data-target=".bd-example-modal-lg" href="#viewModal" data-toggle="modal" data-whatever="'.$key->table_name.'"><i class="glyphicon glyphicon-eye-open"></i> Export</a></td>
                                </tr>';

                            $sn++;
                        }
                       
                        ?>
                        
                      </tbody>
                    </table>
 
                </div>                          
            </div> 

            <div id="viewModal" class="modal fade bd-example-modal-lg" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
              <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content-viewModal">
                    
                     
                  </div>
                </div>
              </div>
            </div>
              
          </section>
      </section>

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
             
              <a href="index.php#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

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

    <script type="text/javascript">
      $(document).ready(function()
      {

         $('.tableID').click(function(){
            var ItemID=$(this).attr('data-whatever');
            $.ajax({url:"export_tables_modal.php?table_name="+ItemID,cache:false,success:function(result){
                $(".modal-content-viewModal").html(result);
            }});
          });
      });
    </script>
    
    
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
 <script>
 </script>

  </body>
</html>
