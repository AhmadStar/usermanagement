<?php 
class Preclass
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    public function checkreq($value='')
    {
		if(isset($this->CI->session->userdata["isLoggedIn"])){
			$host     = "localhost";
			$user     = "root";
			$password = "";
			$database = "monitor";
			$conn   = mysqli_connect($host, $user, $password, $database);
			if (mysqli_connect_errno($conn)) {
			
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			$userId = $this->CI->session->userdata('userId');
			$sql = 'SELECT is_logged from tbl_users where userId = '.$userId.'';
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					if(!$row["is_logged"])
						$this->CI->session->sess_destroy ();
				}
			} else {
				// echo "0 results";
			}
			$conn->close();
		}
    }
}
?>