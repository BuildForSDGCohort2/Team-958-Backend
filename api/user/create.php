<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate register object
  $register = new User($db);

  // Get raw registered data
  $data = json_decode(file_get_contents("php://input"));

  $register->email = $data->email;
  $register->firstName = $data->firstName;
  $register->lastName = $data->lastName;
  $register->password = sha1($data->password);
  $register->registerId = $data->registerId;
  $register->active = $data->active;
  $register->createdAt = $data->createdAt;

  // Create register
  if($register->create()) {
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Registrattion Not Created')
    );
  }

