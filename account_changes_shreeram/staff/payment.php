<?php
require('../head.php');
?>

<aside>
    <div id="sidebar" class="nav-collapse">
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="../index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Expenses</span>
                    </a>
                    <ul class="sub">
                        <li><a href="../expenses/expenses-category.php">Category</a></li>
                        <li><a href="../expenses/expenses-details.php">Expenses</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Extra-Income</span>
                    </a>
                    <ul class="sub">
                        <li ><a href="../extraIncome/income_details.php">Income</a></li>
                        
                    </ul>
                </li>
                
                <li class="sub-menu " >
                    <a href="javascript:;" >
                        <i class="fa fa-th"></i>
                        <span>Student</span>
                    </a>
                    <ul class="sub dcjq-parent-li">
                        <li><a href="../student/fee-type.php">Fee Type</a></li>
                        <li class="active"><a href="../student/extra-fee-collection.php">Extra Fee</a></li>
                        <li><a href="../student/student-record.php">Fee Collection</a></li>
                    </ul>
                </li>
                <li class="sub-menu ">
                    <a href="javascript:;">
                        <i class="fa fa-tasks"></i>
                        <span>Teacher</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="../teacher/payment.php">Payment</a></li>
                    </ul>
                </li>
                <li class="sub-menu dcjq-parent-li">
                    <a href="javascript:;" class="dcjq-parent active">
                        <i class="fa fa-envelope"></i>
                        <span>Staff</span>
                    </a>
                    <ul class="sub dcjq-parent-li">
                        <li class="active"><a href="../staff/payment.php">Payment</a></li>
                    </ul>
                </li>
               
</aside>

    <section id="main-content">
        <section class="wrapper">
             <div class="col-md-4" id='insert_exam_type_details'>
            <div class='form-w3layouts'>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" style='font-size:17px;'>
                          Insert Fee Type
                        </header>
                        <div class="panel-body">
        
                            <form id='form' name='submitBookRecordForm'>
                                <div class='form-group'>
                                    <label>Fee Type </label>
                                        <input class='form-control' type="text" name="studentId">
                                </div>
                                
                                <div class="form-group">
                                    <input style='margin-bottom: 20px;width:100px;' readonly="true" class='btn btn-primary pull-right' type="submit"  value="Submit" />
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            </div>
            </div>

            <div class="col-md-8" id='load_book_list_details'>
                
            </div>
           
        </section>
    </section>

</section>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../js/scripts.js"></script>
<script src="../js/jquery.slimscroll.js"></script>
<script src="../js/jquery.nicescroll.js"></script>
<script src="../js/jquery.scrollTo.js"></script>

</body>
</html>
