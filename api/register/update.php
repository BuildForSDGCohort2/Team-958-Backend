<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
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

  $register->email = $data->email;
  $register->firstName = $data->firstName;
  $register->lastName = $data->lastName;
  $register->shopName = $data->shopName;
  $register->county = $data->county;
  $register->location = $data->location;
  $register->createdAt = $data->createdAt;

  // Update register
  if($register->update()) {
    echo json_encode(
      array('message' => 'Registration Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Registration Not Updated')
    );
  }

