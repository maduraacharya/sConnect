<?php
class MySQLDatabase
{
    // property declaration
    private $db_host;
    private $db_user; 
    private $db_password; 
    private $db_instance;

    // constructor declaration
    public function __construct () {
        $this->db_host = "localhost";
        $this->db_user = "sconnect";
        $this->db_password = "sconnect";
        $this->db_instance = "sconnect";
    }

	public function dbConnect() {
		$ch = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_instance);
		if (!$ch) {
			die('DB Error: ' . mysqli_connect_errno() . " " . mysqli_connect_error());
		}
		return $ch;
     }
}
?>
