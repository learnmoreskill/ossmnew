<aside>
    <div id="sidebar" class="nav-collapse">
              <!-- sidebar menu start1-->
              <ul class="sidebar-menu" id="nav-accordion">
               <p class="centered"><a href="../index.php"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" class="img-circle" width="60"></a></p>
                  <h5 class="centered">
                  <!-- Marcel Newman -->
                </h5>
                <li>
                    <span style="cursor: pointer;color: #fff"  data-toggle="modal" data-target="#modal_change_current_session"><?php echo $lang['current_session']; ?> : <?php  echo $current_year_session;   ?>
                    </span>
                </li>

              <!-- <?php if(isset($_SESSION['login_user_admin'])){ ?>
                <li><a  href="../../admin/welcome.php" >Admin Home</a></li>
                <?php } ?> -->

                <li><a  href="../../admin/welcome.php" >Admin Home</a></li>
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
                        <li><a href="../school/student_due.php">Student due ledger</a></li>
                        <!-- <li><a href="../school/view_bill_record.php">Student bill</a></li> -->
                        <!-- <li><a href="../teacher/generate_teacher_statement.php">Teacher Salary Statement</a></li> -->
                        <!-- <li><a href="../student/generate_student_statement.php">Student Payment Statement</a></li> -->
                        <!-- <li><a href="../student/generate_student_statement.php">Student Recept By</a></li> -->
                        <!-- <li><a href="../school/today_report.php">Day Book</a></li> -->
                        <!-- <li><a href="../school/balance-sheet.php">Balance Sheet</a></li> -->
                        <!-- <li><a href="../expenses/expenses-details.php">Expenses Details</a></li> -->
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
                
                <!-- <li>
                    <a href="../school/export_tables.php">
                        <i class="fa fa-cubes"></i>
                        <span>Export Tables</span>
                    </a>
                </li>
                <li>
                    <a href="../bus.php">
                        <i class="fa fa-bus"></i>
                        <span>Bus Info</span>
                    </a>
                </li> -->
                <li><a  href="../logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </br>
            </br>
            </br>
            </br>

                <!-- end -->
                
                
                 
              
               </ul>
           </div>


           <!-- model -->
        <div id="modal_change_current_session" class="modal fade" role="dialog">
            <?php
                $academic_year_for_session = $db->query("SELECT * FROM `academic_year` WHERE `status`=0 ORDER BY `single_year`");
            ?>
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Session</h4>
                    </div>
                    <form id="update_current_session_year_form" >
                        <div class="modal-body">

                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                  <label>Select year</label>
                                  <select name="selected_session_year_id" class="form-control">
                                    <option value="" disabled>Select year</option>
                                  <?php if ($academic_year_for_session->num_rows > 0) {
                                        while($row_y_s_list = $academic_year_for_session->fetch_assoc()) { ?>
                                            <option value="<?php echo $row_y_s_list['id'];?>"
                                                <?php echo (($row_y_s_list['id']==$current_year_session_id)?'selected="selected"':''); ?>
                                                ><?php echo $row_y_s_list['year']; ?></option>

                                            <?php
                                        }
                                    } ?>
                                  </select>
                                </div>
                            </div>
                            

                            <input type="hidden" name="update_current_session_year" value="update_current_session_year" >
                            <div class="modal-footer">
                                <button type="button"  class="btn btn-success" data-dismiss="modal" >Close</button>
                                <input type="submit" class="btn btn-success" name="submit" value="save">
                            </div>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
     
</aside>

<?php include('../modelprint.php'); ?>