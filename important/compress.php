<?php
class compress_class
{	

	function compress_image($file, $path , $imagename, $quality) {


              $uFile = $file['name'];
              $tmp_dir = $file['tmp_name'];
              $fileSize = $file['size'];
              $fileType = $file['type'];



              // valid image extensions
              $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
              // get file extension
              $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION));

              if(in_array($fileExt, $valid_extensions)){ 

                $photo = $imagename.".".$fileExt;
                $dest = $path.$photo;

              // Check file size '5MB'
              if($fileSize < 5000000){


                $info = getimagesize($tmp_dir);

                if ($info['mime'] == 'image/jpeg'){
                  $image = imagecreatefromjpeg($tmp_dir);
                }

               elseif ($info['mime'] == 'image/gif'){
                  $image = imagecreatefromgif($tmp_dir);
                }
               elseif ($info['mime'] == 'image/png'){
                $image = imagecreatefrompng($tmp_dir);
                }

                if (imagejpeg($image, $dest, $quality)) {
                  $out['code'] = 200;
                  $out['image'] = $photo;
                  return $out;
                }else{
                  $out['code'] = 201;
                  $out['message'] = "failed to upload picture";
                  return $out;
                }

              }else{  
                $out['code'] = 202;
                $out['message'] = "Sorry, picture size is more than 5 MB";
                return $out;
              }
             }else{ 
              $out['code'] = 202;
              $out['message'] = "Sorry, only JPG, JPEG, PNG , GIF files are allowed.";
              return $out;
             } 
              
  }

  function compress_image_update($file, $path , $imagename, $quality , $oldimage) {

              $errMsg = '';

              $uFile = $file['name'];
              $tmp_dir = $file['tmp_name'];
              $fileSize = $file['size'];
              $fileType = $file['type'];



              // valid image extensions
              $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
              // get file extension
              $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION));

              if(in_array($fileExt, $valid_extensions)){ 

                $photo = $imagename.".".$fileExt;
                $dest = $path.$photo;

              // Check file size '5MB'
              if($fileSize < 5000000){

                if ($oldimage) {
                  $oldimagepath = $path.$oldimage;

                  if (@getimagesize($oldimagepath)) {
                    if(!unlink($oldimagepath)){
                      $errMsg="Sorry,Failed to remove old image.";
                    }                        
                  }
                }

                if (empty($errMsg)) {

                  $info = getimagesize($tmp_dir);

                  if ($info['mime'] == 'image/jpeg'){
                    $image = imagecreatefromjpeg($tmp_dir);
                  }

                 elseif ($info['mime'] == 'image/gif'){
                    $image = imagecreatefromgif($tmp_dir);
                  }
                 elseif ($info['mime'] == 'image/png'){
                  $image = imagecreatefrompng($tmp_dir);
                  }

                  if (imagejpeg($image, $dest, $quality)) {
                    $out['code'] = 200;
                    $out['image'] = $photo;
                    return $out;
                  }else{
                    $out['code'] = 201;
                    $out['message'] = "failed to upload picture";
                    return $out;
                  }

                }else{
                  
                  $out['code'] = 201;
                  $out['message'] = $errMsg;
                  return $out;
                }

              }else{  
                $out['code'] = 202;
                $out['message'] = "Sorry, picture size is more than 5 MB";
                return $out;
              }
             }else{ 
              $out['code'] = 202;
              $out['message'] = "Sorry, only JPG, JPEG, PNG , GIF files are allowed.";
              return $out;
             } 
              
  }


  function upload_base64($file, $path , $imagename){

        $image_parts = explode(";base64,", $file);
        $image_type_aux = explode("image/", $image_parts[0]);
        $fileExt = $image_type_aux[1];

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

        $tmp_dir = base64_decode($image_parts[1]);

        $fileSize = (int)(strlen(rtrim($file,'='))*3/4);

        $photo = $imagename.".".$fileExt;
        $dest = $path.$photo;


        // allow valid image file formats
        if(in_array($fileExt, $valid_extensions)){ 

          // Check file size '5MB'
          if($fileSize < 2000000)    {

            if(file_put_contents($dest, $tmp_dir)){
              $out['code'] = 200;
              $out['image'] = $photo;
              return $out;
            }else{
              $out['code'] = 201;
              $out['message'] = "failed to upload picture";
              return $out;
            }

          }else{ 
            $out['code'] = 202;
            $out['message'] = "Sorry, picture size is more than 2 MB";
            return $out; 
          }

        }else{ 
          $out['code'] = 202;
          $out['message'] = "Sorry, only JPG, JPEG, PNG , GIF files are allowed.";
          return $out; 
        }
  }
  function upload_base64_update($file, $path , $imagename, $oldimage){

        $errMsg = '';

        if ($oldimage) {
          $oldimagepath = $path.$oldimage;

          if (@getimagesize($oldimagepath)) {
            if(!unlink($oldimagepath)){
              $errMsg="Sorry,Failed to remove old image.";
            }                        
          }
        }

        if (empty($errMsg)) {

        $image_parts = explode(";base64,", $file);
        $image_type_aux = explode("image/", $image_parts[0]);
        $fileExt = $image_type_aux[1];

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

        $tmp_dir = base64_decode($image_parts[1]);

        $fileSize = (int)(strlen(rtrim($file,'='))*3/4);

        $photo = $imagename.".".$fileExt;
        $dest = $path.$photo;


        // allow valid image file formats
        if(in_array($fileExt, $valid_extensions)){ 

          // Check file size '5MB'
          if($fileSize < 2000000)    {

            if(file_put_contents($dest, $tmp_dir)){
              $out['code'] = 200;
              $out['image'] = $photo;
              return $out;
            }else{
              $out['code'] = 201;
              $out['message'] = "failed to upload picture";
              return $out;
            }

          }else{ 
            $out['code'] = 202;
            $out['message'] = "Sorry, picture size is more than 2 MB";
            return $out; 
          }

        }else{ 
          $out['code'] = 202;
          $out['message'] = "Sorry, only JPG, JPEG, PNG , GIF files are allowed.";
          return $out; 
        }

        }else{
          $out['code'] = 201;
          $out['message'] = $errMsg;
          return $out;
        }
  }

}
?>