<?PHP
// define database and urers
  $dsn = 'mysql:host=localhost';
  $username = 'root';
  $password = '';
  
  $user='admin';
  $pass='Pa11word';
  $db1="inventory"; 
  
  try {
    //connect to database and create if not exist Same for user 'admin'
    $db = new PDO($dsn, $username, $password);
    
    $db->exec("CREATE DATABASE IF NOT EXISTS `$db1`;
                CREATE USER IF NOT EXISTS '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$db1`.* TO '$user'@'localhost'
                WITH GRANT OPTION;
                FLUSH PRIVILEGES;") ;
                
    //select the database to use            
    $SQLstatement = 'Use inventory;';
    $db->exec($SQLstatement);
    
    //create tables, define primary keys and foreign key constraints
    //create Buildings table
    $SQLstatement = 'CREATE TABLE IF NOT EXISTS Buildings (
    BuildingID         INT           NOT NULL  AUTO_INCREMENT,
    BuildingNo         INT(3)        NOT NULL  UNIQUE, 
    BuildingName       VARCHAR(60)   NOT NULL  UNIQUE, 
    
    PRIMARY KEY (BuildingID)
    );';
    $db->exec($SQLstatement);
    
    //create Rooms table
    $SQLstatement = 'CREATE TABLE IF NOT EXISTS Rooms (
    RoomID             INT            NOT NULL  AUTO_INCREMENT,
    BuildingID         INT            NOT NULL,
    RoomNumber         INT(4)         NOT NULL,
    Capacity           INT(4)         NOT NULL DEFAULT 0,
  
    PRIMARY KEY (RoomID, BuildingID),
    INDEX BuildingID(BuildingID),
    UNIQUE INDEX(BuildingID, RoomNumber),
   
    FOREIGN KEY (BuildingID)
      REFERENCES Buildings(BuildingID)
      ON UPDATE RESTRICT ON DELETE RESTRICT
    );';
    $db->exec($SQLstatement);
   
    //create Vendors table
    $SQLstatement = 'CREATE TABLE IF NOT EXISTS Vendors (
    VendorID            INT            NOT NULL  AUTO_INCREMENT,
    Name                VARCHAR(60)    NOT NULL  UNIQUE,
    Contact             VARCHAR(60)    NOT NULL,
    Phone               VARCHAR(12)    NOT NULL,
  
    PRIMARY KEY (VendorID)
    );';
    $db->exec($SQLstatement);
    
    //create Computers table    
    $SQLstatement = 'CREATE TABLE IF NOT EXISTS Computers (
    ComputerID         INT            NOT NULL  AUTO_INCREMENT,
    VendorID           INT            NOT NULL, 
    Model              VARCHAR(60)    NOT NULL,
    MemorySize         VARCHAR(40)    NOT NULL,
    StorageSize        VARCHAR(40)    NOT NULL,
    
    PRIMARY KEY (ComputerID),
    INDEX VendorID(VendorID),
        
    FOREIGN KEY (VendorID)
      REFERENCES Vendors(VendorID)
      ON UPDATE RESTRICT ON DELETE RESTRICT
    );';
    $db->exec($SQLstatement);
    
    //create RoomComputers table
    $SQLstatement = 'CREATE TABLE IF NOT EXISTS RoomComputers (
    RoomID             INT            NOT NULL,
    BuildingID         INT            NOT NULL,
    ComputerID         INT            NOT NULL,
    Count              INT(4)         NOT NULL  DEFAULT 0,
  
    PRIMARY KEY(RoomID, BuildingID, ComputerID),
    INDEX RoomID(RoomID),
    INDEX BuildingID(BuildingID),
    INDEX ComputerID(ComputerID),
    
    FOREIGN KEY (RoomID, BuildingID)
      REFERENCES Rooms(RoomID, BuildingID)
      ON UPDATE RESTRICT ON DELETE RESTRICT,
      
    FOREIGN KEY (ComputerID)
      REFERENCES Computers(ComputerID)
      ON UPDATE RESTRICT ON DELETE RESTRICT
    );';
    $db->exec($SQLstatement);
    
  //Catching the connection error and displaying it.
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to
             the database: $error_message </p>";
  }
?>