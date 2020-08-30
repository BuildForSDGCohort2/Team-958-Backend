<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Register.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog register object
  $register = new Register($db);

  //Register query
  $result = $register->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any registers
  if($num > 0) {
    // Register array
    $registers_arr = array();
    //$registers_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $register_item = array(
        'id' => $id,
        'email' => $email,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'shopName' => $shopName,
        'county' => $county,
        'location' => $location,
        'createdAt' => $createdAt
      );

      // Push to "data"
      array_push($registers_arr, $register_item);
      //array_push($registers_arr['data'], $register_item);
    }

    // Turn to JSON & output
    echo json_encode($registers_arr);

  } else {
    // No Registers
    echo json_encode(
      array('message' => 'No Registrations Found')
    );
  }