<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Register.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate register object
  $register = new Register($db);

  // Get raw registered data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $register->id = $data->id;

  // Delete register
  if($register->delete()) {
    echo json_encode(
      array('message' => 'Registration Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Registration Not Deleted')
    );
  }

