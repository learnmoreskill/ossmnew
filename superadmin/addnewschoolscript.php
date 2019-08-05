<!DOCTYPE html>
<html>
<head>
	<title>Add new school</title>

<!-- Firebase App is always required and must be first -->
<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-app.js"></script>
<!-- Add additional services that you want to use -->
<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-database.js"></script>

<script src="js/hackster_firebase.js"></script>

<script type="text/javascript">
	
	function createFirebaseEntry(schoolName,dbName){

			var url = 'https://'+dbName+'.a1pathshala.com/manager/'

			var h3Msg = document.getElementById("h3Msg");
			var result = '';

			// Get a reference to the database service
      		var firebaseRef = firebase.database().ref().child('SchoolList');

			firebaseRef.child(schoolName).set(url,function(error) {
			    if (error) {
			      h3Msg.innerHTML = 'Error Failed to add in Firebase DB';
			    } else {
			      h3Msg.innerHTML = 'Successfully created entry in Firebase DB';
			    }
			  });
	} 
</script>

</head>
<body>

	<h3 id='h3Msg'></h3>

	<h4>

<?php 





if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['addNewSchool'])) {

	$schoolName = $_POST['schoolName'];
	$schoolAddress = $_POST['schoolAddress'];
	$dbName = $_POST['dbName'];
	$dbName = strtolower($dbName);

	$schoolNameWithAddress = $schoolName.", ".$schoolAddress;

	$schoolCode = strtoupper($_POST['schoolCode']);
	$principalEmail = $_POST['principalEmail'];
	$principalPassword = $_POST['principalPassword'];

	$schoolList = json_decode($_POST['schoolList'], true); 

	if (!empty($schoolName) && !empty($schoolAddress) && !empty($dbName)  && !empty($schoolCode)  && !empty($principalEmail)  && !empty($principalPassword)) {
		 
		
				$db_server = 'localhost';
			   	$db_username = 'hackster';
			   	$db_password = 'krishna$12345';
			   	$resultQ = '';
			   	$errMsg = '';
			   	$clearRoad = 1;



	   			$dbname = str_replace("manager", "", $dbName);
	   			$schoolfolder = $dbname;
	   			$dbname = $dbname.'db';

	   	//Check if database exist
	    $db = mysqli_connect($db_server,$db_username,$db_password);
	    if (mysqli_connect_errno()){
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  return;
		}

	    $checkdb = mysqli_query($db,"SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname' ");
	    $dbExists=mysqli_num_rows($checkdb);

	    if (!$dbExists) {

	    	// Check School code exist
		   	foreach ($schoolList as &$fullurl) {

		   		$fullurl = strtolower($fullurl);

				$parsedUrl = parse_url($fullurl);

				$host = explode('.', $parsedUrl['host']);

				$subdomainname = $host[0];

				$fianlsubdomain = str_replace("manager", "", $subdomainname);
			   	if(!empty($fianlsubdomain)){
			     	$finaldbname = $fianlsubdomain."db";

		   			$db_database = $finaldbname;

		   			// Create connection
		   			$db1 = mysqli_connect($db_server,$db_username,$db_password,$db_database);

		   			$result = mysqli_query($db1,"SELECT * FROM `schooldetails` WHERE `school_code` = '$schoolCode' ");

		   			if($result){

		   				$count=mysqli_num_rows($result);

			   			if($count>0){

			   				$value = mysqli_fetch_object($result);
			   				$errMsg .= 'Error: School Code Is Already Used In '.$value->school_name.'<br>';
			   				$clearRoad = 0;
			   			}else{
			   				//road clear
			   			}
		   			}else{
		   				$errMsg .= 'Error: School code dint check for '.$db_database.':-'.mysqli_error($db1).' <br>';
		   				$clearRoad = 0;
		   			}
		   			mysqli_close($db1);		     	
			   	}

			}



			//Create new db
			if ($clearRoad) {
			
				$sql = "CREATE DATABASE ".$dbname;

				if (mysqli_query($db,$sql)) {
				    $resultQ .= "Database ".$dbname." created successfully <br>";
					//Road clear
				} else {
				  	$clearRoad = 0;
				    $errMsg .= "Error creating database: ".mysqli_error($db) . " <br>";
				}
			}
			mysqli_close($db);


			// MAKE DIRECTORY AND FOLDER FOR NEW SCHOOL

			$uploadpath1 = '../uploads/'.$schoolfolder;
			$uploadpath2 = '../fee_management/schoolfile/'.$schoolfolder;


			function makeFolderAndFile($path){
				$content = 
				"<!DOCTYPE html>
				<html>
					<head>
						<title>403 Forbidden</title>
					</head>
					<body>
						<p>Directory access is forbidden.</p>

					</body>
				</html>";


				if (!file_exists($path)) {
					
					$oldmask = umask(0);
					if(mkdir($path, 0777, true)){



						$fp = fopen($path.'/index.html', 'w');
						fwrite($fp, $content);
						fclose($fp);
						chmod($path.'/index.html', 0777);

						umask($oldmask);

					}else{
						return "Error : ".$path." Creating folder.<br>";
					}

					return "Success : ".$path." Folder created successfully. <br>";


			    }else{
			    	return "Error : ".$path." Folder name already exist. <br>";
			    }
			}

			function duplicate_db($db_server,$db_username,$db_password,$originalDB, $newDB) {

				$db = mysqli_connect($db_server,$db_username,$db_password);

				    $db_check = mysqli_select_db($db,$originalDB) or die ( mysqli_error($db)) ;
				     $getTables =  mysqli_query($db,"SHOW TABLES") or die ('Unable to execute query. '. mysqli_error($db)) ;
				     $originalDBs = [];
				     while($row = mysqli_fetch_row( $getTables )) {
				             $originalDBs[] = $row[0];
				        }

				     foreach( $originalDBs as $tab ) {
				             mysqli_select_db ($db, $newDB ) or die ('New database not found. '. mysqli_error($db));
				             mysqli_query($db,"CREATE TABLE $tab LIKE ".$originalDB.".".$tab) or die ('Sorry, '. mysqli_error($db));
				         mysqli_query($db,"INSERT INTO $tab SELECT * FROM ".$originalDB.".".$tab) or die ('Sorry, '. mysqli_error($db));
				     }

				mysqli_close($db);
				return "New Database Copied Successfully<br>";
			}


			if (!file_exists($uploadpath1)) {

						    	
				$resultQ .= makeFolderAndFile($uploadpath1);
				$resultQ .= makeFolderAndFile($uploadpath1.'/docs');
				$resultQ .= makeFolderAndFile($uploadpath1.'/elib');
				$resultQ .= makeFolderAndFile($uploadpath1.'/gallery');
				$resultQ .= makeFolderAndFile($uploadpath1.'/logo');
				$resultQ .= makeFolderAndFile($uploadpath1.'/profile_pic');
				$resultQ .= makeFolderAndFile($uploadpath1.'/slides');

				$resultQ .= makeFolderAndFile($uploadpath2);
				$resultQ .= makeFolderAndFile($uploadpath2.'/expenses_file');
			}else{
				$clearRoad = 0;
				$errMsg .= "Error School folder name already exist<br>";
			}


			if ($clearRoad) {

				echo duplicate_db($db_server,$db_username,$db_password,"schoolcopydb", $dbname);

					$dbnew = mysqli_connect($db_server,$db_username,$db_password,$dbname);

					include_once("queryfornewdbinsert.php");
					$queryForTableAndInsert = $queryForTableInsertion;


					if(mysqli_multi_query($dbnew,$queryForTableAndInsert)) {
		    				$resultQ .= 'admin credentials and school details added successfully <br>';

		   				  include_once("cloudflare.php");

		   				  $responseCloud = addCloudflareEntry($dbName);
		   				  $resultQ .= 'Cloud Flare: '.$responseCloud.' <br>';

		   				 echo "<script type='text/javascript'>createFirebaseEntry('$schoolNameWithAddress','$dbName'); </script>";

		   			}else{
		   				$errMsg .= 'Error: Failed to add admin and school details :-'.mysqli_error($dbnew).' <br>';

		   				if(mysqli_query($db,"DROP DATABASE $dbname")){

		   					$errMsg .=  "Removed newly created database <br>";
		   				}else{
		   					$errMsg .=  'Sorry, Unable to remove new db '. mysqli_error($db).'<br>';
		   				}
		   			}

		   				mysqli_close($dbnew);
			}


	    	
	    }else{	?> 
			<script> alert('Database already exist with same name'); window.location.href = 'addnewschool.php'; </script> 
			<?php
	 	}


		echo "<span style='color:red;' >".$errMsg."</span>";
		echo "<span style='color:green;' >".$resultQ."</span>";
		echo "<br><br><a href='addnewschool.php' >Go Back</a>";


	}else{
		?> <script> alert('Please fill all the fields'); window.location.href = 'addnewschool.php'; </script> <?php
	}

}else{ ?> <script>window.location.href = 'addnewschool.php'; </script> <?php }

?>
</h4>

</body>
</html>
