<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Api');
		$this->load->helper('jwt_helper');

		// $this->load->model('Api');
	}

	// public function get_records (){
	// 	// list all records (Read)
	// 	$students = $this->Api->get_all();
	// 	// echo json_encode(array('request_method'=> $_SERVER['REQUEST_METHOD']));
	// 	echo json_encode($students);
	// }

	// public function create_record(){
	// 	$_POST = json_decode(file_get_contents('php://input'), true);
	// 	// print_r($_POST);
		
	// 	$name = $_POST['name'];
	// 	$dob = $_POST['dob'];
	// 	$contact = $_POST['contact'];

	// 	$values = array(
	// 		'name' => $name,
	// 		'dob' => $dob,
	// 		'contact' => $contact
	// 	);

	// 	$inserted_id = $this->Api->insert_record('students', $values);
	// 	if ($inserted_id){
	// 		http_response_code(201);
	// 		echo json_encode(
	// 			array(
	// 				"status"=> "success", 
	// 				"message"=> "Record Created Successfully!",
	// 				"inserted_id"=> $inserted_id
	// 			));
	// 	}
	// 	else{
	// 		http_response_code(400);
	// 		echo json_encode(
	// 			array(
	// 				"status"=> "error", 
	// 				"message"=> "Something went wrong!",
	// 			));
	// 	}
	// }

	// public function delete_record($id){
	// 	// check id
	// 	$where_condition = array('id'=> $id);
	// 	$students_arr = $this->Api->check_for_field('students', $where_condition);

	// 	if($students_arr){
	// 		$affected_rows = $this->Api->delete_record('students', $id);
	// 		http_response_code(204);
	// 		echo json_encode(array(
	// 			"status"=> "success", 
	// 			"message"=> "Record Deleted Successfully!",
	// 			"affected_rows"=> $affected_rows
	// 		));
	// 	} else {
	// 		http_response_code(404);
	// 		echo json_encode(array(
	// 			"status"=> "error", 
	// 			"message"=> "Id not found!"
	// 		));
	// 	}

	// }


	// public function update_complete_record($id){
	// 	// put
	// 	$_POST = json_decode(file_get_contents('php://input'), true);
	// 	// print_r($_POST);
		
	// 	$name = $_POST['name'];
	// 	$dob = $_POST['dob'];
	// 	$contact = $_POST['contact'];

	// 	$values = array(
	// 		'name' => $name,
	// 		'dob' => $dob,
	// 		'contact' => $contact
	// 	);
	// 	$affected_rows = $this->Api->update_record('students', $id, $values);
	// 	echo json_encode(
	// 		array(
	// 			"status"=> "success", 
	// 			"message"=> "Record Updated Successfully!",
	// 			"affected_rows"=> $affected_rows
	// 		));
		
	// }


	// public function update_partial_record($id){
	// 	// patch
	// 	$_POST = json_decode(file_get_contents('php://input'), true);
	// 	// print_r($_POST);
	// 	$values = array();
	// 	if(isset($_POST['dob'])) {
	// 		$values['dob'] = $_POST['dob'];
	// 	}
	// 	if(isset($_POST['name'])) {
	// 		$values['name'] = $_POST['name'];
	// 	}
	// 	if(isset($_POST['contact'])) {
	// 		$values['contact'] = $_POST['contact'];
	// 	}
	// 	$affected_rows = $this->Api->update_record('students', $id, $values);
	// 	echo json_encode(
	// 		array(
	// 			"status"=> "success", 
	// 			"message"=> "Record Updated Successfully!",
	// 			"affected_rows"=> $affected_rows
	// 		));
		
	// }

	public function get_record($id){
		$where_condition = array('id'=> $id);
		$students_arr = $this->Api->check_for_field('students', $where_condition);
		return $students_arr ? $students_arr[0] : null;
		// if($students_arr){
		// 	return $students_arr[0] : null;
		// } else{
		// 	return null;
		// }
		
	}

	public function login(){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$_POST = json_decode(file_get_contents('php://input'), true);
			// hello world -> helloworld
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			if(trim($email) !== '' && trim($password) !== ''){
				$students = $this->Api->check_for_field('students', array('email' => $email, 'password' => $password));
				if($students){
					$student = $students[0];
					// Creating jwt token for student

					$jwt = new JWT();
					$JwtSecretKey = "mysecretkey";
					date_default_timezone_set("Asia/Kolkata");
					$date = date('d/m/Y H:i:s', time());
					$data_arr = array();
					$data_arr['id'] = $student['id'];
					$data_arr['email'] = $student['email'];
					$data_arr['exp'] = time() + 3600; //valid up to 1 hour
					$token = $jwt->encode($data_arr, $JwtSecretKey, "HS256");

					echo json_encode(
						array(
							"status"=> "success", 
							"message"=> "OK",
							"token"=> $token,
							"data"=>$student
						));
					
				} else {
					// if $students value is empty array
					echo json_encode(
						array(
							"status"=> "error", 
							"message"=> "Invalid Credentials!",
						));
				}
			} else {
				http_response_code(400);
				echo json_encode(
					array(
						"status"=> "error", 
						"message"=> "Email and password is required!"
					));
			}
		} else { 
            echo json_encode(
                array(
                    "status"=> "error", 
                    "message"=> "Method Not Allow!"
                ));
		}
	}

	private function _verify_auth_token($token){
		$jwt = new JWT();
        $JwtSecretKey = "mysecretkey";
        $decoded = $jwt->decode($token, $JwtSecretKey, array('HS256'));
        if($decoded){
            return $decoded;
        } else {
            return false;
        }
	}

	public function auth(){
		$req_headers = $this->input->request_headers();
		if(array_key_exists('Authorization', $req_headers)){
			$token = trim(substr($req_headers['Authorization'], 6));
			$is_varified = $this->_verify_auth_token($token);
			if($is_varified){
				// print(time());
				// echo "<br>";
				// print($is_varified->exp);
				if($is_varified->exp > time()){
					return true;
				} else {
					// token expire
					return false;
				}
			} else {
				return false;
			}

		} else{
			return false;
		}
	}


	public function students($id=null){
		if($this->auth()){

			if($_SERVER['REQUEST_METHOD'] == "GET"){
				if($id == null){
					$students = $this->Api->get_all();
					echo json_encode(array(
						'status'=>'success',
						'message'=>'OK',
						'data'=>$students
					));
				} else {
					$student = $this->get_record($id);
					if($student){
						echo json_encode(array(
							'status'=>'success',
							'message'=>'OK',
							'data'=>$student
						));
					} else{
						http_response_code(404);
						echo json_encode(array(
							"status"=> "error", 
							"message"=> "Id not found!"
						));
					}
				}
			} else if($_SERVER['REQUEST_METHOD'] == "POST"){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// print_r($_POST);
				
				$name = $_POST['name'];
				$dob = $_POST['dob'];
				$contact = $_POST['contact'];
				$email = $_POST['email'];
				$password = $_POST['password'];

				$values = array(
					'name' => $name,
					'dob' => $dob,
					'contact' => $contact,
					'email' => $email,
					'password' => $password
				);

				$inserted_id = $this->Api->insert_record('students', $values);
				if ($inserted_id){
					http_response_code(201);
					echo json_encode(
						array(
							"status"=> "success", 
							"message"=> "Record Created Successfully!",
							"inserted_id"=> $inserted_id
						));
				}
				else{
					http_response_code(400);
					echo json_encode(
						array(
							"status"=> "error", 
							"message"=> "Something went wrong!",
						));
				}
			} else if($_SERVER['REQUEST_METHOD'] == "PUT"){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// print_r($_POST);
				
				$name = $_POST['name'];
				$dob = $_POST['dob'];
				$contact = $_POST['contact'];
				$email = $_POST['email'];
		
				$values = array(
					'name' => $name,
					'dob' => $dob,
					'contact' => $contact,
					'email'=> $email
				);
				$affected_rows = $this->Api->update_record('students', $id, $values);
				http_response_code(200);
				echo json_encode(
					array(
						"status"=> "success", 
						"message"=> "Record Updated Successfully!",
						"affected_rows"=> $affected_rows
					));
			} else if($_SERVER['REQUEST_METHOD'] == "PATCH"){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// print_r($_POST);
				$values = array();
				if(isset($_POST['dob'])) {
					$values['dob'] = $_POST['dob'];
				}
				if(isset($_POST['name'])) {
					$values['name'] = $_POST['name'];
				}
				if(isset($_POST['contact'])) {
					$values['contact'] = $_POST['contact'];
				}
				if(isset($_POST['email'])) {
					$values['email'] = $_POST['email'];
				}
				$affected_rows = $this->Api->update_record('students', $id, $values);
				echo json_encode(
					array(
						"status"=> "success", 
						"message"=> "Record Updated Successfully!",
						"affected_rows"=> $affected_rows
					));
			} else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
				// check id
				$student = $this->get_record($id);
				if($student){
					$affected_rows = $this->Api->delete_record('students', $id);
					// header("HTTP/1.1 204 No Content");
					echo json_encode(array(
						"status"=> "success", 
						"message"=> "Record Deleted Successfully!",
						"affected_rows"=> $affected_rows
					));
					// http_response_code(204);
				} else {
					http_response_code(404);
					echo json_encode(array(
						"status"=> "error", 
						"message"=> "Id not found!"
					));
				}
			} else {
				echo json_encode(
					array(
						"status"=> "error", 
						"message"=> "Method Not Allow!"
					));
			}

		} else { 
			http_response_code(401);
            echo json_encode(
                array(
                    "status"=> "error", 
                    "message"=> "Unauthorized!"
                ));
		}
	}

}
