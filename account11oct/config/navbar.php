<aside>
    <div id="sidebar" class="nav-collapse">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
               <p class="centered"><a href="../index.php"><img src="../uploads/logo/<?php echo $school_details->slogo; ?>" class="img-circle" width="60"></a></p>
                  <h5 class="centered">
                  <!-- Marcel Newman -->
                </h5>
              <?php if(isset($_SESSION['login_user_admin'])){ ?>
                <li><a  href="/admin/welcome.php" >Admin Home</a></li>
                <?php } ?>
                <li>
                    <a href="../index.php">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- manish -->
                <li class="sub-menu ">
                    <a href="javascript:;" class="dcjq-parent">
                        <i class="fa fa-users-cog"></i>
                        <span>Generate</span>
                    </a>
                    <ul class="sub">
                        <li><a href="../school/view_bill_record.php">Student bill</a></li>
                        <li><a href="../teacher/generate_teacher_statement.php">Teacher Salary Statement</a></li>
                        <li><a href="../student/generate_student_statement.php">Student Payment Statement</a></li>
                        <li><a href="../student/generate_student_statement.php">Student Recept By</a></li>
                        <li><a href="../school/today_report.php">Day Book</a></li>
                        <li><a href="../school/balance-sheet.php">Balance Sheet</a></li>
                        <li><a href="../expenses/expenses-details.php">Expenses Details</a></li>
                    </ul>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-book"></i>
                        <span>Expenses</span>
                    </a>
                    <ul class="sub">
                        <li><a href="../expenses/expenses-category.php">Category</a></li>
                        <li><a href="../expenses/expenses-details.php">Expenses</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-hand-holding-usd"></i>
                        <span>Extra-Income</span>
                    </a>
                    <ul class="sub">
                        <li ><a href="../extraIncome/income_details.php">Income</a></li>
                        
                    </ul>
                </li>
                
                <li class="sub-menu" >
                    <a href="javascript:;">
                        <i class="fa fa-user-graduate"></i>
                        <span>Student</span>
                    </a>
                    <ul class="sub">
                        <li ><a href="../student/fee-type.php">Fee Type</a></li>
                        <li><a href="../student/extra-fee-collection.php">Extra Fee</a></li>
                        <li><a href="../student/student-record.php">Fee Collection</a></li>
                    </ul>
                </li>
                <li class="sub-menu ">
                    <a href="javascript:;">
                        <i class="fa fa-chalkboard-teacher"></i>
                        <span>Teacher</span>
                    </a>
                    <ul class="sub">
                        <li><a href="../teacher/payment.php">Payment</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="../export_tables.php">
                        <i class="fa fa-cubes"></i>
                        <span>Export Tables</span>
                    </a>
                </li>
                <li>
                    <a href="../bus.php">
                        <i class="fa fa-bus"></i>
                        <span>Bus Info</span>
                    </a>
                </li>
            </br>
            </br>
            </br>
            </br>

                <!-- end -->
                <?php if(isset($_SESSION['login_user_admin'])){  }
                elseif (isset($_SESSION['login_user_accountant'])) { ?>
                <li><a  href="../logout.php">Logout</a></li>
                 <?php } else{} ?>
              
               </ul>
           </div>
     
</aside>

<?php include('../modelprint.php'); ?>