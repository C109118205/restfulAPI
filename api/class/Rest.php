<?php
class Rest{
    private $host  = 'mbeutwen.ddns.net';
    private $user  = 'test01';
    private $password   = "minsen200110";
    private $database  = "plsys";      
    private $empTable = 'emp';	
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
				echo("connect OK!!!");
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function getEmployee($empId) {		
		$sqlQuery = '';
		if($empId) {
			$sqlQuery = "WHERE id = '".$empId."'";
		}	
		$empQuery = "
			SELECT id, name, skills, address, age 
			FROM ".$this->empTable." $sqlQuery
			ORDER BY id DESC";	
		$resultData = mysqli_query($this->dbConnect, $empQuery);
		$empData = array();
		while( $empRecord = mysqli_fetch_assoc($resultData) ) {
			$empData[] = $empRecord;
		}
		header('Content-Type: application/json');
		echo json_encode($empData);	
	}
	function insertEmployee($empData){ 	
		$data = json_decode($empData);
		$empName=$data->empName;
		$empAge=$data->empAge;
		$empSkills=$data->empSkills;
		$empAddress=$data->empAddress;	
		$empDesignation=$data->empDesignation;
		
		$empQuery="
			INSERT INTO ".$this->empTable." 
			SET  name='".$empName."', age='".$empAge."', skills='".$empSkills."', address='".$empAddress."', designation='".$empDesignation."'";
		if( mysqli_query($this->dbConnect, $empQuery)) {
			$messgae = "Employee created Successfully.";
			$status = 1;			
		} else {
			$messgae = "Employee creation failed.";
			$status = 0;				
			echo($empQuery);

		}
		$empResponse = array(
			'status' => $status,
			'status_message' => $messgae

		);
		header('Content-Type: application/json');
		echo json_encode($empResponse);
	}
	function updateEmployee($empData){ 		
		$data = json_decode($empData);
		//$id = $data->id;
		if($data->empId) {
		$empName=$data->empName;
		$empAge=$data->empAge;
		$empSkills=$data->empSkills;
		$empAddress=$data->empAddress;	
		$empDesignation=$data->empDesignation;
			
			$empQuery="
				UPDATE ".$this->empTable." 
				SET name='".$empName."', age='".$empAge."', skills='".$empSkills."', address='".$empAddress."', designation='".$empDesignation."' 
				WHERE id = '".$data->empId."'";
				echo $empQuery;
			if( mysqli_query($this->dbConnect, $empQuery)) {
				$messgae = "Employee updated successfully.";
				$status = 1;			
			} else {
				$messgae = "Employee update failed.";
				$status = 0;
			}
		} else {
			$messgae = "Invalid request.";
			$status = 0;

		}
		$empResponse = array(
			'status' => $status,
			'status_message' => $messgae
		);
		header('Content-Type: application/json');
		echo json_encode($empResponse);
	}
	public function deleteEmployee($empId) {		
		if($empId) {			
			$empQuery = "
				DELETE FROM ".$this->empTable." 
				WHERE id = '".$empId."'	ORDER BY id DESC";	
			if( mysqli_query($this->dbConnect, $empQuery)) {
				$messgae = "Employee delete Successfully.";
				$status = 1;			
			} else {
				$messgae = "Employee delete failed.";
				$status = 0;			
			}		
		} else {
			$messgae = "Invalid request.";
			$status = 0;
		}
		$empResponse = array(
			'status' => $status,
			'status_message' => $messgae
		);
		header('Content-Type: application/json');
		echo json_encode($empResponse);	
	}
}
?>