<?php 
class Preclass
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();

    }
    // public function checkreq($value='')
    // {
    //     $host     = "localhost";
	// 	$user     = "root";
	// 	$password = "";
	// 	$database = "cias2";
	// 	$conn   = mysqli_connect($host, $user, $password, $database);
	// 	if (mysqli_connect_errno($conn)) {
		   
	// 	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// 	}		
		
	// 	$sql = 'SELECT * from tbl_users';
	// 	$result = mysqli_query($conn, $sql);

	// 	if (mysqli_num_rows($result) > 0) {
	// 		while($row = mysqli_fetch_assoc($result)) {
	// 			echo "Name: " . $row["name"]. "<br>";
	// 		}
	// 	} else {
	// 		// echo "0 results";
	// 	}
	// 	$conn->close();

    //     var_dump($this->CI->session->userdata);
    //     // $this->CI->session->sess_destroy ();
    //     // die;
    // }
}
?>