<?php include('session.php'); ?>
<html>
<head>
	<title>Library Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" href="css/bootstrap.min.css" >
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href="css/style-responsive.css" rel="stylesheet"/>
	<link rel="stylesheet" href="css/font.css" type="text/css"/>
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<link rel="stylesheet" href="css/morris.css" type="text/css"/>
	<script src="js/jquery2.0.3.min.js"></script>
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/jquery.slimscroll.js"></script>
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/jquery.scrollTo.js"></script>


<link  href="css/datatables.min.css" rel='stylesheet' type='text/css' />
<script src="js/datatables.min.js"></script>
<script src="js/dataTables.buttons.js"></script>
<script src="js/dataTables.buttons.min.js
"></script>


</head>
<body>
<section id="container">
<header class="header fixed-top clearfix">
	<div class="brand">
    <a href="index.php" class="logo">
        MENU
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
	</div>
    

	<div class="top-nav clearfix">
	    
	</div>
</header>
<aside>
		<div id="sidebar" class="nav-collapse">
		    <div class="leftside-navigation">
		        <ul class="sidebar-menu" id="nav-accordion">
		        	<?php if (isset($_SESSION['login_user_admin'])) { ?>
		        		<li>
		                <a href='../admin/welcome.php'>
		                    <i class="fa fa-user"></i>
		                    <span>Admin home</span>
		                </a>
		            </li>
		        	<?php }else {} ?>
		            <li>
		                <a href='index.php'>
		                    <i class="fa fa-dashboard"></i>
		                    <span>Library</span>
		                </a>
		            </li>
		            
		            <li>
		                    <a href="index.php">
		                        <i class="fa fa-user"></i>
		                        <span>Book Details</span>
		                    </a>
		            </li>
		            <li >
		                    <a href="insert_student_book_details.php">
		                        <i class="fa fa-user"></i>
		                        <span>Issue Book</span>
		                    </a>
		            </li>
		            <li class='active'>
		                    <a href="return_student_book_details.php">
		                        <i class="fa fa-user"></i>
		                        <span>Return Book</span>
		                    </a>
		            </li>
		            <?php if (isset($_SESSION['login_user_admin'])) { } elseif (isset($_SESSION['login_user_librarian'])) { ?>
		            	<li>
		                    <a href="logout.php">
		                        <i class="fa fa-user"></i>
		                        <span>Logout</span>
		                    </a>
		            	</li>		        		
		        	<?php }else {} ?>
		        </ul>            
		    </div>
		</div>
</aside>

<section id="main-content">
	<section class="wrapper">
		<div class="col-md-4" id='insert_exam_type_details'>
			<div class='form-w3layouts'>
			<div class="row">
			    <div class="col-lg-12">
				    <section class="panel">
					    <header class="panel-heading" style='font-size:17px;'>
					      Return Book
					    </header>
					    <div class="panel-body">
		
				<form id='form' name='submitBookRecordForm'>
					<div class='form-group'>
						<label>Student ID </label>
							<input class='form-control' type="text" name="returnbook_studentId">
					</div>
					<div class='form-group'>
						<label>Book ID</label>
						<input class='form-control' type="text" name="returnbook_bookStockId">
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
<script>
	$('#load_book_list_details').load('return_student_book_record.php');

	
</script>
<script>
$(document).ready(function (e) 
{
	$("#form").on('submit',(function(e) 
	{ 
		e.preventDefault();
		$.ajax
		({
			    url: "upload_book_details.php",
			    type: "POST",
			    data:  new FormData(this),
			    contentType: false,
			    cache: false,
			    processData:false,
			    beforeSend : function()
			   	{
			    	$("#err").fadeOut();
			    },
			    success: function(data)
			    {
			    	alert(data);
			    	if(data=='Insert Return Book Record Sucessfully !!')
			    	{
			    		window.location.href = 'return_student_book_details.php';
			    	}
			    	
			    },
			    error: function(e) 
			    {
			    	$("#err").html(e).fadeIn();
			    }          
		});
	}));
});

</script>

</body>
</html>
