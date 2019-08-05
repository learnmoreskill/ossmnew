<?php
//for admin and nsk
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'eupload';

$uploader=$login_session2;

if($_SERVER['REQUEST_METHOD']=='POST') {
if(isset($_POST['upload_file'])) {
  if($_POST['action']=="upload") {

  $fname = $_POST['filename'];
    
  
  $uFile = $_FILES['file1']['name'];
  $tmp_dir = $_FILES['file1']['tmp_name'];
  $fileSize = $_FILES['file1']['size'];
  $fileType = $_FILES['file1']['type'];
  
  
  if(empty($uFile)){
   $errMSG = "Please add file.";
  }
  else 
  {
   $upload_dir = '../uploads/'.$fianlsubdomain.'/elib/'; // upload directory
 
   $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION)); // get file extension
  
   // valid image extensions
   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif','docx','pdf','xml','txt'); // valid extensions
  
   // rename uploading image
   //$ufile = rand(1000,1000000).".".$fileExt;
   $ufile = $fname.".".$fileExt;

   // Check if file already exists
   $target_file=$upload_dir.$ufile;
    if (file_exists($target_file)) {
        $errMSG="File name already exist";
    }else{
    
   // allow valid image file formats
   if(in_array($fileExt, $valid_extensions)){ 

    // Check file size '10MB'
    if($fileSize < 10485760)    {

     if(move_uploaded_file($tmp_dir,$upload_dir.$ufile)){


     }else{

     $errMSG="failed to upload";
    }

    }
    else{
     $errMSG = "Sorry, your file is too large.";
    }
   }
   else{
    $errMSG = "Sorry, only JPG, JPEG, PNG , GIF , DOCX , PDF ,XML and TXT files are allowed.";  
   }
}
}
  
  
  // if no error occured, continue ....
  if(!isset($errMSG))
  {
$insertimage = "INSERT INTO `elibrary`(`filename`,  `file_location`, `size`, `type`, `role`, `uploader`, `date`, `status`) VALUES ('$ufile', '$upload_dir', '$fileSize', '$fileType', '$login_cat', '$login_session1', CURRENT_TIMESTAMP, 0 )";
                  
                  if(mysqli_query($db, $insertimage)) {  
                  //echo inserted
                    $errMSG = "uploaded successfully";
   }
   else
   {
    $errMSG = "error while inserting....";
   }
  }
  $_SESSION['toastmsg'] = $errMSG;
  header("Refresh:3");
 }
}
}
 ?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Upload</a></div>
                    </div>
                </div>
            </div>


            <div class="row">
                <form class="col s12" action="" method="post" enctype="multipart/form-data" >

                    <div class="row">
                        <div class="col s2 offset-m1">
                            <h6 style="padding-top: 15px">File Name</h6>
                        </div>
                        <div class="input-field col s6">
                          <input name="filename" id="filename" type="text" class="validate" placeholder="Ex: science notes for class 5" autofocus required>
                          <label for="filename">File Name</label>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col s2 offset-m1">
                            <h6 style="padding-top: 15px">Upload By</h6>
                        </div>
                        <div class="input-field col s6">
                          <input name="uploadername" id="uploadername" type="text" value="<?php echo $uploader; ?>" class="validate" required disabled >
                          <label for="uploadername">Upload by</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s2 offset-m1">
                            <h6 style="padding-top: 15px">File</h6>
                        </div>
                        <div class="file-field input-field col s6">
                          <div class="btn">
                            <span>Select File</span>
                            <input type="file" name="file1">
                          </div> 
                          <div class="file-path-wrapper">
                            <input class="file-path validate" placeholder="PDF, DOCX, XML, TXT, JPG, JPEG, PNG & GIF files only" type="text">
                          </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="input-field col offset-m7">
                            <input type="hidden" name="action" value="upload">
                             <button class="btn waves-effect waves-light" type="submit" name="upload_file">Upload
                                <i class="material-icons right">send</i>
                              </button>
                        </div>

                    </div>

                </form>
            </div>
        </main>

<?php include_once("../config/footer.php");?>

<?php
if(isset($_SESSION['toastmsg'])){      
  $status2=$errMSG;
  echo "<script>Materialize.toast('$status2', 3000, 'rounded');</script>";
  unset($_SESSION['toastmsg']);
}
?>
