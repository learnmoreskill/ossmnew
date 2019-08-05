<?php
//for both admin and nsk
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'gupload';

$uploader=$login_session2;

if($_SERVER['REQUEST_METHOD']=='POST') {
if(isset($_POST['upload_file'])) {
  if($_POST['action']=="upload") {

  $title = $_POST['filename'];
  $desc = $_POST['textarea1'];

  
  $uFile = $_FILES['file1']['name'];
  $tmp_dir = $_FILES['file1']['tmp_name'];
  $fileSize = $_FILES['file1']['size'];
  $fileType = $_FILES['file1']['type'];
  
  
  if(empty($uFile)){
   $errMSG = "Please Add Image.";
  }
  else 
  {
   $upload_dir = '../uploads/'.$fianlsubdomain.'/gallery/'; // upload directory
 
   $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION)); // get file extension
  
   // valid image extensions
   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
  
   // rename uploading image
   //$ufile = rand(1000,1000000).".".$fileExt;
   //$ufile = $fname.".".$fileExt;

   // Check if file already exists
   $target_file=$upload_dir.basename($_FILES["file1"]["name"]);
    if (file_exists($target_file)) {
        $errMSG="Image already exist";
    }else{

    // check image storage limit
    $sqlcheck = "SELECT * FROM `gallery`";
    $result2 = $db->query($sqlcheck);
    $rowCount = $result2->num_rows;
    if($rowCount > 99) {
      $errMSG="Sorry, Can't upload more than 100 image....";
    } else{
    
   // allow valid image file formats
   if(in_array($fileExt, $valid_extensions)){ 

    // Check file size '5MB'
    if($fileSize < 5000000)    {

     if(move_uploaded_file($tmp_dir,$upload_dir.$uFile)){


     }else{

     $errMSG="failed to upload";
    }

    }
    else{
     $errMSG = "Sorry, your file is too large.";
    }
   }
   else{
    $errMSG = "Sorry, only JPG, JPEG, PNG , GIF files are allowed.";  
   }
  }
}
}
  
  // if no error occured, continue ....
  if(!isset($errMSG))
  {
$insertimage = "INSERT INTO `gallery`(`title`, `imagename`, `file_location`, `desc`, `role`, `uploader`, `date`, `status` ) VALUES ('$title', '$uFile', '$upload_dir', '$desc', '$login_cat', '$login_session1', CURRENT_TIMESTAMP, 0)";
                  
                  if(mysqli_query($db, $insertimage)) {  
                  //echo inserted
                    $errMSG = "Image uploaded successfully";
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
    <script type="text/javascript">
      $('#textarea1').val('New Text');
  $('#textarea1').trigger('autoresize');
    </script>

    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Upload Event's Picture To Gallery</a></div>
                    </div>
                </div>
            </div>


            <div class="row">
                <form class="col s12" action="" method="post" enctype="multipart/form-data" >

                    <div class="row">
                        <div class="col s2 offset-m1">
                            <h6 style="padding-top: 15px">Title</h6>
                        </div>
                        <div class="input-field col s6">
                          <input name="filename" id="filename" type="text" class="validate" placeholder="Ex: Sarswati pooja picture" autofocus required>
                          <label for="filename">Title</label>
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
                            <h6 style="padding-top: 15px">Image</h6>
                        </div>
                        <div class="file-field input-field col s6">
                          <div class="btn">
                            <span>Select Image</span>
                            <input type="file" name="file1">
                          </div> 
                          <div class="file-path-wrapper">
                            <input class="file-path validate" placeholder="file type JPG, JPEG, PNG & GIF files are allowed." type="text">
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col s2 offset-m1">
                            <h6 style="padding-top: 15px">Description</h6>
                      </div>
                      <div class="input-field col s6">
                        <textarea id="textarea1" name="textarea1" class="materialize-textarea"></textarea>
                        <label for="textarea1">Image or Event Details</label>
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
