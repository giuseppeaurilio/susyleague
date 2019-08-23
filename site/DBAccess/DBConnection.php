<?php
include("../dbinfo_susyleague.inc.php");
class Connection
{
    private $conn;
    private function connect(){
        if($this->$conn == null || ($this->$conn == false)){
            $this->$conn = new mysqli($localhost, $username, $password,$database);
            // Check connection
            if ($this->$conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        }
    }


    public function ExecuteQuery($query)
    {
         $this->connect();
         return $this->$conn->query($query);

    }
}
?>