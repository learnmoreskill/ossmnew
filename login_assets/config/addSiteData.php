<?php 
require ('../config/config.php'); 

$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $website = test_input($_POST["website"]);
  $comment = test_input($_POST["comment"]);
  $gender = test_input($_POST["gender"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// $sql = "INSERT INTO school (name)
// VALUES ('guddu')";

// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

$sql = "SELECT * FROM school";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
	{
	    $data='';
	    while($row = $result->fetch_assoc()) {
	    	$data .= '{"id":"' . $row['id'].'","name": "' . $row['name'].'"},';
	    }
	    $data=rtrim($data,", ");
	    $data='['.$data.']';
	    echo $data;
	} 
	else 
	{
	    echo "0 results";
	}
$conn->close();
?>