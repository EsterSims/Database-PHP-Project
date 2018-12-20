<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');
  
  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 
   
  try {
    $db = new PDO($dsn, $username, $password);
    // Get method used when selecting Room to update
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      // getting current Rooms in selected building
      $query = 'SELECT * FROM rooms 
              WHERE BuildingID='.$_GET['BuildingID'] .'
              ORDER BY RoomID ';
         $resultSet = $db->query($query);     
      if (empty($errorMessage)) {
        try {
          $statement = $db->prepare($query);
          $statement->execute();
          $result = $statement->fetchAll();
          $statement->closeCursor();
        } catch (PDOException $e) {
          $errorMessage = $e->getMessage();
        }
      }
      // Read Building info from the database
      $BuildingID = $result[0]['BuildingID'];
      $query = 'SELECT * FROM Buildings
              WHERE BuildingID='  .$BuildingID;
             
      if (empty($errorMessage)) {
        try {
          $statement = $db->prepare($query);
          $statement->execute();
          $result1 = $statement->fetchAll();
          $statement->closeCursor();
        } catch (PDOException $e) {
          $errorMessage = $e->getMessage();
        }
      }
    }
    // Check if POST method used and then insert the data. Also check for empty fields
  
    $Count = "";
    $Error = "";
   
  
    // getting current Computers list
    $query = 'SELECT * FROM Computers ORDER BY ComputerID;';
    $resultSet1 = $db->query($query);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $result[0]['BuildingID'] = $_POST['BuildingID'];
  // $result1[0]['BuildingNo'] = $_POST['BuildingNo'];
  // $result1[0]['BuildingName'] = $_POST['BuildingName']; 
  // $BuildingNo = $result1[0]['BuildingNo'];
   //$BuildingName = $result1[0]['BuildingName'];
      $RoomID = $_POST['RoomID'];
      $ComputerID = $_POST['ComputerID'];
      $BuildingID = $_POST['BuildingID'];
      $Count = $_POST['Count'];
   
      // Insert data into RoomComputers table 
      if (empty($errorMessage)) {
        try {
          $query = "INSERT INTO RoomComputers
               (RoomID, BuildingID, ComputerID, Count)
             VALUES
               ('$RoomID', '$BuildingID', '$ComputerID', '$Count')";
          $insert_count = $db->exec($query);
          if ($insert_count < 1) {
            $error = 'Input error, please check all fields and try again.<br />';
            $errorMessage = 'Error inserting RoomComputer.';
          } else {
            // Redirect to RoomComputers listing page
            header('Location: index.php');
          }
        } catch (PDOException $e) {
          $errorMessage = $e->getMessage();
        }
      } 
    }      
  } catch (PDOException $e) {
      $error_message = $e->getMessage();
      echo "<p>An error occurred while connecting to the database: $error_message </p>";
  }
?>
 
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="addroomcomputer" method="post">
    <input type="hidden" name="BuildingID" id="BuildingID" value="<?php echo $result[0]['BuildingID']; ?>" />
    <!--<input type="hidden" name="BuildingNo" id="BuildingNo" value="<?php// echo $result1[0]['BuildingNo']; ?>" />
    <input type="hidden" name="BuildingName" id="BuildingName" value="<?php// echo $result1[0]['BuildingName']; ?>" />-->
    <input type="hidden" name="RoomID" value="<?php echo roomcomputers[$RoomID]; ?>" />
    
    <input type="hidden" name="ComputerID" value="<?php echo roomcomputers[$ComputerID]; ?>" />
  
    <h3>Add RoomComputer</h3>
    All Information Required * <br/><br/>
    
    Building ID / Number - Name: <strong><?php echo $result[0]['BuildingID'] . " / " .$result1[0]['BuildingNo'] . " - " .$result1[0]['BuildingName']; ?></strong><br/><br />  
    Room ID/Number  &nbsp;&nbsp;&nbsp;&nbsp;
    <select name="RoomID">
        <?php foreach ($resultSet as $rooms) : 
            if ($rooms['RoomID'] ==  $roomcomputers['RoomID']) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $rooms['RoomID']; ?>" <?php
                      echo $selected ?>>
               <?php echo $rooms['RoomID'] . "/ " .$rooms['RoomNumber']; ?>
            </option>
        <?php endforeach; ?>
        </select><br><br>
        
    Computer ID / Model &nbsp;&nbsp;&nbsp;&nbsp;
    <select name="ComputerID">
        <?php foreach ($resultSet1 as $computers) : 
            if ($computers['ComputerID'] == $roomcomputers['ComputerID']) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $computers['ComputerID']; ?>" <?php
                      echo $selected ?>>
               <?php echo $computers['ComputerID'] . "/ " .$computers['Model']; ?>
            </option>
        <?php endforeach; ?>
        </select><br><br>
        
    * Count &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="text" name="Count" id="Count"  placeholder="Default value is 0" size = "12" value = "<?php echo $Count; ?>"> <br/><br/>
    <input type="submit" value="Add RoomComputer"><br/><br/>
  </form>
</section>
<?php

  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; ?>