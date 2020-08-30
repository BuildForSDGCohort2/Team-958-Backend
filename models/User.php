<?php 
  class User {
    // DB stuff
    private $conn;
    private $table = 'user';

    // User Properties
    public $id;
    public $email;
    public $firstName;
    public $lastName;
    public $registerId;
    public $password;
    public $active;
    public $createdAt;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Users
    public function read() {
      // Create query
      $query = 'SELECT id, email, firstName, lastName, registerId, password, active, createdAt 
                                FROM ' . $this->table . '                                 
                                ORDER BY
                                createdAt DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single User
    public function read_single() {
          // Create query
          $query = 'SELECT id, email, firstName, lastName, registerId, password, active, createdAt 
                                FROM ' . $this->table . '  
                                    WHERE
                                      id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->email = $row['email'];
          $this->firstName = $row['firstName'];
          $this->lastName = $row['lastName'];
          $this->registerId = $row['registerId'];
          $this->password = $row['password'];
          $this->active = $row['active'];
          $this->createdAt = $row['createdAt'];
    }

    // Create User
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET email = :email, firstName = :firstName, lastName = :lastName, registerId = :registerId,
          password = :password, active = :active';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->firstName = htmlspecialchars(strip_tags($this->firstName));
          $this->lastName = htmlspecialchars(strip_tags($this->lastName));
          $this->registerId = htmlspecialchars(strip_tags($this->registerId));
          $this->password = htmlspecialchars(strip_tags($this->password));
          $this->active = htmlspecialchars(strip_tags($this->active));
          
          // Bind data
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':firstName', $this->firstName);
          $stmt->bindParam(':lastName', $this->lastName);
          $stmt->bindParam(':registerId', $this->registerId);
          $stmt->bindParam(':password', $this->password);
          $stmt->bindParam(':active', $this->active);
          
          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update User
    public function update() {      
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET email = :email, firstName = :firstName, lastName = :lastName, registerId = :registerId,
                                password = :password, active = :active
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->firstName = htmlspecialchars(strip_tags($this->firstName));
          $this->lastName = htmlspecialchars(strip_tags($this->lastName));
          $this->registerId = htmlspecialchars(strip_tags($this->registerId));
          $this->password = htmlspecialchars(strip_tags($this->password));
          $this->active = htmlspecialchars(strip_tags($this->active));          
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':firstName', $this->firstName);
          $stmt->bindParam(':lastName', $this->lastName);
          $stmt->bindParam(':registerId', $this->registerId);
          $stmt->bindParam(':password', $this->password);
          $stmt->bindParam(':active', $this->active);          
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete User
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }