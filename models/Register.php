<?php 
  class Register {
    // DB stuff
    private $conn;
    private $table = 'register';

    // Register Properties
    public $id;
    public $email;
    public $firstName;
    public $lastName;
    public $shopName;
    public $county;
    public $location;
    public $createdAt;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Registrations
    public function read() {
      // Create query
      $query = 'SELECT id, email, firstName, lastName, shopName, county, location, createdAt 
                                FROM ' . $this->table . '                                 
                                ORDER BY
                                  createdAt DESC';
     
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Registration
    public function read_single() {
          // Create query
          $query = 'SELECT id, email, firstName, lastName, shopName, county, location, createdAt 
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
          $this->shopName = $row['shopName'];
          $this->county = $row['county'];
          $this->location = $row['location'];
          $this->createdAt = $row['createdAt'];
    }

    // Create a Registration
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET email = :email, firstName = :firstName, lastName = :lastName, shopName = :shopName,
          county = :county, location = :location';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->firstName = htmlspecialchars(strip_tags($this->firstName));
          $this->lastName = htmlspecialchars(strip_tags($this->lastName));
          $this->shopName = htmlspecialchars(strip_tags($this->shopName));
          $this->county = htmlspecialchars(strip_tags($this->county));
          $this->location = htmlspecialchars(strip_tags($this->location));
          
          // Bind data
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':firstName', $this->firstName);
          $stmt->bindParam(':lastName', $this->lastName);
          $stmt->bindParam(':shopName', $this->shopName);
          $stmt->bindParam(':county', $this->county);
          $stmt->bindParam(':location', $this->location);
          

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Registration
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET email = :email, firstName = :firstName, lastName = :lastName, shopName = :shopName,
                                county = :county, location = :location
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->firstName = htmlspecialchars(strip_tags($this->firstName));
          $this->lastName = htmlspecialchars(strip_tags($this->lastName));
          $this->shopName = htmlspecialchars(strip_tags($this->shopName));
          $this->county = htmlspecialchars(strip_tags($this->county));
          $this->location = htmlspecialchars(strip_tags($this->location));          
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':firstName', $this->firstName);
          $stmt->bindParam(':lastName', $this->lastName);
          $stmt->bindParam(':shopName', $this->shopName);
          $stmt->bindParam(':county', $this->county);
          $stmt->bindParam(':location', $this->location);          
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Registration
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