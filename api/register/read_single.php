<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Register.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate register object
  $register = new Register($db);

  // Get ID
  $register->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get register
  $register->read_single();

  // Create array
  $register_arr = array(
    'id' => $register->id,
    'email' => $register->email,
    'firstName' => $register->firstName,
    'lastName' => $register->lastName,
    'shopName' => $register->shopName,
    'county' => $register->county,
    'location' => $register->location,
    'createdAt' => $register->createdAt

  );

  // Make JSON
  print_r(json_encode($register_arr));