<?php
$host     = "localhost";
$user     = "user12973";
$password = "Cl@Us@12";
$database = "clinic12";
$conn   = mysqli_connect($host, $user, $password, $database);
if (mysqli_connect_errno($conn)) {
   
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}		

$sql = 'SELECT * from tbl_users where is_logged = 1';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		// echo "Name: " . $row["username"]. "<br>";
	    $username = $row['name'];
		$userid = $row['userId'];				
		$sql = "INSERT INTO `tbl_log`(`userName`, `userId` ,`process` ) VALUES ('".$username."', '".$userid."', 'logout')";
		echo $resulttt = mysqli_query($conn, $sql);							

	}
} else {
	// echo "0 results";
}

$sql = "UPDATE tbl_users SET is_logged = 0 WHERE is_logged = 1";
if (mysqli_query($conn, $sql)) {
	echo "New record created successfully";
 } else {
	echo "Error: " . $sql . "" . mysqli_error($mysqli);
 }
$conn->close();
            
?>