<?php
  require_once('../../util/main.php');
  require_once('../../model/dbinventory.php');
  require_once('../../model/database.php');

  include '../../view/header.php'; 
  include '../../view/sidebar.php'; 

  // Get method used when selecting RoomComputer to delete
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected RoomComputer from the database
    $RoomID = $_GET['RoomID'];
    $BuildingID = $_GET['BuildingID'];
    $ComputerID = $_GET['ComputerID'];
    $query = 'SELECT * FROM RoomComputers
            WHERE RoomID = :RoomID AND BuildingID = :BuildingID AND ComputerID = :ComputerID'; 
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement ->bindValue(':RoomID', $RoomID);
        $statement ->bindValue(':BuildingID', $BuildingID);
        $statement ->bindValue(':ComputerID', $ComputerID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
   // Read Room info from the database
 $RoomID = $result[0]['RoomID'];
 $query = 'SELECT * FROM Rooms
              WHERE RoomID='  .$RoomID;
             
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result3 = $statement->fetchAll();
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
  
  // Read Computer info from the database
 $ComputerID = $result[0]['ComputerID'];
 $query = 'SELECT * FROM Computers
              WHERE ComputerID='  .$ComputerID;
             
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result2 = $statement->fetchAll();
        $statement->closeCursor();
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
 
  // Delete is confirmed with POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $RoomID1 = $_POST['RoomID'];
     $BuildingID1 = $_POST['BuildingID'];
     $ComputerID1 = $_POST['ComputerID'];
     
    // Delete the confirmed RoomComputer from the database 
    $query = 'DELETE FROM RoomComputers
            WHERE RoomID = :RoomID AND BuildingID = :BuildingID AND ComputerID = :ComputerID'; 
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement ->bindValue(':RoomID', $RoomID1);
        $statement ->bindValue(':BuildingID', $BuildingID1);
        $statement ->bindValue(':ComputerID', $ComputerID1);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
       
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }   
    header('Location: index.php');
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to RoomComputers listing page
        header('Location: index.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
   
  // Display if error occurred, else list the RoomComputers
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<section><br/>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="deleteroomcomputer" method="post">
    <h3>Confirm Deletion from RoomComputers table</h3>
    <input type="hidden" name="RoomID" id="RoomID" value="<?php echo $result[0]['RoomID']; ?>" />
    <input type="hidden" name="BuildingID" id="BuildingID" value="<?php echo $result[0]['BuildingID']; ?>" />
    <input type="hidden" name="ComputerID" id="ComputerID" value="<?php echo $result[0]['ComputerID']; ?>" />
    Room ID  / Number &nbsp;-&nbsp;&nbsp;
        <strong><?php echo $result[0]['RoomID']. " / " .$result3[0]['RoomNumber']; ?></strong><br/><br/>
        
       Building ID / Number - Name: <strong><?php echo $result[0]['BuildingID'] . " / " .$result1[0]['BuildingNo'] . " - " .$result1[0]['BuildingName']; ?></strong><br/><br />
       
        Computer ID / Model 
        <strong><?php echo $result[0]['ComputerID']. " / " .$result2[0]['Model']; ?></strong><br/><br/>
     
    Count: <strong><?php echo $result[0]['Count']; ?></strong><br/><br/>
    <input type="submit" value="Delete RoomComputer"><br/><br/>
    To cancel press the back button!<br/><br/><br/><br/>
  </form>
</section>
<?php }
 
  // Close the database connections
  include '../../model/dbclose.php';
 
  // End the HTML code for the page
  include '../../view/footer.php'; 
?>