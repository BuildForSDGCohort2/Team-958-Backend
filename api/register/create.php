<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
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

  $register->email = $data->email;
  $register->firstName = $data->firstName;
  $register->lastName = $data->lastName;
  $register->shopName = $data->shopName;
  $register->county = $data->county;
  $register->location = $data->location;
  $register->createdAt = $data->createdAt;

  // Create register
  if($register->create()) {
    echo json_encode(
      array('message' => 'Registration Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Registrattion Not Created')
    );
  }

