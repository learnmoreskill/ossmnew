<?php include('session.php'); ?>
<?php
//require("nepaliDate.php");
require("account_management.php");
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());
$bus_details = json_decode($account->get_student_bus_fee_details());
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
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">  --> 

    
    

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.4.1/css/colReorder.dataTables.min.css">
    
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    
  </head>

  <body>


  <section id="container" >
        <header class="header black-bg" style="background: #252423;">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><b><?php echo $school_details->school_name; ?></b></a>
            <!--logo end-->
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.html">Logout</a></li>
                </ul>
            </div>
        </header>
     
<?php include('externalnavbar.php'); ?>

      <!--main content start-->
      <section id="main-content">

          <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Student's Bus Details</div><br>
                      <!-- <div class="form-group pull-right">
                          <input type="text" class="search form-control" placeholder="What you looking for?">
                      </div><br> -->
                    <div class="panel-body">
                    <table id="busTable" class="table table-responsive table-striped b-t b-light display">
                      <thead class="thead-dark">
                        <tr>
                          <th>S.N</th>
                          <th>Student's Name</th>
                          <th>Bus Route</th>
                          <th>Bus Number</th>
                          <th>Bus Fee</th>
                          <th>Discount</th>
                          <th>Class/Section</th>
                          <th>Address</th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
                        $sn=1;
                        // $list = $page->children()->paginate(10);
                        // $pagination = $list->pagination();

                       foreach ($bus_details as $key) {
                       
                            echo'<tr>
                                    <td>'.$sn.'</td>
                                    <td>'.$key->sname.'</td>
                                    <td>'.$key->bus_route.'</td>
                                    <td>'.$key->bus_number.'</td>
                                    <td>'.$key->bus_fee_rate.'</td>
                                    <td>'.$key->bus_discount_percent.'</td>
                                    <td>'.$account->get_student_class_name_by_id($key->sclass).'-'.$account->get_section_name_by_section_id($key->ssec).'</td>
                                    <td>'.$key->saddress.'</td>
                                 </tr>';

                            $sn++;
                        }
                       
                        ?>
                        
                      </tbody>
                    </table>
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.sparkline.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <script src="assets/js/sparkline-chart.js"></script>    
    <script src="assets/js/zabuto_calendar.js"></script>

    <!-- <script>
    $(document).ready(function(){
        $('.search').on('keyup',function(){
            var searchTerm = $(this).val().toLowerCase();
            $('#userTbl tbody tr').each(function(){
                var lineStr = $(this).text().toLowerCase();
                if(lineStr.indexOf(searchTerm) === -1){
                    $(this).hide();
                }else{
                    $(this).show();
                }
            });
        });
    });
    </script> -->
  
 
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
    <!-- <script type="text/javascript">
        $(document).ready(function() {
          $('#busTable').DataTable( {
              "pagingType": "full_numbers"
          } );

      } );

    </script> -->
    <script>
      $(document).ready(function() {
    // Setup - add a text input to each footer cell
        $('#busTable tfoot th').each( function () {
            var title = $('#busTable thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
      
        // DataTable
        var table = $('#busTable').DataTable( {
            colReorder: true
        } );
          
        // Apply the filter
        $("#busTable tfoot input").on( 'keyup change', function () {
            table
                .column( $(this).parent().index()+':visible' )
                .search( this.value )
                .draw();
        } );
    } );
    </script>
    
    

  </body>
</html>
