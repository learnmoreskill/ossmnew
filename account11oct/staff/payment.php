<?php
require('../head.php');
?>

<?php include('../config/navbar.php'); ?>


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
